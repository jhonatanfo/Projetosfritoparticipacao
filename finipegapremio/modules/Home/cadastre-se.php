<?php
		
	global $Ssx;

	ini_set('display_errors',1);

	load_js('cadastre-se.js');
	load_js('slick.min.js');

	if(UsuarioModel::getSessionLogin()){
		Redirect::url('adicionar-nota-fiscal');
	}
	
	// CASO TENHA O PARAMETRO CODE VINDO DO GOOGLE
	$code = GET::field('code');
	$whatLogin = $Ssx->themes->get_param(1);
	if($code && $whatLogin == 'google'){
		if(!POST::field('enviar') && !POST::field('nome')){
			$usuarioSocialNetwork = GoogleModel::fillForm($code);
			if(isset($usuarioSocialNetwork['hasUser'])){
				Redirect::withMessage(
										sprintf("%s%s",siteurl(),"cadastre-se"),
										[
											"text"   => sprintf("Você já possui um cadastro ativo com essa conta Google.<br> 
														 		 Clique <a href='%s'>aqui</a> para se logar.",GoogleModel::getUrlLogin()),
											"status" => "danger",
											"class"  => ""
										]
									  );	
			}else if($usuarioSocialNetwork){
				$Ssx->themes->assign('usuarioSocialNetwork',$usuarioSocialNetwork);
			}else{
				Redirect::withMessage(
										sprintf("%s%s",siteurl(),"cadastre-se"),
										[
											"text"   => "Problemas ao obter informações do Google. Por favor tente novamente mais tarde.",
											"status" => "danger",
											"class"  => ""
										]
									  );	
			}	
		}
	}

	// CASO TENHA O PARAMETRO CODE VINDO DO FACEBOOK
	$code = GET::field('code');
	$whatLogin = $Ssx->themes->get_param(1);
	if($code && $whatLogin == 'facebook'){
		if(!POST::field('enviar') && !POST::field('nome')){
			$usuarioSocialNetwork = FacebookModel::fillForm($code);
			if(isset($usuarioSocialNetwork['hasUser'])){
				Redirect::withMessage(
										sprintf("%s%s",siteurl(),"cadastre-se"),
										[
											"text"   => sprintf("Você já possui um cadastro ativo com essa conta Facebook.<br> 
														 		 Clique <a href='%s'>aqui</a> para se logar.",FacebookModel::getUrlLogin()),
											"status" => "danger",
											"class"  => ""
										]
									  );	
			}else if($usuarioSocialNetwork){
				$Ssx->themes->assign('usuarioSocialNetwork',$usuarioSocialNetwork);
			}else{
				Redirect::withMessage(
										sprintf("%s%s",siteurl(),"cadastre-se"),
										[
											"text"   => "Problemas ao obter informações do Facebook. Por favor tente novamente mais tarde.",
											"status" => "danger",
											"class"  => ""
										]
									  );	
			}	
		}
	}
	

	$estados = EstadosModel::all($output='array');
	$Ssx->themes->assign('estados',$estados);

	$csrfTokenCadastro = Csrf::generateToken($suffix="Cadastro");
	$Ssx->themes->assign('csrfTokenCadastro',$csrfTokenCadastro);


	if(POST::field('enviar') || POST::field('nome')){
		
		$csrfToken = POST::field('_csrfTokenCadastro');
		if(!Csrf::checkToken($csrfToken,$suffix="Cadastro")){
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"cadastre-se"),
									[
										"text"   => "Formulário inválido!",
										"status" => "danger",
										"class"  => ""
									]
								  );
		}

		$usuario = new UsuarioModel();
		$usuario->{'nome'} = POST::field('nome');
		$usuario->{'sobrenome'} = POST::field('sobrenome');
		$usuario->{'rg'} = POST::field('rg');
		$usuario->{'email'} = POST::field('email');
		$usuario->{'cpf'} = POST::field('cpf');
		$usuario->{'sexo'} = POST::field('sexo') ? strtolower(POST::field('sexo')) : false; 

		$usuario->{'google_login'} = GoogleModel::getLogin()  ? GoogleModel::getLogin() :  "";
		$usuario->{'facebook_login'} = FacebookModel::getLogin() ? FacebookModel::getLogin(): "";
		

		$formato = 'd/m/Y'; // define o formato de entrada para dd/mm/yyyy
		$data = DateTime::createFromFormat($formato, POST::field('data_nascimento')); // define data desejada
		$usDataFormat =  $data->format('Y-m-d'); // formata a saída
		$usuario->{'data_nascimento'} = POST::field('data_nascimento') ? $usDataFormat : "";

		$usuario->{'telefone'} = POST::field('telefone');
		$usuario->{'celular'} = POST::field('celular');

		/*REMOVER CAMPOS DE ENDEREÇO*/
		$usuario->{'cep'} = POST::field('cep');
		$usuario->{'logradouro'} = POST::field('logradouro');
		$usuario->{'numero'} = POST::field('numero');
		$usuario->{'complemento'} = POST::field('complemento');
		$usuario->{'cidade'} = POST::field('cidade');
		$usuario->{'bairro'} = POST::field('bairro');
		$usuario->{'uf'} = POST::field('estado');

		$usuario->{'senha'} = POST::field('senha');
		$usuario->{'conf_senha'} = POST::field('conf_senha');
		$usuario->{'termos'} =  POST::field('termos') ? "SIM" : "";
		$usuario->{'newsletter'} =  POST::field('newsletter') ? "SIM" : "NAO";

		$validateFields = $usuario->validateFields();

		if(is_array($validateFields)){
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"cadastre-se"),
									[
										"text"   => sprintf("%s%s","Campo(s) em branco ou inválido(s)!","<br> - ".implode("<br> - ",$validateFields)),
										"status" => "danger",
										"class"  => ""
									]
								  );
		}	
					
		
		unset($usuario->{'conf_senha'});
		$usuario->{'senha'} = UsuarioModel::generatePassword($usuario->{'cpf'},$usuario->{'senha'});
		$usuario->{'email'} = strtolower($usuario->{'email'});
		$usuario->{'id_fini_usuario'} = $usuario->save();
		if($usuario->{'id_fini_usuario'}){
			if(UsuarioModel::hasSessionLoginFromSocialNetworkActive()){
				UsuarioModel::startSessionLogin($usuario->{'id_fini_usuario'});	
			}else{
				UsuarioModel::authenticateLogin(POST::field('cpf'),POST::field('senha'));	
			}			
			Redirect::withMessage(
								   sprintf("%s%s",siteurl(),"minha-area"),
								   [
								   		"text"   => sprintf("%s","Cadastro efetuado com sucesso!"),
								   		"status" => "success",
								   		"class"  => ""
								   ]
								 );
		}else{
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"cadastre-se"),
									[
										"text"   => "Problemas ao salvar informações. Por favor tente novamente mais tarde.",
										"status" => "danger",
										"class"  => ""
									]
								  );		
		}

	}