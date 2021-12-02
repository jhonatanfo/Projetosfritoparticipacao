<?php

class NotaFiscalModel extends Model{
	
	public $table   = "fn_nota_fiscal";
	public $idField = "id_fini_nota_fiscal";

	public static  $order_fields = Array(
										"id_fini_nota_fiscal" => "ID",
										"nf.numero" => "Número",
										"cnpj" => "CNPJ",
										"data_compra" => "Data da Compra",
										"cpf" => "CPF Usuário",
										"nf.data_criacao" => "Data de Criação"
								   );

	public static  $find_fields = Array(
										"id_fini_nota_fiscal" => "ID",
										"nf.numero" => "Número",
										"cnpj" => "CNPJ",
										"data_compra" => "Data da Compra",
										"cpf" => "CPF Usuário",
										"nf.data_criacao" => "Data de Criação"
								   );	

	public 	$hasNext  = true;
	public 	$isNext   = false;
	public 	$rowCount = 0;


	const MAX_MB_IMAGE_FILE = MAX_MB_IMAGE_FILE;
	const MB = MB;
	public static $ALLOWED_IMAGE_FILE_EXTENSIONS = array('jpeg','jpg','png','pdf');

	public function saveProducts(){
		$idNotaFiscal = $this->{'id_nota_fiscal'};
		$produtos     = $this->{'produtos'};
		$quantidades  = $this->{'quantidades'};
		$count_saves_produto = 0;
		for($i=0;$i<count($produtos);$i++){
			$produto    = $produtos[$i];
			$quantidade = $quantidades[$i];
			$produtoNotaFiscal = new ProdutoNotaFiscalModel();
			$produtoNotaFiscal->{'id_rel_nota_fiscal'} = $idNotaFiscal;
			$produtoNotaFiscal->{'id_rel_produto'}     = $produto;
			$produtoNotaFiscal->{'quantidade'}         = $quantidade;
			if($produtoNotaFiscal->save()){
				$count_saves_produto++;
			}
		}
		if($count_saves_produto == count($produtos)){
			return true;
		}
		return false;
	}

	public function saveLuckNumbers($total_numeros_sorte=0){
		if($total_numeros_sorte){
			$numeroDaSorte = new NumeroDaSorteModel();
			$numeroDaSorte->{'id_rel_nota_fiscal'} = $this->{'id_nota_fiscal'};
			$numeroDaSorte->{'id_rel_usuario'} = $this->{'id_rel_usuario'};
			$total_numeros_sorte_gerados=0;
			for($i=0;$i<$total_numeros_sorte;$i++){
				if($numeroDaSorte->generateLuckNumberAndSerie() &&	$numeroDaSorte->save()){
					$total_numeros_sorte_gerados++;
				}
			}
			if($total_numeros_sorte_gerados == $total_numeros_sorte){
				return true;
			}else{
				return false;	
			}			
		}
		return false;
	}

	public function validateTotalNf(){
		$errorsFields = [];
		$userSession = UsuarioModel::getSessionLogin();				
		if($userSession){
			$userId = $userSession['userId'];
			$totalNf = self::where('id_rel_usuario',$userId);
			if($totalNf){
				$totalNf = count($totalNf);
				$totalNf++;
				if($totalNf > MAX_CAD_NOTA_POR_USR){
					$errorsFields[] = "limite de nota fiscal excedido";
				}
			}
		}
		return count($errorsFields) == 0 ? true : $errorsFields;
	}

	public function validateHasNfAndCnpj($number,$cnpj){
		$errorsFields = [];
		$sql = sprintf("SELECT * FROM %s WHERE numero = '%s' AND cnpj = '%s' ",$this->table,$number,$cnpj);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$nota = $result->fetchObject(__CLASS__);			
		if($nota){
			$errorsFields[] = "nota fiscal já cadastrada";	
		}
		return count($errorsFields) == 0 ? true : $errorsFields;
	}

