<?php
	
	ini_set('display_errors',1);

	global $Ssx;

	load_js('auditoria-vale-brinde.js');

	$exportarValeBrindeToAuditoria = $Ssx->themes->get_param(2);
	if($exportarValeBrindeToAuditoria == "exportar-vale-brinde"){
		ValeBrindeModel::exportarValeBrindeToAuditoria();
	}

	$Ssx->themes->assign('order_fields', ValeBrindeModel::orderFields());
	$Ssx->themes->assign('find_fields', ValeBrindeModel::findFields());

	$status = $Ssx->themes->get_param(2);
	switch (strtolower($status)){
		case 'em_avaliacao':	
			$where = new Where();
			$where->addClause('status_premio','=',strtoupper($status));
			break;
		case 'concedido':
			$where = new Where();
			$where->addClause('status_premio','=',strtoupper($status));
			break;
		case 'nao_concedido':
			$where = new Where();
			$where->addClause('status_premio','=',strtoupper($status));
			break;
		default:
			Redirect::url(siteurl());
			break;
	}

	if(strtolower($status) == 'nao_concedido'){
		$search  = ValeBrindeNaoConcedidoModel::search($limit=30,$offset=0,$orderBy="id_fini_vale_brinde",$orderBySide="ASC",$where);
	}else{
		$search  = ValeBrindeModel::search($limit=30,$offset=0,$orderBy="id_fini_vale_brinde",$orderBySide="ASC",$where);
	}
	
	$valeBrindes = $search['dados'];
	$totalValeBrindes = ValeBrindeModel::getTotalValeBrindes();
	
	$Ssx->themes->assign('valeBrindes',$valeBrindes);
	$Ssx->themes->assign('totCad',$totalValeBrindes[$status]);
	$Ssx->themes->assign('totalValeBrindes',$totalValeBrindes);
	$Ssx->themes->assign('totalValeBrindesGeral',ValeBrindeModel::count());
	$Ssx->themes->assign('statusActive',$status);