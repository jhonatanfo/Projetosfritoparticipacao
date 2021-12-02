<?php

class ProdutoNotaFiscalModel extends Model{
	
	public $idField = "id_fini_produto_nota_fiscal";	
	public $table   = "fn_rel_produto_nota_fiscal";

	public static function getTopFiveProductsBestSeller(){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT SUM(quantidade)as total,p.nome
						FROM `%s` pnf
						LEFT JOIN fn_produto p
						ON(pnf.id_rel_produto=p.id_fini_produto)
						GROUP BY id_rel_produto
						ORDER BY SUM(quantidade) DESC LIMIT 5",
						$self->table);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		if(is_array($result) && !empty($result)){
			$dados = array(
							"nomes"=>array(),
							"totais"=>array()
						  );
			foreach ($result as &$arr) {
				if(isset($arr['total']) && isset($arr['nome'])){
					$dados['nomes'][] = $arr['nome'];
					$dados['totais'][] = $arr['total'];
				}
			}
			$result = $dados;
		}
		return $result ? $result : false;	
	}

}