	public function validateFields(){
		if(count($this->getArrayData())){
			$errorsFields = [];
			$notRequiredFields = ['produtos','quatidades'];
			$dataValues = $this->getArrayData();
			foreach ($dataValues as $key => &$value) {
				if(!in_array($key,$notRequiredFields) && $value == ""){
					switch ($key) {
						case 'data_compra':
							$key = 'data compra';
							break;
						default:
							break;
					}
					$errorsFields[] = $key;
				}
				if($key == "cnpj" && $value && !validaCnpj($value)){
					$errorsFields[] = "cnpj inválido";
				}
				if($key == "data_compra" && $value){
					date_default_timezone_set('America/Recife');
					list($ano,$mes,$dia) = explode('-', $value);
					$post_time  = mktime( 0, 0, 0, $mes, $dia, $ano); 
					$today_time = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$checkOne   = !$dia || !$mes || !$ano ? true : false;
					$checkTwo   = $post_time > $today_time ? true : false;
					$checkThree = $post_time < INI_PROMO ? true : false;
					$checkFour  = $post_time > FIM_PROMO ? true : false;
					if($checkOne){   $errorsFields[] = "data de compra inválida";};
					if($checkTwo){   $errorsFields[] = "data de compra maior que data atual";};
					if($checkThree){ $errorsFields[] = "data de compra menor que inicio da promoção";};
					if($checkFour){  $errorsFields[] = "data de compra maior que fim da promoção";};
				}
			}			
			return count($errorsFields) == 0 ? true : $errorsFields;
		}
		return false;
	}

	

	public function validateProducts(){
		
		$errorsFields  = [];
		$produtos      = $this->{'produtos'};
		$quantidades   = $this->{'quantidades'};
		$tipoProdutos  = $this->{'tipos'};
		$totalProdutos = is_array($produtos) && !empty($produtos) ? count($produtos) : 0;
		$checkOne = $totalProdutos <= 0 ? true : false;
		if($checkOne){
			$errorsFields[] = "total de produtos está inválido. É necessário ao menos um produto";
		}		
		if($totalProdutos){
			$this->{'totalKit'} = 0;
			$qtdKit = Array('kit'=>0,'individual'=>0);
			for($i=0;$i<$totalProdutos;$i++){
				$produto = $produtos[$i];
				$quantidade = $quantidades[$i];
				$tipoProduto = $tipoProdutos[$i];
				if($produto == "" || $quantidade == "" || $tipoProduto == ""){
					$errorsFields[]	 = sprintf("%sº tipo de produto não foi selecionado ou produto está em branco ou a quantidade é inválida",($i+1));
				}else{
					if($tipoProduto == 'KIT'){
						$qtdKit['kit'] += (int)$quantidade;	
					}else{
						$qtdKit['individual'] += (int)$quantidade;
					}
				}
			}	
			$this->{'totalKit'} = ($qtdKit['kit'] + floor($qtdKit['individual']/2));
			if($this->{'totalKit'} < 1){
				$errorsFields[] = sprintf("Limite mínimo 1 kit ou 2 produtos não alcançado.");
			}else if($this->{'totalKit'} > 100){
				$errorsFields[] = sprintf("Limite máximo 100 kit ou 200 produtos exedido.");
			}
		}		
		return count($errorsFields) == 0 ? true : $errorsFields;
	}

	public function validateImage($file){
		$errorsFields = [];
		if(is_array($file) && !empty($file)){
			$checkOne       = $file == false ? true : false;
			$checkTwo       = $file['name'] == "" ? true : false;
			$checkThree     = $file['size'] > (self::MAX_MB_IMAGE_FILE*self::MB);
			
			$fileExtension  = explode(".", $file['name']);
			$fileExtension  = end($fileExtension);
			$fileExtension  = strtolower($fileExtension);
			$checkFour      = array_search($fileExtension,self::$ALLOWED_IMAGE_FILE_EXTENSIONS) === false ? true : false;
			
			if($checkOne){
				$errorsFields[] = "imagem inválida";
			}
			if($checkTwo){
				$errorsFields[] = "nome de imagem inválida";
			}
			if($checkThree){
				$errorsFields[] = "tamanho de imagem inválida";
			}
			if($checkFour){
				$errorsFields[] = "extensão da imagem inválida. extensões permitidas ".implode(',',self::$ALLOWED_IMAGE_FILE_EXTENSIONS);
			}

			return count($errorsFields) == 0 ? true : $errorsFields;
			
		}else{
			$errorsFields[] = "imagem inválida";
			return $errorsFields;
		}		
	}

