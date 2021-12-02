<?php
		
	global $Ssx;


	load_js('esqueci-minha-senha.js');


	if(POST::field('enviar') || POST::field('cpf')){

		$csrfTokenEsqueci = POST::field('_csrfTokenEsqueci');
		if(!Csrf::checkToken($csrfTokenEsqueci,$suffix="Esqueci")){
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"participe"),
									[
										"text"   => "Formulário inválido!",
										"status" => "danger",
										"class"  => ""
									]
								  );
		}
		
		$usuario = UsuarioModel::where('cpf',POST::field('cpf'));

		if(is_array($usuario) && !empty($usuario) && UsuarioModel::generateTmpPasswordAndSaveAndSendEmail($usuario[0])){
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"participe"),
									[
										"text"=>"Email com sua senha temporária foi enviado!",
										"status"=>"success",
										"class"=>""
									]
								  );
		}else{

			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"participe"),
									[
										"text"=>"CPF inválido!",
										"status"=>"danger",
										"class"=>""
									]
								  );
		}

	}
	// else{
	// 	Redirect::url(siteurl());
	// }