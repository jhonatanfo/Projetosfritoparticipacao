<?php


	global $Ssx;

	$GoogleUrlLogin = GoogleModel::getUrlLogin();
	$Ssx->themes->assign('GoogleUrlLogin',$GoogleUrlLogin);

	load_js('contato.js');
	load_js('slick.min.js');
	load_js('jquery.overlayScrollbars.min.js');

	$csrfTokenContato = Csrf::generateToken($suffix="Contato");
	$Ssx->themes->assign('csrfTokenContato',$csrfTokenContato);

	

	$userSession = UsuarioModel::getSessionLogin();
 	if($userSession){

 		Redirect::url(sprintf("%s%s",siteurl(),"minha-area"));

 		$usuario = UsuarioModel::find($userSession['userId']);
 		$notasFiscais = NotaFiscalModel::where('id_rel_usuario',$usuario->{'id_fini_usuario'});
 		$notasFiscais = NotaFiscalModel::replaceFields($notasFiscais);
 		$Ssx->themes->assign('notasFiscais',$notasFiscais);

 		$numerosDaSorte = NumeroDaSorteModel::getAllLuckNumberByUserId($usuario->{'id_fini_usuario'});
 		$Ssx->themes->assign('numerosDaSorte',$numerosDaSorte);

 	}