	public function startUploadFileAndGetFilename($file){
		$fileExtension  = explode(".", $file['name']);
		$fileExtension  = end($fileExtension);
		$fileExtension  = strtolower($fileExtension);

		if($fileExtension == 'pdf'){
			return self::uploadPdf($file);
		}else{
			return self::uploadImage($file);
		}
	}

	public function uploadImage($file){
		$imagem = $file;
		$path_imagem_full = $file['tmp_name'];
		$fileExtension = explode(".", $file['name']);
		$fileExtension = end($fileExtension);
		$fileExtension = strtolower($fileExtension);
		$filename = create_guid().'.'.$fileExtension;
		$fn = $file['tmp_name'];
		$size = getimagesize($fn);
		if($size[0] > 1500 || $size[1] > 1500){
			$ratio = $size[0]/$size[1]; // width/height
			if( $ratio > 1) {
			    $width = 920;
			    $height = 920/$ratio;
			} else {
			    $width = 920*$ratio;
			    $height = 920;
			}
		}else{
			$width = $size[0];
			$height = $size[1];
		}
		$src = imagecreatefromstring(file_get_contents($fn));
		$dst = imagecreatetruecolor($width,$height);
		$new_file_path = COREPATH.'../files/notas-fiscais/'.$filename;
		imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
		imagedestroy($src);
		imagejpeg($dst,$new_file_path,75); // adjust format as needed
		imagedestroy($dst);
		return is_file($new_file_path) ? $filename : false;
	}

	public function uploadPdf($file){
		$dir = 'files/notas-fiscais/';
		$SsxUpload = new SsxUpload($dir);
		$new_file_path = $SsxUpload->uploadFile($file);
		$filename = $new_file_path;
		$new_file_path = is_file($dir.$new_file_path) ? $dir.$new_file_path : false;
		return is_file($new_file_path) ? $filename : false;		
	}

	public static function rollbackSaveNotaFiscal($idNotaFiscal){
		
		$hasDelete =[];
		
		$nota = NotaFiscalModel::find($idNotaFiscal);
		if($nota){
			if($nota->delete()){
				$hasDelete[] = "deletou nota fiscal";
			}
			if(self::deleteImagemByFilename($nota->imagem)){
				$hasDelete[] = "deletou imagem/arquivo da nota fiscal";	
			}		
		}		

		$produtos = ProdutoNotaFiscalModel::where('id_rel_nota_fiscal',$idNotaFiscal);
		if($produtos){
			$count_delete = 0;
			foreach($produtos as $produto){
				if($produto->delete()){
					$count_delete++;
				}
			}
			if($count_delete > 0){
				$hasDelete[] = "deletou produtos da nota fiscal";	
			}			
		}
			
		return count($hasDelete) == 0 ? false : $hasDelete;
	}

	public static function rollbackSaveNotaFiscalAndNumerosDaSorte($idNotaFiscal){
		if(self::rollbackSaveNotaFiscal($idNotaFiscal)){
			$idNotaFiscal = $idRelNotaFiscal;
			if(NumeroDaSorteModel::rollbackSaveLuckNumberByIdRelNotaFiscal($idRelNotaFiscal)){
				return true;
			}
			return false;
		}
		return false;
	}

	public static function deleteImagemByFilename($filename){
		$dir = sprintf("%s%s",COREPATH,"../files/notas-fiscais/");
		$pathtoimg = sprintf("%s%s",$dir,$filename);
		if(is_file($pathtoimg)){
			if(unlink($pathtoimg)){
				return true;
			}
			return false;
		}
		return false;
	}

