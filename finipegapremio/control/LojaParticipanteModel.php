<?php

class LojaParticipanteModel extends Model{
	
	public $table = "nz_loja_participante";
	public $idField = "id_nazca_loja_participante";
	public $logTimestampOnUpdate = true;

		
	public static $DIR_PLANILHA = '../files/';
	
	public static function saveLojaParticipanteFromPlanilha($filename,$sheetNumber=0,$rollbackFirst=true,$dadosPlanilhas=null){
		$dadosPlanilhas = $dadosPlanilhas ? $dadosPlanilhas : self::getLojaParticipanteFromPlanilha($filename,$sheetNumber);
		$dadosPlanilhas = self::improveDadosPlanilha($dadosPlanilhas);
		if(is_array($dadosPlanilhas) && !empty($dadosPlanilhas)){
		 	// APAGA TODAS AS LINHA DA TABELA E AJUSTA O AUTO INCREMENTO PARA 1
		 	// $rollbackFirst = $rollbackFirst == true ? self::rollbackSavePlanilhaLojaParticipante(): false;
			foreach ($dadosPlanilhas as $celulaInfo) {
				$celulaInfo['filename'] = $filename;
				self::saveLojaParticipanteOnDatabase($params=$celulaInfo);	
			}
			return true;
		}
		return false;
	}

