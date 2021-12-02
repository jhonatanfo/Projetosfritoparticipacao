<?php
	
	global $Ssx;

	ini_set('display_errors',1);

	$exportarUsuarios = $Ssx->themes->get_param(2);
	if($exportarUsuarios == "exportar-usuarios"){
		UsuarioModel::exportarUsuarios();
	}

	load_js('cadastros-de-usuarios.js');

	$Ssx->themes->assign('order_fields', UsuarioModel::orderFields());
	$Ssx->themes->assign('find_fields',UsuarioModel::findFields());
	
	$where = null;
  	if(GET::field('wf') && GET::field('wv')){
  		$where = new Where();
  		$where->addClause(GET::field('wf'),'=',GET::field('wv'));
  		$Ssx->themes->assign('whereField',GET::field('wf'));
  		$Ssx->themes->assign('whereValue',GET::field('wv'));
  	}

	$search  = UsuarioModel::search($limit=30,$offset=0,$orderBy="id_fini_usuario",$orderBySide="ASC",$where);
	$usuarios = $search['dados'];
	$tot_cad = UsuarioModel::count();
	$tot_cad_search = $search['rowCount'];
	$Ssx->themes->assign('usuarios',$usuarios);
	$Ssx->themes->assign('tot_cad',$tot_cad);
	$Ssx->themes->assign('tot_cad_search',$tot_cad_search);