	public static function replaceFields($notasFiscais){
		if(is_array($notasFiscais)){
			foreach ($notasFiscais as &$notaFiscal) {
				$usuario = UsuarioModel::find($notaFiscal->{'id_rel_usuario'});
				$notaFiscal->{'cpf_usuario'} = $usuario->{'cpf'};
				$notaFiscal->{'produtos'} = self::getProductsByIdNf($notaFiscal->{'id_fini_nota_fiscal'});
				$notaFiscal->{'data_compra'} = date_format(date_create($notaFiscal->{'data_compra'}),'d/m/Y');
				$notaFiscal->{'data_criacao'} = date_format(date_create($notaFiscal->{'data_criacao'}),'d/m/Y H:i:s');
				$notaFiscal->{'data_alteracao'} = $notaFiscal->{'data_alteracao'} ?  date_format(date_create($notaFiscal->{'data_alteracao'}),'d/m/Y H:i:s') : "--";
				switch ($notaFiscal->{'status'}){
					case 'AVALIACAO':
						$notaFiscal->{'status'} = "Em avaliação";
						break;
					case 'PREMIADA':
						$notaFiscal->{'status'} = "Premiada";
						break;
					case 'RECUSADA':
						$notaFiscal->{'status'} = "Recusada";
						break;
					default:
						break;
				}
			}	
		}elseif(is_object($notasFiscais)){
			$notaFiscal = $notasFiscais;
			$usuario = UsuarioModel::find($notaFiscal->{'id_rel_usuario'});
			$notaFiscal->{'cpf_usuario'} = $usuario->{'cpf'};
			$notaFiscal->{'produtos'} = self::getProductsByIdNf($notaFiscal->{'id_fini_nota_fiscal'});
			$notaFiscal->{'data_compra'} = date_format(date_create($notaFiscal->{'data_compra'}),'d/m/Y');
			$notaFiscal->{'data_criacao'} = date_format(date_create($notaFiscal->{'data_criacao'}),'d/m/Y H:i:s');
			$notaFiscal->{'data_alteracao'} = $notaFiscal->{'data_alteracao'} ?  date_format(date_create($notaFiscal->{'data_alteracao'}),'d/m/Y H:i:s') : "--";
			switch ($notaFiscal->{'status'}) {
				case 'AVALIACAO':
					$notaFiscal->{'status'} = "Em avaliação";
					break;
				case 'PREMIADA':
					$notaFiscal->{'status'} = "Premiada";
					break;
				case 'RECUSADA':
					$notaFiscal->{'status'} = "Recusada";
					break;
				default:
					break;
			}
			$notasFiscais = $notaFiscal;
		}else{
			return false;
		}
		return $notasFiscais;
	}	

	public static function getProductsByIdNf($idNotaFiscal){
		$stringProdutos = "";
		if($idNotaFiscal){
			$produtosRel = ProdutoNotaFiscalModel::where('id_rel_nota_fiscal',$idNotaFiscal);
			if(is_array($produtosRel)){
				foreach ($produtosRel as $produtoRel) {

					$produto = ProdutoModel::find($produtoRel->{'id_rel_produto'});
					$nomeProduto = isset($produto->{'nome'}) ? $produto->{'nome'} : "";
					$qntProduto = isset($produtoRel->{'quantidade'}) ? $produtoRel->{'quantidade'} : 0;

					$stringProdutos .= sprintf(" - Produto: %s | Quantidade: %s <br>",$produto->{'nome'},$produtoRel->{'quantidade'});
				}
			}
		}
		return $stringProdutos;
	}


