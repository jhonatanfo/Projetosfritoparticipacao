<?php

class NumeroDaSorteModel extends Model{
		
	public $idField = "id_fini_numero_da_sorte";
	public $table = "fn_numero_da_sorte";
	public $min = 0;
	public $max = NUMERO_DA_SORTE_MAX;
	public $minSerie = 0;
	public $maxSerie = SERIE_MAX;


	public function generateLuckNumberAndSerie(){
		$numerosDaSorteConcatenados = self::getAllAleatoryLuckNumberConcatened();
		$numerosDaSorte = explode(',',$numerosDaSorteConcatenados);
		if(range($this->min,$this->max) === $numerosDaSorte) {
	    	return false;
		}else{			
			do {
	    		$this->{'numero_da_sorte'} =  self::getAleatoryLuckNumber();
	    		$this->{'serie'} = self::getAleatorySerieNumber();
	    		$this->{'numero_da_sorte_e_serie'} = sprintf("%s%s",$this->{'numero_da_sorte'},$this->{'serie'});
			} while(in_array($this->{'numero_da_sorte_e_serie'}, $numerosDaSorte)); //Persiste na geração de número da sorte e série caso ele for um número repitido
			unset($this->{'numero_da_sorte_e_serie'});
			return true;
		}
		return false;
	}

	protected function getAllAleatoryLuckNumberConcatened(){
		$numerosDaSorte = self::all();
		if(is_array($numerosDaSorte) && !empty($numerosDaSorte)){
			$string = "";
			$i=0;
			foreach($numerosDaSorte as &$numeroDaSorte){
				if($i>0){
					$string .= ",";
				}
				$string .= sprintf("%s%s",$numeroDaSorte->{'numero_da_sorte'},$numeroDaSorte->{'serie'});
				$i++;
			}
			return $string;
		}
	}

	protected static function getAleatoryLuckNumber(){
		$class = get_called_class();
        $min   = (new $class())->min;
        $max   = (new $class())->max;
		$numeroDaSorte = rand($min, $max);// Obtém um número entre 0 a 99999 
	    $numeroDaSorte = str_pad($numeroDaSorte, 5, "0", STR_PAD_LEFT);//Ajusta zero da esquerda do número aleatório EX: 1 converte em 00001
	    return $numeroDaSorte;
	}

	protected static function getAleatorySerieNumber(){
		$class = get_called_class();
        $minSerie   = (new $class())->minSerie;
        $maxSerie   = (new $class())->maxSerie;
		$serie = rand($minSerie,$maxSerie);
		$serie = str_pad($serie,2,"0",STR_PAD_LEFT);
		return $serie;	
	}	

	public static function getAllLuckNumberByUserId($idUsuario){
		if($idUsuario){
			$class = get_called_class();
			$self = new $class();
			$sql = sprintf("SELECT 
							ns.numero_da_sorte,ns.serie,
							DATE_FORMAT(nf.data_compra,'%s')as data_compra,
							nf.numero as numero_cupom
							FROM %s ns
							INNER JOIN fn_nota_fiscal nf
							ON(nf.id_fini_nota_fiscal=ns.id_rel_nota_fiscal)
							INNER JOIN fn_usuario u 
							ON(u.id_fini_usuario=ns.id_rel_usuario)
							WHERE u.id_fini_usuario = %s",$formatDataCompra='%d/%m/%Y',$self->table,$idUsuario);
			$dbn = DatabaseConnection::getInstance();
			$result = $dbn->query($sql);
			$r = $result->fetchAll(PDO::FETCH_CLASS,$class);
			return $r ? $r : false;
		}
		return false;
	}

	public static function rollbackSaveLuckNumberByIdRelNotaFiscal($idRelNotaFiscal){
		if($idRelNotaFiscal){
			$class = get_called_class();
			$self = new $class();
			$sql = sprintf("DELETE FROM %s WHERE id_rel_nota_fiscal = %s",$self->table,$idRelNotaFiscal);
			$dbn = DatabaseConnection::getInstance();
			$q = $dbn->prepare($sql);
			return $q->execute();		
		}
		return false;
	}

}