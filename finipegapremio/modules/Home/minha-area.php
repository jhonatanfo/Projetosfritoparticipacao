<?php

	global $Ssx;	

	$csrfTokenNotaFiscal = Csrf::generateToken($suffix="NotaFiscal");
	$Ssx->themes->assign('csrfTokenNotaFiscal',$csrfTokenNotaFiscal);


	$csrfTokenAlterarDados = Csrf::generateToken($suffix="AlterarDados");
	$Ssx->themes->assign('csrfTokenAlterarDados',$csrfTokenAlterarDados);


	$csrfTokenConvidar = Csrf::generateToken($suffix="Convidar");
	$Ssx->themes->assign('csrfTokenConvidar',$csrfTokenConvidar);

	$estados = EstadosModel::all($output='array',$filter="uf IN('ES','MG','SP','RJ','PR','RS','SC','CE','AM','PB','RN','BA','MA','PI','SE')");
	$Ssx->themes->assign('estados',$estados);

	load_js('alterar-dados.js');
	load_js('adicionar-nota-fiscal.js');
	load_js('convidar-amigo.js');

	$userSession = UsuarioModel::getSessionLogin();

	$numerosDaSorte = NumeroDaSorteModel::getAllLuckNumberByUserId($userSession['userId']);
 	$Ssx->themes->assign('numerosDaSorte',$numerosDaSorte); 	

	
	if($userSession){
	 	$usuario = UsuarioModel::find($userSession['userId']);
	 	$usuario = $usuario->getArrayData();
	 	$usuario['data_nascimento'] = date_format(date_create($usuario['data_nascimento']),'d/m/Y');
	 	$Ssx->themes->assign('usuario',$usuario);
	}else{
		Redirect::url(siteurl());
	}