	public static function search($limit = 30 ,$offset = 0,$orderBy="id_fini_nota_fiscal",$orderBySide="ASC",$where){
		
		$class = get_called_class();
		$self = new $class();
		
		$sql = sprintf("SELECT 
						*,
						nf.numero,
						DATE_FORMAT(nf.data_compra,'%s')as data,
						DATE_FORMAT(nf.data_criacao,'%s')as data_criacao,
						SUBSTRING_INDEX(imagem,'.', -1) as imagem_extension,
						IF(nf.data_alteracao IS NOT NULL, DATE_FORMAT(nf.data_alteracao,'%s'),'--') as data_alteracao
						FROM %s as nf
						LEFT JOIN fn_usuario u
						ON(u.id_fini_usuario=nf.id_rel_usuario)
						%s
						%s",				
								'%d/%m/%Y',
								'%d/%m/%Y %H:%i:%s',
								'%d/%m/%Y %H:%i:%s',
								$self->table,
								$where       ? sprintf("WHERE %s", $where->get()) : "",
								$orderBy     ? sprintf("ORDER BY %s %s", $orderBy,$orderBySide) : "" 
						);
			
		$dbn = DatabaseConnection::getInstance();
		
		$q = $dbn->prepare($sql);
		$q->execute();
		$self->{'rowCount'} = $q->rowCount();

		if($limit){
			$sql = sprintf("%s %s %s",
									$sql,
									sprintf("LIMIT %s",  $limit),
									sprintf("OFFSET %s", $offset)
						   );
		}	
				
		$q = $dbn->prepare($sql);
		$q->execute();		
		$notas = $q->fetchAll(PDO::FETCH_CLASS,$class);
		$newNotas = [];
		if(is_array($notas)){
			foreach ($notas as &$nota) {
				unset($nota->{'senha'});
				unset($nota->{'senha_tmp'});
				$nota->{'produtos'} = self::getProductsByIdNf($nota->{'id_fini_nota_fiscal'});
				$nota->{'id_nota_fiscal'} = $nota->{'id_fini_nota_fiscal'};
				$newNotas[] = $nota->getArrayData();
			}
		}

		if( ($limit+$offset) >= $self->{'rowCount'}){
			$self->{'hasNext'} = false;
		}

		if($offset >= 1){
			$self->{'isNext'} = true;
		}

		if(is_array($newNotas) && !empty($newNotas)){
	      return array(
	      				'success' => true,
            			'page'=>$offset,
            			'dados' => $newNotas,
            			'rowCount'=>$self->{'rowCount'},
            			'hasNext'=>$self->{'hasNext'},
            			'isNext'=>$self->{'isNext'}
          );
	    }else{
	    	return array(
	    				"success"=>false,
	    				'page'=>$offset,
	    				'dados'=>$newNotas,
	    				'rowCount'=>$self->{'rowCount'},
	    				'hasNext'=>$self->{'hasNext'},
	    				'isNext'=>$self->{'isNext'}
	    			);
	    }
	    
	}

	public static function orderFields(){
		$class = get_called_class();
		return $class::$order_fields;
	}

	public static function findFields(){
		$class = get_called_class();
		return $class::$find_fields;
	}

	public static function sendEmailStatusNfToUser($nota,$status=""){
		$usuario = UsuarioModel::find($nota->{'id_rel_usuario'});
		if($nota){
			$dadosTemplate = Array(
									"nome" => sprintf("%s %s",$usuario->{'nome'},$usuario->{'sobrenome'}),
									"link" => SITEURL
								);
			$SsxMail = new SsxMail();
			$mailTemplateName =  strtolower($status) == "premiada" ? "nota-fiscal-premiada.mail" : "nota-fiscal-recusada.mail";
			$body = $SsxMail->emailRenderer($mailTemplateName,$dadosTemplate,false);
			$mail = new PHPMailer();
			$mail->CharSet    = PHPMAILER_CHARSET;
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->Host       = PHPMAILER_HOST;
			$mail->SMTPDebug  = PHPMAILER_DEBUG;                     // enables SMTP debug information (for testing)
			$mail->SMTPSecure = PHPMAILER_SMTPSECURE;                 // sets the prefix to the servier
			$mail->SMTPAuth   = PHPMAILER_SMTPAUTH;
			$mail->Port       = PHPMAILER_PORT;                   // set the SMTP port for the GMAIL server
			$mail->Username   = PHPMAILER_USERNAME;
			$mail->Password   = PHPMAILER_PASSWORD;
			$mail->SetFrom($usuario->{'email'},sprintf('%s %s',$usuario->{'nome'},$usuario->{'sobrenome'}));// Mandado Por
			$mail->Subject    = ASSUNTOCONTATO;
			//$mail->AltBody    = ""; // optional, comment out and test
			$mail->MsgHTML($body); // mandar o corpo da mensagem
			$mail->AddAddress($usuario->{'email'},$usuario->{'nome'}); //Setar email que vai ser enviado a mensagem
			if(!$mail->Send()){
				$nota->{'status'} = "AVALIACAO";
				$nota->save();
				return false;
			}else{			
				$nota->{'status'} = "PREMIADA";
				$nota->save();
				return true;
			}
		}
		return false;
	}

