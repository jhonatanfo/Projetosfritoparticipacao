<?php
	
	ini_set('display_errors',1);
		
	$whatLogin = $Ssx->themes->get_param(1);
	$code = GET::field('code');

	if($code && $whatLogin == 'google'){
		$usuario = GoogleModel::login($code);
		if(is_array($usuario) && isset($usuario['hasNotUser'])){
			Redirect::withMessage(
						sprintf("%s%s",siteurl(),"participe"),
						[
							"text"=>sprintf("Usuário não encontrado.<br>
											 Clique <a href='%s'>aqui</a> para fazer o seu cadastro com Google.",GoogleModel::getUrlCadastro()),
							"status"=>"danger",
							"class"=>""
						]
					  );	
		}else if(is_object($usuario)){
			if(UsuarioModel::startSessionLogin($usuario->{'id_fini_usuario'})){
				Redirect::url(sprintf("%s%s",siteurl(),""));
			}else{
				Redirect::withMessage(
						sprintf("%s%s",siteurl(),"participe"),
						[
							"text"=>"Erro ao fazer login. Por favor confira os campos e tente novamente!",
							"status"=>"danger",
							"class"=>""
						]
					  );	
			}
		}else{
			Redirect::withMessage(
						sprintf("%s%s",siteurl(),"participe"),
						[
							"text"=>"Erro ao fazer login. Por favor confira os campos e tente novamente!",
							"status"=>"danger",
							"class"=>""
						]
					  );
		}
	}

	if($code && $whatLogin == 'facebook'){
		$usuario = FacebookModel::login($code);
		if(is_array($usuario) && isset($usuario['hasNotUser'])){
			Redirect::withMessage(
						sprintf("%s%s",siteurl(),"participe"),
						[
							"text"=>sprintf("Usuário não encontrado.<br>
											 Clique <a href='%s'>aqui</a> para fazer o seu cadastro com Facebook.",FacebookModel::getUrlCadastro()),
							"status"=>"danger",
							"class"=>""
						]
					  );	
		}else if(is_object($usuario)){
			if(UsuarioModel::startSessionLogin($usuario->{'id_fini_usuario'})){
				Redirect::url(sprintf("%s%s",siteurl(),""));
			}else{
				Redirect::withMessage(
						sprintf("%s%s",siteurl(),"participe"),
						[
							"text"=>"Erro ao fazer login. Por favor confira os campos e tente novamente!",
							"status"=>"danger",
							"class"=>""
						]
					  );	
			}
		}else{
			Redirect::withMessage(
						sprintf("%s%s",siteurl(),"participe"),
						[
							"text"=>"Erro ao fazer login. Por favor confira os campos e tente novamente!",
							"status"=>"danger",
							"class"=>""
						]
					  );
		}
	}

	if(POST::field('cpf') || POST::field('enviar')){

		$csrfTokenLogin = POST::field('_csrfTokenLogin');
		if(!Csrf::checkToken($csrfTokenLogin,$suffix="Login")){
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"participe"),
									[
										"text"=>"Formulário inválido!",
										"status"=>"danger",
										"class"=>""
									]
								  );
		}

		$login = POST::field('cpf');
		$senha = POST::field('senha');
		
		if(UsuarioModel::authenticateLogin($login,$senha)){
			Redirect::url(sprintf("%s%s",siteurl(),"minha-area"));
		}else{
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"participe"),
									[
										"text"=>"Erro ao fazer login. Por favor confira os campos e tente novamente!",
										"status"=>"danger",
										"class"=>""
									]
								  );
		}				
	}else{
		Redirect::url(siteurl());
	}