	public static function improveDadosPlanilha($dadosPlanilhas){
		if(is_array($dadosPlanilhas) && !empty($dadosPlanilhas)){
			foreach ($dadosPlanilhas as &$linha) {
				$linha['cnpj'] = preg_replace("/[^0-9]/", "",$linha['cnpj']);
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

	public static function rollbackSavePlanilhaLojaParticipante(){
		$sql = "DELETE FROM `nz_loja_participante`;ALTER TABLE `nz_loja_participante` AUTO_INCREMENT=1";
		$dbn = DatabaseConnection::getInstance();
		$q = $dbn->prepare($sql);
		return $q->execute();		
	}

	public static function saveLojaParticipanteOnDatabase($params){
		if($params['nome_razao'] == "--"){
			return false;
		}
		$sql = sprintf("INSERT INTO 
						nz_loja_participante
						(
							nome_razao,nome_fantasia,cnpj,endereco,numero,	
							complemento,cep,bairro,cidade,estado,filename
						) 
						VALUES
						(
						 '%s','%s','%s','%s','%s',
						 '%s','%s','%s','%s','%s','%s'
						)",
						$params['nome_razao'],
						$params['nome_fantasia'],
						$params['cnpj'],
						$params['endereco'],
						$params['numero'],
						$params['complemento'],
						$params['cep'],
						$params['bairro'],
						$params['cidade'],
						$params['estado'],
						$params['filename']
					  );	
		$dbn = DatabaseConnection::getInstance();
		$q = $dbn->prepare($sql);
		return $q->execute();
	}

	public static function getLojaParticipanteFromPlanilha($filename,$sheetNumber=0){
		
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

	    $aux=0;
	    $array_data = array();
	    if($sheetNumber > 0){
	    	 for($i=0;$i<$sheetNumber;$i++){
		    	$objPHPExcel->setActiveSheetIndex($i);
			    $objWorksheet = $objPHPExcel->getActiveSheet();
			    $highestRow = $objWorksheet->getHighestRow();
			    $highestColumn = $objWorksheet->getHighestColumn();
			    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			    
			    for ($row = 2; $row < ($highestRow+1); $row++) {
			        for ($col = 0; $col <= ($highestColumnIndex-1); $col++) {
			        		$cell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row);
			                $value = $cell->getValue();           
			                $value = $value ? $value : '--';
			                // echo sprintf("Linha: %s | Coluna : %s | Valor: %s<br>",$row,$col,$value);
			                switch ($col) {
			                	case '0':
			                		$array_data[$aux]['nome_razao'] = $value;
			                		break;
			                	case '1':
			                		$array_data[$aux]['nome_fantasia'] = $value;
			                		break;
			                	case '2':
			                		$array_data[$aux]['cnpj'] = $value;
			                		break;
			                	case '3':
			                		$array_data[$aux]['endereco'] = $value;
			                		break;
			                	case '4':
			                		$array_data[$aux]['numero'] = $value;
			                		break;
			                	case '5':
			                		$value = $value == '--' ? "" : $value; 
			                		$array_data[$aux]['complemento'] = $value;
			                		break;
			                	case '6':
			                		$array_data[$aux]['cep'] = $value;
			                		break;
			                	case '7':
			                		$array_data[$aux]['bairro'] = $value;
			                		break;
			                	case '8':
			                		$array_data[$aux]['cidade'] = $value;
			                		break;
			                	case '9':
			                		$array_data[$aux]['estado'] = $value;
			                		break;
			                	default:
			                		break;
			                }
			        }/* FOR COLUMNS*/
			        $aux++;
			    }/* FOR ROWS*/	
		    } /* FOR SHEETS*/
	    }/* IF SHEETSNUMBER */
	 
	    return is_array($array_data) && !empty($array_data) ? $array_data : false;
	}	


	public static function getLojaParticipanteFromPlanilhaV2($filename,$sheetNumber=0){
		
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

	    $aux=0;
	    $array_data = array();
	    if($sheetNumber > 0){
	    	 for($i=0;$i<$sheetNumber;$i++){
		    	$objPHPExcel->setActiveSheetIndex($i);
			    $objWorksheet = $objPHPExcel->getActiveSheet();
			    $highestRow = $objWorksheet->getHighestRow();
			    $highestColumn = $objWorksheet->getHighestColumn();
			    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			    
			    for ($row = 2; $row < ($highestRow+1); $row++) {
			        for ($col = 0; $col <= ($highestColumnIndex-1); $col++) {
			        		$cell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row);
			                $value = $cell->getValue();           
			                $value = $value ? $value : '--';
			                // echo sprintf("Linha: %s | Coluna : %s | Valor: %s<br>",$row,$col,$value);
			                switch ($col) {
			                	case '3':
			                		$array_data[$aux]['nome_razao'] = $value;
			                		break;
			                	case '4':
			                		$array_data[$aux]['cnpj'] = $value;
			                		break;
			                	case '9':
			                		$array_data[$aux]['endereco'] = $value;
			                		break;
			                	case '12':
			                		$array_data[$aux]['numero'] = $value;
			                		break;
			                	case '8':
			                		$array_data[$aux]['cep'] = $value;
			                		break;
			                	case '7':
			                		$array_data[$aux]['bairro'] = $value;
			                		$nome_fantasia = $nome_fantasia." - ".$value;
			                		$array_data[$aux]['nome_fantasia'] = $nome_fantasia;
			                		break;
			                	case '6':
			                		$nome_fantasia = $value;
			                		$array_data[$aux]['cidade'] = $value;
			                		break;
			                	case '5':
			                		$array_data[$aux]['estado'] = $value;
			                		break;
			                	default:
			                		break;
			                }
			                $array_data[$aux]['complemento']="";
			        }/* FOR COLUMNS*/
			        $aux++;
			    }/* FOR ROWS*/	
		    } /* FOR SHEETS*/
	    }/* IF SHEETSNUMBER */
	    return is_array($array_data) && !empty($array_data) ? $array_data : false;
	}	

	public static function getLojaParticipanteFromPlanilhaV3($filename,$sheetNumber=0){
		
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

	    $aux=0;
	    $array_data = array();
	    if($sheetNumber > 0){
	    	 for($i=0;$i<$sheetNumber;$i++){
		    	$objPHPExcel->setActiveSheetIndex($i);
			    $objWorksheet = $objPHPExcel->getActiveSheet();
			    $highestRow = $objWorksheet->getHighestRow();
			    $highestColumn = $objWorksheet->getHighestColumn();
			    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			    
			    for ($row = 2; $row < ($highestRow+1); $row++) {
			        for ($col = 0; $col <= ($highestColumnIndex-1); $col++) {
			        		$linhasDeTitulos = ['12','13','37','38','43','44','53','54','61','62','64','65','68','69'];
			        		if(!in_array($row, $linhasDeTitulos)){
			        			$cell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row);
				                $value = $cell->getValue();           
				                $value = $value ? $value : '--';
				                // echo sprintf("Linha: %s | Coluna : %s | Valor: %s<br>",$row,$col,$value);
				                switch ($col) {
				                	case '0':
				                		$array_data[$aux]['numero']=$value;
				                		break;
				                	case '1':
				                		$array_data[$aux]['endereco']=trim(strtoupper($value));
				                		break;
				                	case '2':
				                		$array_data[$aux]['bairro']=$value;
				                		break;
				                	case '3':
				                		$array_data[$aux]['cidade']=$value;
				                		break;
				                	case '4':
				                		$array_data[$aux]['estado']=$value;
				                		break;
				                	case '5':
				                		$array_data[$aux]['cep'] = str_replace('.','', $value);
				                		break;
				                	case '6':
				                		$array_data[$aux]['cnpj']=$value;
				                		break;
				                	default:
				                		break;
				                }
				                $array_data[$aux]['nome_fantasia'] = "IAP COSMÉTICOS";
				                $array_data[$aux]['nome_razao'] = strtoupper("Fronteiras Distribuidora Ltda");	
				                $array_data[$aux]['complemento'] = "";
			        		}/* IF DE LINHAS DE TITULOS*/
			        }/* FOR COLUMNS*/
			        $aux++;
			        // echo "----------------<br>";
			    }/* FOR ROWS*/	
		    } /* FOR SHEETS*/
	    }/* IF SHEETSNUMBER */
	    return is_array($array_data) && !empty($array_data) ? $array_data : false;
	}	

	public static function checkHasCnpj($cnpj){
		$cnpj = preg_replace("/[^0-9]/", "",$cnpj);
		$lojaParticipante = self::where('cnpj',$cnpj);
		if($lojaParticipante){
			return true;
		}else{
			return false;
		}
	}

	public function getAll(){
		$sql = "SELECT 
				UPPER(nome_razao) as NOME_RAZAO,
				UPPER(nome_fantasia) as NOME_LOJA,
				UPPER(endereco) as ENDERECO,
				UPPER(numero) as NUMERO,
				UPPER(REPLACE(cep,'.','')) as CEP,
				UPPER(bairro) as BAIRRO,
				UPPER(cidade) as CIDADE,
				UPPER(TRIM(estado)) as ESTADO
				FROM nz_loja_participante
				ORDER BY estado ASC,CONCAT(nome_fantasia,' ',nome_razao) ASC";
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		if(is_array($result) && !empty($result)){
			$lojas = [];
			foreach ($result as $loja) {
				$lojas[$loja["ESTADO"]][] = $loja;
			}	
			return $lojas;
		}
		return false;
	}

}
