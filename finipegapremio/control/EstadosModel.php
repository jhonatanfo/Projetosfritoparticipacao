<?php

class EstadosModel extends Model{

	public $table = "fn_estado";
	public $idField = "id";


	public function getCidadesByUfEstado($uf_estado = null){
		if($uf_estado){
			$sql = "SELECT 
					c.nome
					FROM fn_cidade c
					LEFT JOIN fn_estado e
					ON(c.estado=e.id)
					WHERE e.uf = :uf";
			$this->dbn  = DatabaseConnection::getInstance();
			$q = $this->dbn->prepare($sql);
			$q->bindParam(':uf', $uf_estado, PDO::PARAM_STR,2);
			$q->execute();
			$r = $q->fetchAll(PDO::FETCH_ASSOC);
			return $r ? $r : false;
		}
		return false;
	}

}