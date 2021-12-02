<?php

class ProdutoModel extends Model{

	
	public $table   = 'fn_produto';
	public $idField = 'id_fini_produto';
	

	public static function searchProductsByKeyword($keyword,$type=""){
		$class = get_called_class();
		$self = new $class;
		$keyword = "%".$keyword."%";
		$type =  in_array(strtolower($type),Array('kit','individual')) ? sprintf(" AND tipo = '%s' ",$type) : "AND tipo =''";
		$sql = sprintf("SELECT id_fini_produto as id,nome FROM %s WHERE nome LIKE '%s' %s LIMIT 5",$self->table,$keyword,$type);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$produtos = $result->fetchAll(PDO::FETCH_CLASS,$class);
		if(is_array($produtos)){
			$newProdutos = [];
			foreach ($produtos as &$produto) {
				$newProdutos[] = $produto->getArrayData();
			}	
			return $newProdutos;
		}
		return false;
	}
	
}