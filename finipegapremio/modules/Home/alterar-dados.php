<?php
	
	global $Ssx;

	load_js('alterar-dados.js');
		
	$userSession = UsuarioModel::getSessionLogin();
	if(!$userSession){
		Redirect::url(siteurl());
	}

	if(POST::field('enviar') || POST::field('nome')){

		$csrfTokenAlterarDados = POST::field('_csrfTokenAlterarDados');
		if(!Csrf::checkToken($csrfTokenAlterarDados,$suffix="AlterarDados")){
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"minha-area"),
									[
										"text"=>"Formulário inválido!",
										"status"=>"danger",
										"class"=>""
									]
								  );
		}
		
		$usuario = UsuarioModel::find($userSession['userId']);
		unset($usuario->{'data_alteracao'});
		unset($usuario->{'senha_tmp'});
		$email = $usuario->{'email'};
		$usuario->{'nome'} = POST::field('nome');
		$usuario->{'sobrenome'} = POST::field('sobrenome');
		
		$formato = 'd/m/Y'; // define o formato de entrada para dd/mm/yyyy
		$data = DateTime::createFromFormat($formato, POST::field('data_nascimento')); // define data desejada
		$usDataFormat =  $data->format('Y-m-d'); // formata a saída
		$usuario->{'data_nascimento'} = POST::field('data_nascimento') ? $usDataFormat : "";

		$usuario->{'rg'} = POST::field('rg');
		$usuario->{'email'} = POST::field('email');
		
		
		$usuario->{'sexo'} = POST::field('sexo') ? strtolower(POST::field('sexo')) : false; 
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
		// $usuario->{'termos'} =  POST::field('termos') ? "SIM" : "";
		$usuario->{'newsletter'} =  POST::field('newsletter') ? "SIM" : "NAO";
		
		$changePassword = false;
		if($usuario->{'senha'} != "" || $usuario->{'conf_senha'} != ""){
			if($usuario->{'senha'} != $usuario->{'conf_senha'}){
				Redirect::withMessage(
										sprintf("%s%s",siteurl(),"minha-area"),
										[
											"text"=>"Senhas divergentes",
											"status"=>"danger",
											"class"=>""
										]
									 );
			}
			$changePassword=true;
		}else{
			unset($usuario->{'senha'});
			unset($usuario->{'conf_senha'});
		}

		$checkOneEmail = $usuario->{'email'} != $email && UsuarioModel::where('email',$usuario->{'email'}) ? true : false;
		$checkTwoEmail = $usuario->{'email'} != $email && !validaEmail($usuario->{'email'}) ? true : false;
		if($checkOneEmail || $checkTwoEmail){
			Redirect::withMessage(
										sprintf("%s%s",siteurl(),"minha-area"),
										[
											"text"=>"Email inválido!",
											"status"=>"danger",
											"class"=>""
										]
									 );
		}else{
			unset($usuario->{'email'});
		}

		$checkEstado = in_array($usuario->{'uf'},array('ES','MG','SP','RJ','PR','RS','SC','CE','AM','PB','RN','BA','MA','PI','SE'));
		if($checkEstado === false){
			Redirect::withMessage(
										sprintf("%s%s",siteurl(),"minha-area"),
										[
											"text"=>"Estado inválido!",
											"status"=>"danger",
											"class"=>""
										]
									 );
		}
					
		$validateFields = $usuario->validateFields($alterar_dados=true);
		if(is_array($validateFields)){
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"minha-area"),
									[
										"text" => sprintf("%s%s","Campo(s) em branco ou inválido(s)!","<br> - ".implode("<br> - ",$validateFields)),
										'status' => "danger",
										'class'=>""
									]
								  );
		}

		if($changePassword){
			unset($usuario->{'conf_senha'});
			$usuario->{'senha'} = UsuarioModel::generatePassword($usuario->{'cpf'},POST::field('senha'));	
		}

		$usuario->{'email'} = strtolower(POST::field('email'));

		if($usuario->save()){
			Redirect::withMessage(
								   sprintf("%s%s",siteurl(),"minha-area"),
								   [
								   		"text"=>"SEUS DADOS FORAM ATUALIZADOS com sucesso!",
								   		"status"=>"success",
								   		"class"=>""
								   ]
								 );
		}else{
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"minha-area"),
									[
										"text" => "Problemas ao alterar informações. Por favor tente novamente mais tarde.",
										'status' => "danger",
										'class'=>""
									]
								  );		
		}

	}else{
		Redirect::url(siteurl());
	}