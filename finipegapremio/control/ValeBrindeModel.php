<?php

class ValeBrindeModel extends Model{

	public $table = "fn_vale_brinde";
	public $idField = "id_fini_vale_brinde";
	public $logTimestampOnUpdate = true;

		
	public static $DIR_PLANILHA = '../files/';

	public static  $order_fields = Array(
										"vb.id_fini_vale_brinde" => "ID Vale-brinde",
										"nf.numero" => "Número NF",
										"nf.cnpj" => "CNPJ NF",
										"nf.data_compra" => "Data da Compra NF",
										"u.cpf" => "CPF Usuário",
										"nf.data_criacao" => "Data de Criação NF"
								   );

	public static  $find_fields = Array(
										"vb.id_fini_vale_brinde" => "ID Vale-brinde",
										"nf.numero" => "Número NF",
										"nf.cnpj" => "CNPJ NF",
										"nf.data_compra" => "Data da Compra NF",
										"u.cpf" => "CPF Usuário",
										"nf.data_criacao" => "Data de Criação NF"
								   );

	public 	$hasNext  = true;
	public 	$isNext   = false;
	public 	$rowCount = 0;

	public static function orderFields(){
		$class = get_called_class();
		return $class::$order_fields;
	}
	public static function findFields(){
		$class = get_called_class();
		return $class::$find_fields;
	}

	public static function saveValeBrindeFromPlanilha($filename){
		$dadosPlanilhas = self::getValeBrindeFromPlanilha($filename);
		$dadosPlanilhas = self::improveDadosPlanilha($dadosPlanilhas);
		if(is_array($dadosPlanilhas) && !empty($dadosPlanilhas)){
		 	// APAGA TODAS AS LINHA DA TABELA E AJUSTA O AUTO INCREMENTO PARA 1
			self::rollbackSavePlanilhaValeBrinde();
			
			foreach ($dadosPlanilhas as $celulaInfo) {
				if($celulaInfo['horario_1']){
					$params = Array(
									 "data"    => $celulaInfo['data'],
									 "horario" => $celulaInfo['horario_1'],
									 "premio"  => "KIT"
									);
					self::saveValeBrindeOnDatabase($params);	
				}
				if($celulaInfo['horario_2']){
					$params = Array(
									 "data"    => $celulaInfo['data'],
									 "horario" => $celulaInfo['horario_2'],
									 "premio"  => "KIT"
									);
					self::saveValeBrindeOnDatabase($params);	
				}
				if($celulaInfo['horario_3']){
					$params = Array(
									 "data"    => $celulaInfo['data'],
									 "horario" => $celulaInfo['horario_3'],
									 "premio"  => "KIT"
									);
					self::saveValeBrindeOnDatabase($params);	
				}	
			}
			return true;
		}
		return false;
	}

	public static function improveDadosPlanilha($dadosPlanilhas){
		if(is_array($dadosPlanilhas) && !empty($dadosPlanilhas)){
			foreach ($dadosPlanilhas as &$linha) {
				$linha['horario_1'] = self::replaceSchedule($horario=$linha['horario_1']);
				$linha['horario_2'] = self::replaceSchedule($horario=$linha['horario_2']);
				$linha['horario_3'] = self::replaceSchedule($horario=$linha['horario_3']);
			}	
		}
		return $dadosPlanilhas;
	}

	public static function replaceSchedule($horario){
		if($horario != '--'){
			$horario = str_replace('h', ':', $horario);
			$horario = strlen($horario) == 3 ? sprintf('%s00',$horario): $horario;
			$horario = sprintf('%s:00',$horario);
			$horario = str_pad($horario, 8, "0", STR_PAD_LEFT);
			return $horario;	
		}
		return false;
	}

	public static function rollbackSavePlanilhaValeBrinde(){
		$sql = "DELETE FROM `fn_vale_brinde`;ALTER TABLE `fn_vale_brinde` AUTO_INCREMENT=1";
		$dbn = DatabaseConnection::getInstance();
		$q = $dbn->prepare($sql);
		return $q->execute();		
	}

	public static function saveValeBrindeOnDatabase($params){
		$sql = sprintf("INSERT INTO 
						fn_vale_brinde(data,horario,premio) 
						VALUES
						('%s','%s','%s')",
						$params['data'],
						$params['horario'],
						$params['premio']
					  );	
		$dbn = DatabaseConnection::getInstance();
		$q = $dbn->prepare($sql);
		return $q->execute();
	}

