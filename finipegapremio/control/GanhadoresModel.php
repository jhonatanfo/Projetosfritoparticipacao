<?php

class GanhadoresModel{

	public static function getAll(){

		$class = get_called_class();
		$self = new $class();

		$sql = "SELECT 
				UPPER(CONCAT(u.nome,' ',u.sobrenome))as nome,
				u.uf as estado,
				vb.premio
				FROM fn_vale_brinde vb
				LEFT JOIN fn_nota_fiscal nf
				ON(vb.id_rel_nota_fiscal=nf.id_fini_nota_fiscal)
				LEFT JOIN fn_usuario u
				ON(nf.id_rel_usuario=u.id_fini_usuario)
				WHERE status_premio = 'CONCEDIDO'
				GROUP BY UPPER(CONCAT(u.nome,' ',u.sobrenome))
				ORDER BY UPPER(CONCAT(u.nome,' ',u.sobrenome)) ASC";

		$dbn = DatabaseConnection::getInstance();
		$q = $dbn->prepare($sql);
		$q->execute();		
		$ganhadores = $q->fetchAll(PDO::FETCH_ASSOC);
		return $ganhadores ? $ganhadores : NULL;
	}
	

}