	public static function updateStatusNfAndSendEmail($nota, $status = ""){
		return NotaFiscalModel::sendEmailStatusNfToUser($nota,$status);
	}

	public static function getTotalNfs(){
		$totalNfs = [];
		$totalNfs['avaliacao'] = NotaFiscalModel::count($fielter="*",$where = "status='AVALIACAO'");
		$totalNfs['premiada'] = NotaFiscalModel::count($fielter="*",$where = "status='PREMIADA'");
		$totalNfs['recusada'] = NotaFiscalModel::count($fielter="*",$where = "status='RECUSADA'");
		return $totalNfs;
	}

	public static function exportarNotas(){

		ini_set('display_errors',1);
	    ini_set('memory_limit','950M');
		ini_set('max_execution_time', 1200); 
	    include_once(COREPATH.'resources/PHPExcel/PHPExcel.php');
        include_once(COREPATH.'resources/PHPExcel/PHPExcel/IOFactory.php');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex(0)->setTitle('Notas Fiscais');

		$header = array(
							'ID Nota Fiscal','Status Auditoria','Número','CNPJ','Data Compra','Produtos','CPF Usuário',
							'Imagem Nota Fiscal', 'Data Cadastro','Data Alteração'
						);
		$col = 'A';
		foreach($header as $head){
			$objPHPExcel->getActiveSheet()->setCellValue($col."1", $head);    	
			$col++;
		}
		
		$notas = NotaFiscalModel::allToRelatorio();
		if(is_array($notas) && !empty($notas)){
		    $row = 2;
			foreach($notas as $nota){	
				$col = "A";
				foreach($nota->getArrayData() as $key => $value){
					$value = is_null($value) || $value == '' ? '--' : $value;
					$objPHPExcel->getActiveSheet()->setCellValue($col.$row, $value);    	
					$col++;
				}			
				$row++;
			}
		}else{
			$objPHPExcel->getActiveSheet()->setCellValue("A2", "Não possui valores");    	
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getProperties()->setCreator("Promoção Partiu Viajar Com Grupy Kids");
		$objPHPExcel->getProperties()->setLastModifiedBy("Promoção Partiu Viajar Com Grupy Kids");
		$objPHPExcel->getProperties()->setTitle("Promoção Partiu Viajar Com Grupy Kids - Planilha Notas Fiscais");
		$objPHPExcel->getProperties()->setSubject("Planilha Notas Fiscais");
		$objPHPExcel->getProperties()->setDescription("Planilha de relátorios dos cadastros de notas fiscais.");;
		$objPHPExcel->getProperties()->setKeywords("nazca viajar prêmio promoção");
		$objPHPExcel->getProperties()->setCategory("Promoção");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="relatorio_notas_fiscais_promocao_partiu_viaja_com_grupy_kids_'.create_guid().'.xlsx"');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');	// Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter->save('php://output'); 
		die();

	}