	public static function getValeBrindeFromPlanilha($filename){
		include_once(COREPATH.'resources/PHPExcel/PHPExcel.php');
	    include_once(COREPATH.'resources/PHPExcel/PHPExcel/IOFactory.php');
	    $fileExtension  = explode(".", $filename);
		$fileExtension  = end($fileExtension);
		$fileExtension  = strtolower($fileExtension);
		$versionExcel = "Excel5"; // xls
		if($fileExtension == "xlsx"){
			$versionExcel = "Excel2007"; // xlsx
		}
	    $objReader = PHPExcel_IOFactory::createReader($versionExcel);
	    $objReader->setReadDataOnly(true);
	    $objPHPExcel = $objReader->load(sprintf("%s%s",self::$DIR_PLANILHA,$filename));
	    $objWorksheet = $objPHPExcel->getActiveSheet();
	    $highestRow = $objWorksheet->getHighestRow();
	    $highestColumn = $objWorksheet->getHighestColumn();
	    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	    $array_data = array();
	    $aux=0;
	    for ($row = 2; $row < 42; $row++) {
	        for ($col = 0; $col <= ($highestColumnIndex-1); $col++) {
	        		$cell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row);
	                $value = $cell->getValue();           
	                $value = $value ? $value : '--';
	                // echo sprintf("Linha: %s | Coluna : %s | Valor: %s<br>",$row,$col,$value);
	                switch ($col) {
	                	case '0':
	                		$valueDia  = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'YYYY-MM-DD');
	                		$array_data[$aux]['data'] = $valueDia;
	                		break;
	                	case '2':
	                		$array_data[$aux]['horario_1'] = $value;
	                		break;
	                	case '3':
	                		$value = $value == "--" ? false: $value;
	                		$array_data[$aux]['brinde_horario_1'] = $value;
	                		break;
	                	case '4':
	                		$array_data[$aux]['horario_2'] = $value;
	                		break;
	                	case '5':
	                		$value = $value == "--" ? false: $value;
	                		$array_data[$aux]['brinde_horario_2'] = $value;
	                		break;
	                	case '6':
	                		$array_data[$aux]['horario_3'] = $value;
	                		break;
	                	case '7':
	                		$value = $value == "--" ? false: $value;
	                		$array_data[$aux]['brinde_horario_3'] = $value;
	                		break;
	                	default:
	                		
	                		break;
	                }
	        }
	        $aux++;
	    }	 
	    return is_array($array_data) && !empty($array_data) ? $array_data : false;
	}


	public static function search($limit = 30 ,$offset = 0,$orderBy="id_fini_vale_brinde",$orderBySide="ASC",$where){
		
		$class = get_called_class();
		$self = new $class();
		
		$sql = sprintf("SELECT 
						vb.id_fini_vale_brinde,
						DATE_FORMAT(vb.data,'%s')as data_vb,
						vb.horario as horario_vb,
						vb.status_premio,
						nf.*,
						nf.id_fini_nota_fiscal,
						nf.numero,
						DATE_FORMAT(nf.data_compra,'%s')as data,
						DATE_FORMAT(nf.data_criacao,'%s')as data_criacao,
						SUBSTRING_INDEX(imagem,'.', -1) as imagem_extension,
						IF(nf.data_alteracao IS NOT NULL, DATE_FORMAT(nf.data_alteracao,'%s'),'--') as data_alteracao,
						u.cpf
						FROM %s as vb
						LEFT JOIN fn_nota_fiscal nf
						ON(nf.id_fini_nota_fiscal=vb.id_rel_nota_fiscal)
						LEFT JOIN fn_usuario u
						ON(u.id_fini_usuario=nf.id_rel_usuario)
						%s
						%s",
								'%d/%m/%Y',
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
				$nota->{'produtos'} = NotaFiscalModel::getProductsByIdNf($nota->{'id_fini_nota_fiscal'});
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

	public static function getTotalValeBrindes(){
		$totalValeBrindes = [];
		$totalValeBrindes['em_avaliacao'] = ValeBrindeModel::count($fielter="*",$where = "status_premio='EM_AVALIACAO'");
		$totalValeBrindes['concedido'] = ValeBrindeModel::count($fielter="*",$where = "status_premio='CONCEDIDO'");
		$totalValeBrindes['nao_concedido'] = ValeBrindeNaoConcedidoModel::count($fielter="*",$where = "status_premio='NAO_CONCEDIDO'");
		return $totalValeBrindes;
	}


	public static function exportarValeBrindeToAuditoria(){

		$excel = new Excel();
		
		$titleSheet = "Em avaliação";
		$header = array(
						'ID Vale Brinde','Data Premiação Vale Brinde','Horario Premiação Vale Brinde',
						'Status Auditoria','Número Nota Fiscal','Razao Social Loja Nota Fiscal','CNPJ Nota Fiscal',
						'Data Compra Nota Fiscal','Produtos Nota Fiscal','Nome Usuário','CPF Usuário','CEP Usuário','Endereço Usuário',
						'Imagem Nota Fiscal','Data Cadastro Nota Fiscal','Data Alteração Nota Fiscal'
					   );

		$dados = self::allToRelatorioWithStatus("EM_AVALIACAO");
		$excel->addSheet($titleSheet,$header,$dados);

		$titleSheet = "Concedido";
		$dados = self::allToRelatorioWithStatus("CONCEDIDO");
		$excel->addSheet($titleSheet,$header,$dados);

		$titleSheet = "Não Concedido";
		$dados = ValeBrindeNaoConcedidoModel::allToRelatorioWithStatus("NAO_CONCEDIDO");
		
		$header[] = "Motivo Não Concessão";
		$excel->addSheet($titleSheet,$header,$dados);

		Excel::render($excel,$infoSheet=array(),$extension='xlsx');	

	}

	public static function allToRelatorioWithStatus($status){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT
						vb.id_fini_vale_brinde,
						DATE_FORMAT(vb.data,'%s')as data_vb,
						vb.horario,
						CASE 
							WHEN vb.status_premio = 'CONCEDIDO' THEN 'CONCEDIDO'
							WHEN vb.status_premio = 'NAO_CONCEDIDO' THEN 'NÃO CONCEDIDO'
							ELSE 'EM AVALIAÇÃO'
						END as vb_status,
						CONCAT('\'',nf.numero),CONCAT(lp.nome_razao,' | ',lp.nome_fantasia),nf.cnpj,DATE_FORMAT(nf.data_compra,'%s'),p.produtos,
						UPPER(CONCAT(u.nome,'',u.sobrenome)),
						u.cpf,
						u.cep,
						CONCAT(u.logradouro,', ',u.numero,IF(u.complemento != '',CONCAT(' ',u.complemento),''),' ',u.bairro,', ',u.cidade,'-',u.uf),
						CONCAT('%s',nf.imagem),DATE_FORMAT(nf.data_criacao,'%s'),'--'
						FROM %s vb
						LEFT JOIN fn_nota_fiscal nf
						ON(nf.id_fini_nota_fiscal=vb.id_rel_nota_fiscal)
						LEFT JOIN fn_usuario u
						ON(u.id_fini_usuario=nf.id_rel_usuario)
						LEFT JOIN fn_loja_participante lp
						ON(lp.cnpj=REPLACE(REPLACE(REPLACE(nf.cnpj,'.',''),'-',''),'/',''))
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
						WHERE vb.status_premio = '%s'",
						$dateFormatDataVb="%d/%m/%Y",
						$dateFormatDataCompraNF="%d/%m/%Y",
						$linkUrl = serverurl()."/files/notas-fiscais/",
						$dateFormatDataCriacaoNF="%d/%m/%Y %H:%i:%s",
						$self->table,
						strtoupper($status) 
					   );		
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$notas = $result->fetchAll(PDO::FETCH_ASSOC);	
		return $notas ? $notas : false;
	}


	public static function checkHasInstantPrizeAtTimeByNotaFiscal($notaFiscal){
		
		$class = get_called_class();
		$self = new $class();


		/**
		*  O MODELO ABAIXO E NAO ACUMULATIVO E FOI DESCARTADO,
		*  CONFORME REUNIAO FEITA COM GESTORES DO PROJETO.
		*  07/01/2020
		*/

		// $currentDate = date("Y-m-d");
		// $currentTime = date("H:i:s");
		// $sql = sprintf("SELECT * FROM %s
		// 				WHERE 
		// 				data <= '%s' AND 
		// 				horario <= '%s' AND 
		// 				id_rel_nota_fiscal IS NULL
		// 				ORDER BY horario DESC LIMIT 1",
		// 				$self->table,
		// 				$currentDate,
		// 				$currentTime);

		/*
		* O MODELO ABAIXO E ACUMULATIVO, E RESPEITA A REGUA(planilha com data e horario) DE VALE BRINDE.
		* ESSA REGRA DE NEGOCIO SEGUE ALINHADO COM A REUNIAO FEITA COM OS GESTORES DO PROJETO.
		* 07/01/2020
		*/

		date_default_timezone_set('America/Recife');

		$currentDateTime = date("Y-m-d H:i:s");
		$sql = sprintf("SELECT * FROM %s
						WHERE 
						STR_TO_DATE(CONCAT(data,' ',horario),'%s') <= STR_TO_DATE('%s','%s') AND
						id_rel_nota_fiscal IS NULL
						ORDER BY STR_TO_DATE(CONCAT(data,' ',horario),'%s') ASC LIMIT 1",
						$self->table,
						$STR_TO_DATE_1_FORMAT='%Y-%m-%d %H:%i:%s',
						$currentDateTime,
						$STR_TO_DATE_2_FORMAT='%Y-%m-%d %H:%i:%s',
						$STR_TO_DATE_3_FORMAT='%Y-%m-%d %H:%i:%s');

		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$valeBrinde = $result->fetchObject(__CLASS__);
		if($valeBrinde && $valeBrinde->{'id_rel_nota_fiscal'} == ""){
			$valeBrinde->{'id_rel_nota_fiscal'} = $notaFiscal->{'id_nota_fiscal'};
			if($valeBrinde->save()){
				return true;
			}else{
				return false;
			}			
		}else{
			return false;
		}	
		
	}	

	public static function updateStatusVbAndSendEmail($valeBrinde,$status){
		$nota = NotaFiscalModel::find($valeBrinde->{'id_rel_nota_fiscal'});
		$usuario = UsuarioModel::find($nota->{'id_rel_usuario'});
		if(self::sendEmail($usuario,$premio=$valeBrinde->{'premio'},$status)){
			$valeBrinde->{'status_premio'} = strtoupper($status);
			return $valeBrinde->save();
		}else{
			$valeBrinde->{'status_premio'} = 'EM_AVALIACAO';
			$valeBrinde->save();
			return false;
		}
	}

	public static function updateStatusVb($valeBrinde,$status){
		$nota = NotaFiscalModel::find($valeBrinde->{'id_rel_nota_fiscal'});
		$usuario = UsuarioModel::find($nota->{'id_rel_usuario'});
		$valeBrinde->{'status_premio'} = strtoupper($status);
		if($valeBrinde->{'status_premio'} == 'NAO_CONCEDIDO'){
			// FAZER BACKUP DO VALE BRINDE PARA SER MOSTRADO NA ABA DE NAO CONCEDIDOS
			ValeBrindeModel::createBackupValeBrindeNaoConcedido($valeBrinde);
			return ValeBrindeModel::updateRollbackValeBrinde($valeBrinde);			
		}else{
			return $valeBrinde->save();
		}
	}

	public static function updateRollbackValeBrinde($valeBrinde){
		$class = get_called_class();
		$self = new $class;
		$sql = sprintf("UPDATE %s
						SET
						status_premio = 'EM_AVALIACAO',
						motivo = '',
						id_rel_nota_fiscal = NULL,
						data_alteracao = NULL
						WHERE id_fini_vale_brinde = %s",
						$self->table,
						$valeBrinde->{'id_fini_vale_brinde'}
					);	
		$dbn = DatabaseConnection::getInstance();
		$q = $dbn->prepare($sql);
		return $q->execute();				
	}

	public static function createBackupValeBrindeNaoConcedido($valebrinde){
		$backupValeBrindeNaoConcedido = new ValeBrindeNaoConcedidoModel();
		$backupValeBrindeNaoConcedido->{'data'} = $valebrinde->{'data'};
		$backupValeBrindeNaoConcedido->{'horario'} = $valebrinde->{'horario'};
		$backupValeBrindeNaoConcedido->{'premio'} = $valebrinde->{'premio'};
		$backupValeBrindeNaoConcedido->{'motivo'} = $valebrinde->{'motivo'};
		$backupValeBrindeNaoConcedido->{'id_rel_nota_fiscal'} = $valebrinde->{'id_rel_nota_fiscal'};
		$backupValeBrindeNaoConcedido->{'status_premio'} = $valebrinde->{'status_premio'};
		return $backupValeBrindeNaoConcedido->save();
	}

	public static function replacePremioValueByColumnDb($premio){
		$array = [
					"KIT" => "Vale-brinde",
				 ];
		return $array[$premio];		
	}

	public static function sendEmail($usuario,$premio,$status){
		
		$dadosTemplate = Array(
								"nome" => sprintf("%s %s",$usuario->{'nome'},$usuario->{'sobrenome'}),
								"link" => SITEURL,
								"premio" => self::replacePremioValueByColumnDb($premio)
						  		);
		
		if($status == "concedido"){
			$filenameMailBody = 'vale-brinde-concedido.mail';
		}elseif($status == 'nao_concedido'){
			$filenameMailBody = 'vale-brinde-nao-concedido.mail';
		}else{
			return false;
		}	

		$SsxMail = new SsxMail();
		$body = $SsxMail->emailRenderer($filenameMailBody,$dadosTemplate,false);
		$mail = new PHPMailer();
		$mail->CharSet   = PHPMAILER_CHARSET;
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = PHPMAILER_HOST;
		$mail->SMTPDebug  = PHPMAILER_DEBUG;                     // enables SMTP debug information (for testing)
		$mail->SMTPSecure = PHPMAILER_SMTPSECURE;                 // sets the prefix to the servier
		$mail->SMTPAuth = PHPMAILER_SMTPAUTH;
		$mail->Port       = PHPMAILER_PORT;                   // set the SMTP port for the GMAIL server
		$mail->Username   = PHPMAILER_USERNAME;
		$mail->Password   = PHPMAILER_PASSWORD;
		$mail->SetFrom(EMAILCONTATO,NOMECONTATO);// Mandado Por
		$mail->Subject    = ASSUNTOCONTATO;
		//$mail->AltBody    = ""; // optional, comment out and test
		$mail->MsgHTML($body); // mandar o corpo da mensagem
		$mail->AddAddress($usuario->{'email'},sprintf("%s %s",$usuario->{'nome'},$usuario->{'sobrenome'})); //Setar email que vai ser enviado a mensagem
		if(!$mail->Send()){
			return false;
		}else{
			return true;
		}			
	}


	/** 
	* ESTA FUNÇÃO FOI CRIADA COM O INTUITO DE AJUSTE DA NOTA FISCAL 27,
	* QUE ESTAVA CORRETA POREM FOI ENVIADA PARA VALE-BRINDE NAO CONCEDIDO.
	* ENTÃO O AJUSTE CONSISTE EM REMOVER O LOG DE NAO CONCEDIDO, E DEPOIS,
	* DAR O PRIMEIRO VALE-BRINDE DISPONIVEL PARA NOTA FISCAL.
	* TUDO ISSO FOI PEDIDO E DOCUMENTADO POR EMAIL.
	*/
	public static function rollbackValeBrindeNaoConcedido($idValeBrindeNaoConcedido){
		$valeBrindeNaoConcedido = ValeBrindeNaoConcedidoModel::find($idValeBrindeNaoConcedido);
		if($valeBrindeNaoConcedido){
			$notaFiscal = NotaFiscalModel::find($valeBrindeNaoConcedido->{'id_rel_nota_fiscal'});
			$notaFiscal->{'id_nota_fiscal'} = $notaFiscal->{'id_fini_nota_fiscal'};
			$premiarNotaFiscalObtidadoNaoConcedido = self::checkHasInstantPrizeAtTimeByNotaFiscal($notaFiscal);
			$deleteValeBrindeNaoCondedido =  $valeBrindeNaoConcedido->delete();
			$valeBrinde = ValeBrindeModel::where('id_rel_nota_fiscal',$valeBrindeNaoConcedido->{'id_rel_nota_fiscal'});
			$updateValeBrindeParaConcedido = false;
			if(is_array($valeBrinde) && !empty($valeBrinde)){
				$valeBrinde[0]->{'status_premio'} = "CONCEDIDO";
				$updateValeBrindeParaConcedido = $valeBrinde[0]->save();
			}
			return array(
						"premiarNotaFiscalObtidadoNaoConcedido"=>$premiarNotaFiscalObtidadoNaoConcedido,
						"deleteValeBrindeNaoCondedido" => $deleteValeBrindeNaoCondedido,
						"updateValeBrindeParaConcedido" => $updateValeBrindeParaConcedido
					);
		}else{
			return false;
		}
	}


}