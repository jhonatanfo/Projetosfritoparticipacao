<?php

	global $Ssx;

	load_js('contato.js');


	$csrfTokenContato = Csrf::generateToken($suffix="Contato");
	$Ssx->themes->assign('csrfTokenContato',$csrfTokenContato);


	if(POST::field('nome') || POST::field('enviar')){
			
		$csrfToken = POST::field('_csrfTokenContato');
		if(!Csrf::checkToken($csrfToken,$suffix="Contato")){
			Redirect::withMessage(
									siteurl(),
									[
										"text"   => "Formulário inválido!",
										"status" => "danger",
										"class"  => ""
									]
								  );
		}

		$contato = new ContatoModel();

		$contato->{'nome'} = POST::field('nome');
		$contato->{'cpf'} = POST::field('cpf');
		$contato->{'email'} = POST::field('email');
		$contato->{'telefone'} = POST::field('telefone');
		$contato->{'mensagem'} = POST::field('mensagem');
		$validateFields = $contato->validateFields();

		if(is_array($validateFields)){
			
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"contato"),
									[
										"text"   => sprintf("%s%s","Campo(s) em branco ou inválido(s)!","<br> - ".implode("<br> - ",$validateFields)),
										"status" => "danger",
										"class"  => ""
									]
								  );
					
		}else{
			if(ContatoModel::sendEmail($contato) && $contato->save()){
				Redirect::withMessage(
									siteurl(),
									[
										"text"   => "Obrigado pelo contato. Retornaremos em breve!",
										"status" => "success",
										"class"  => ""
									]
								  );					
			}else{

				Redirect::withMessage(
									sprintf("%s%s",siteurl(),"contato"),
									[
										"text"   => "Problemas ao enviar informações. Por favor tente novamente mais tarde.",
										"status" => "danger",
										"class"  => ""
									]
								  );				
			}
			
		}	

	}