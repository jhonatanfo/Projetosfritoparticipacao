<?php
	
	global $Ssx;

	$userSession = UsuarioModel::getSessionLogin();
 	if($userSession){
 		$usuario = UsuarioModel::find($userSession['userId']);
		UsuarioModel::dropSessionLogin($usuario);
		Redirect::url(siteurl());
	}
	
	Redirect::url(siteurl());