	public static function allToRelatorio(){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT 
						nf.id_fini_nota_fiscal,
						CASE 
							WHEN nf.status = 'PREMIADA' THEN 'PREMIADA'
							WHEN nf.status = 'AVALIACAO' THEN 'EM AVALIAÇÃO'
							WHEN nf.status = 'RECUSADA' THEN 'RECUSADA'
							ELSE 'EM PROCESSO'
						END as nf_status,
						CONCAT('\'',nf.numero),nf.cnpj,DATE_FORMAT(nf.data_compra,'%s'),p.produtos,u.cpf,
						CONCAT('%s',nf.imagem),DATE_FORMAT(nf.data_criacao,'%s'),'--'
						FROM %s nf
						LEFT JOIN fn_usuario u
						ON(u.id_fini_usuario=nf.id_rel_usuario)
						LEFT JOIN (
							SELECT GROUP_CONCAT(
								CONCAT(' - Produto: ',p.nome,' , - Qnt: ',rpnf.quantidade)
								SEPARATOR ' | '
							)as produtos,
							rpnf.id_rel_nota_fiscal
							FROM fn_rel_produto_nota_fiscal rpnf
							LEFT JOIN fn_produto p
							ON(p.id_fini_produto=rpnf.id_rel_produto)
							GROUP BY rpnf.id_rel_nota_fiscal
						)AS p ON p.id_rel_nota_fiscal = nf.id_fini_nota_fiscal",
						$date_format="%d/%m/%Y",
						$link_url = serverurl()."/files/notas-fiscais/",
						$date_format="%d/%m/%Y %H:%i:%s",
						$self->table);		
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$notas = $result->fetchAll(PDO::FETCH_CLASS,$class);	
		return $notas ? $notas : false;
	}


	public static function exportarNotasToAuditoria(){

		$excel = new Excel();
		
		$titleSheet = "Em avaliação";
		$header = array(
						'ID Nota Fiscal','Status Auditoria','Número','CNPJ',
						'Data Compra','Produtos','CPF Usuário',
						'Imagem Nota Fiscal', 'Data Cadastro','Data Alteração');

		$dados = self::allToRelatorioWithStatus("AVALIACAO");
		$excel->addSheet($titleSheet,$header,$dados);

		$titleSheet = "Premiadas";
		$dados = self::allToRelatorioWithStatus("PREMIADA");
		$excel->addSheet($titleSheet,$header,$dados);

		$titleSheet = "Recusadas";
		$dados = self::allToRelatorioWithStatus("RECUSADA");
		$excel->addSheet($titleSheet,$header,$dados);

		Excel::render($excel,$infoSheet=array(),$extension='xlsx');	

	}

	public static function allToRelatorioWithStatus($status){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT 
						nf.id_fini_nota_fiscal,
						CASE 
							WHEN nf.status = 'PREMIADA' THEN 'PREMIADA'
							WHEN nf.status = 'AVALIACAO' THEN 'EM AVALIAÇÃO'
							WHEN nf.status = 'RECUSADA' THEN 'RECUSADA'
							ELSE 'EM PROCESSO'
						END as nf_status,
						CONCAT('\'',nf.numero),nf.cnpj,DATE_FORMAT(nf.data_compra,'%s'),p.produtos,u.cpf,
						CONCAT('%s',nf.imagem),DATE_FORMAT(nf.data_criacao,'%s'),'--'
						FROM %s nf
						LEFT JOIN fn_usuario u
						ON(u.id_fini_usuario=nf.id_rel_usuario)
						LEFT JOIN (
							SELECT GROUP_CONCAT(
								CONCAT(' - Produto: ',p.nome,' , - Qnt: ',rpnf.quantidade)
								SEPARATOR ' | '
							)as produtos,
							rpnf.id_rel_nota_fiscal
							FROM fn_rel_produto_nota_fiscal rpnf
							LEFT JOIN fn_produto p
							ON(p.id_fini_produto=rpnf.id_rel_produto)
							GROUP BY rpnf.id_rel_nota_fiscal
						)AS p ON p.id_rel_nota_fiscal = nf.id_fini_nota_fiscal
						WHERE nf.status = '%s'",
						$date_format="%d/%m/%Y",
						$link_url = serverurl()."/files/notas-fiscais/",
						$date_format="%d/%m/%Y %H:%i:%s",
						$self->table,
						strtoupper($status) 
					   );		
		
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$notas = $result->fetchAll(PDO::FETCH_ASSOC);	
		return $notas ? $notas : false;
	}

	public static function getTotalNotasByDate(){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT COUNT(*)as total,DATE_FORMAT(data_criacao,'%s')as data 
						FROM `%s`
						GROUP BY DATE(data_criacao) 
						ORDER BY data_criacao ASC",
						$date_format='%d/%m/%Y',
						$self->table);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		if(is_array($result) && !empty($result)){
			$dados = array(
							"datas"=>array(),
							"totais"=>array()
						  );
			foreach ($result as $arr) {
				if(isset($arr['total']) && isset($arr['data'])){
					$dados['datas'][] = $arr['data'];
					$dados['totais'][] = $arr['total'];
				}
			}
			$result = $dados;
		}
		return $result ? $result : false;	
	}

	public static function getTotaisAuditoriaNotas(){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT COUNT(*)as total,
						CASE 
							WHEN status = 'PREMIADA' THEN 'Premiadas'
							WHEN status = 'AVALIACAO' THEN 'Em avaliação'
							WHEN status = 'RECUSADA' THEN 'Recusadas'
							ELSE 'Em processo'
						END as status
						FROM `%s`
						GROUP BY status
						ORDER BY COUNT(*) ASC",
						$self->table);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		if(is_array($result) && !empty($result)){
			$dados = [];
			foreach ($result as $arr) {
				if(isset($arr['total']) && isset($arr['status'])){
					$dados[$arr['status']] = $arr['total'];
				}
			}
			$result = $dados;
		}
		return $result ? $result : false;			
	}
	
	public static function getTopFiveUsuariosComMaisNotas(){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT COUNT(*)as total,UPPER(CONCAT(u.nome,' ',u.sobrenome)) as nome
						FROM %s nf
						LEFT JOIN fn_usuario u
						ON(u.id_fini_usuario=nf.id_rel_usuario)
						GROUP BY nf.id_rel_usuario
						ORDER BY COUNT(*) DESC,UPPER(CONCAT(u.nome,' ',u.sobrenome)) ASC LIMIT 5",
						$self->table);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		if(is_array($result) && !empty($result)){
			$dados = array(
							"nomes"=>array(),
							"totais"=>array()
						  );
			foreach ($result as $arr) {
				if(isset($arr['total']) && isset($arr['nome'])){
					$dados['nomes'][] = $arr['nome'];
					$dados['totais'][] = $arr['total'];
				}
			}
			$result = $dados;
		}
		return $result ? $result : false;			
	}	

	public static function getTopFiveCnpjComMaisNotas(){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT COUNT(*)as total,nf.cnpj
						FROM %s nf
						GROUP BY nf.cnpj
						ORDER BY COUNT(*) DESC LIMIT 5",
						$self->table);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		if(is_array($result) && !empty($result)){
			$dados = array(
							"cnpjs"=>array(),
							"totais"=>array()
						  );
			foreach ($result as $arr) {
				if(isset($arr['total']) && isset($arr['cnpj'])){
					$dados['cnpjs'][] = $arr['cnpj'];
					$dados['totais'][] = $arr['total'];
				}
			}
			$result = $dados;
		}
		return $result ? $result : false;			
	}

	public static function getMediaCadastrosPorDia(){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT AVG(total)as media FROM(
							SELECT COUNT(*) total
							FROM fn_nota_fiscal
							GROUP BY DATE(data_criacao)
						) as q1",
						$self->table);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$result = $result->fetch(PDO::FETCH_ASSOC);
		return $result ? round(floatval($result['media']),2) : 0;
	}


}
