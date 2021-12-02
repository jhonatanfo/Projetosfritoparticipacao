<?php

	global $Ssx;

	$exportarNotas = $Ssx->themes->get_param(2);
	if($exportarNotas == "exportar-notas-fiscais"){
		NotaFiscalModel::exportarNotas();
	}

	load_js('cadastros-de-notas-fiscais.js');

	$Ssx->themes->assign('order_fields', NotaFiscalModel::orderFields());
	$Ssx->themes->assign('find_fields', NotaFiscalModel::findFields());
	  		
  	$where = null;
  	if(GET::field('wf') && GET::field('wv')){
  		$where = new Where();
  		$where->addClause(GET::field('wf'),'=',GET::field('wv'));
  		$Ssx->themes->assign('whereField',GET::field('wf'));
  		$Ssx->themes->assign('whereValue',GET::field('wv'));
  	}
  	
	$search  = NotaFiscalModel::search($limit=30,$offset=0,$orderBy="id_fini_nota_fiscal",$orderBySide="ASC",$where);
	
	$notas = $search['dados'];
	$tot_cad = NotaFiscalModel::count();
	$tot_cad_search = $search['rowCount'];

	$Ssx->themes->assign('notas',$notas);
	$Ssx->themes->assign('tot_cad',$tot_cad);
	$Ssx->themes->assign('tot_cad_search',$tot_cad_search);