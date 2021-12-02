<?php

	global $Ssx;

	load_js('esqueci-minha-senha.js');

	$csrfTokenLogin = Csrf::generateToken($suffix="Login");
	$Ssx->themes->assign('csrfTokenLogin',$csrfTokenLogin);

	$csrfTokenEsqueci = Csrf::generateToken($suffix="Esqueci");
	$Ssx->themes->assign('csrfTokenEsqueci',$csrfTokenEsqueci);