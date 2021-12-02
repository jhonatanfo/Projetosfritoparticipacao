<?php


 defined("SSX") or die;

 
 Control::manageEndOfPromotion(the_action(),FIM_PROMO);


 $ganhadores = GanhadoresModel::getAll();
 $Ssx->themes->assign('ganhadores',$ganhadores);

 global $Ssx;

 if(isset($_SESSION['flashMessage'])){
		
	$Ssx->themes->assign('flashMessage',$_SESSION['flashMessage']);
	/*
		HABILITAR A VARIAVEL QUE ABRE O MODAL DE VALE BRINDE. 
		QNDO A PESSOA GANHAR UM VALE-BRINDE APARECERAM DOIS MODAIS NA TELA, 
		MODAL DE CADASTRO E MODAL DE VALE-BRINDE.
	*/
	if(isset($_SESSION['flashMessage']['hasValeBrinde']) && $_SESSION['flashMessage']['hasValeBrinde']){
		$Ssx->themes->assign('hasValeBrinde',$_SESSION['flashMessage']['hasValeBrinde']);
	}
	unset($_SESSION['flashMessage']);
 }

 $fieldToken = $Ssx->themes->get_param(1);
 $valueToken = $Ssx->themes->get_param(2);
 $emailAmigo = null;
 if($fieldToken == "token" && $valueToken){
	if(isset($_SESSION['userId'])){
		unset($_SESSION['userId']);
	}
 }

 $isIndexPages = [
	 				"index",
	 				"como-participar",
	 				"cadastre-se",
	 				"produtos-participantes",
	 				"faq",
	 				"contato",
					"participe",
					 "regulamento"
 				];

 if(in_array(the_action(),$isIndexPages)){
	 $Ssx->themes->assign('isIndex',true);
	 $teste = true;
 }
 

 $userSession = UsuarioModel::getSessionLogin();
 if($userSession){
 	$usuario = UsuarioModel::find($userSession['userId']);
 	$usuario = $usuario->getArrayData();
 	$usuario['data_nascimento'] = date_format(date_create($usuario['data_nascimento']),'d/m/Y');
 	$Ssx->themes->assign('usuario',$usuario);
 }

 $path_to_file = dirname(__FILE__).'/templates';
 $Ssx->themes->assign('path_to_file',$path_to_file);

 $Ssx->themes->set_slug_action('blog');
 // 404 error só pode ser marcado pelo arquivo principal do modulo
 if($Ssx->themes->is_404()){
 	// marca a chamada do template 404.tpl
 	$Ssx->themes->set_404_action();
 }