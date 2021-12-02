<?php
	
	ini_set('display_errors',1);		

	global $Ssx;

	load_js('adicionar-nota-fiscal.js');

	$userSession = UsuarioModel::getSessionLogin();
	if(!$userSession){
		Redirect::url(siteurl());
	}

	if(POST::field('numero') || POST::field('enviar')){

		$csrfTokenNotaFiscal = POST::field('_csrfTokenNotaFiscal');
		if(!Csrf::checkToken($csrfTokenNotaFiscal,$suffix="NotaFiscal")){
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"minha-area"),
									[
										"text"   => "Formulário inválido!",
										"status" => "danger",
										"class"  => ""
									]
								  );
		}

		$nota = new NotaFiscalModel();
		$nota->{'id_rel_usuario'} = $userSession['userId'];
		$nota->{'numero'}         = POST::field('numero');
		
		$formato = 'd/m/Y'; // define o formato de entrada para dd/mm/yyyy
		$data = DateTime::createFromFormat($formato, POST::field('data_compra')); // define data desejada
		$usDataFormat =  $data->format('Y-m-d'); // formata a saída
		$nota->{'data_compra'}    = POST::field('data_compra') ? $usDataFormat : "";
		$nota->{'cnpj'}           = POST::field('cnpj');
		// $nota->{'uf'}			  = POST::field('estado');
		$nota->{'status'}         = 'AVALIACAO';
		$nota->{'produtos'}		  = POST::field('id_produto');
		$nota->{'quantidades'}	  = POST::field('quantidade');
		$nota->{'tipos'}		  = POST::field('tipo');
		
		$fileImage = FILES::field('imagem');		

		$validateImage           = $nota->validateImage($fileImage);
		$validateFields          = $nota->validateFields();
		$validateProducts        = $nota->validateProducts();
		$validateHasNfAndCnpj    = $nota->validateHasNfAndCnpj($nota->{'numero'},$nota->{'cnpj'});

		if(is_array($validateFields) || is_array($validateImage) || is_array($validateProducts) || is_array($validateHasNfAndCnpj)){
			$errorsNota            =  is_array($validateFields)          ? sprintf("%s%s","<br> - ",implode("<br> - ", $validateFields))          : "";
			$errorsImage           =  is_array($validateImage)           ? sprintf("%s%s","<br> - ",implode("<br> - ", $validateImage))           : "";
			$errorsProducts        =  is_array($validateProducts)        ? sprintf("%s%s","<br> - ",implode("<br> - ", $validateProducts))        : "";
			$errorsHasNfAndCnpj    =  is_array($validateHasNfAndCnpj)    ? sprintf("%s%s","<br> - ",implode("<br> - ", $validateHasNfAndCnpj))    : "";

			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"minha-area"),
									[
										"text"   => sprintf("%s%s%s%s%s%s",
																	"<b>Campo(s) em branco ou inválido(s):</b>",
																	$errorsNota,
																	$errorsImage,
																	$errorsProducts,
																	$errorsHasNfAndCnpj
															),
										"status" => "danger",
										"class"  => ""
									]
								  );
		}

		$nota->{'imagem'} = $nota->startUploadFileAndGetFilename($fileImage); // SALVAR IMAGEM
		
		/*
			NO MOMENTO EM QUE EU VALIDO OS PRODUTOS EU OBTENHO O TOTAL DE KITS.

		*/
		$totalKit = $nota->{'totalKit'};

		unset($nota->{'produtos'});
		unset($nota->{'quantidades'});
		unset($nota->{'totalKit'});
		unset($nota->{'tipos'});
		
		$nota->{'id_nota_fiscal'} = $nota->save(); // SALVAR NOTA
		
		if(!$nota->{'id_nota_fiscal'}){ // CASO NAO CONSIGA SALVAR NOTA
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"minha-area"),
									[
										"text"   => "Problemas ao cadastrar nota fiscal. Por favor tente novamente mais tarde.",
										"status" => "danger",
										"class"  => ""
									]
								 );
		}

		$nota->{'produtos'}		  = POST::field('id_produto');
		$nota->{'quantidades'}	  = POST::field('quantidade');
		if(!$nota->saveProducts()){ // CASO NAO CONSIGA SALVAR PRODUTOS
			NotaFiscalModel::rollbackSaveNotaFiscal($nota->{'id_nota_fiscal'});
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"minha-area"),
									[
										"text"   => "Problemas ao cadastrar produtos da nota fiscal. Por favor tente novamente mais tarde.",
										"status" => "danger",
										"class"  => ""
									]
								 );	
		}

		$total_numeros_sorte = $totalKit;
		
		if(!$nota->saveLuckNumbers($total_numeros_sorte)){
			NotaFiscalModel::rollbackSaveNotaFiscalAndNumerosDaSorte($nota->{'id_nota_fiscal'});
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"minha-area"),
									[
										"text"   => "Problemas ao gerar números da sorte. Por favor tente novamente mais tarde.",
										"status" => "danger",
										"class"  => ""
									]
								 );	
		}

		$hasValeBrinde = ValeBrindeModel::checkHasInstantPrizeAtTimeByNotaFiscal($nota);
		$hasValeBrinde =  $hasValeBrinde == true ? "modal-vale-brinde" : false;

		// PROVAVEL CHECAGEM DE PREMIO INSTANTANEO COM IF
		Redirect::withMessage(
									sprintf("%s%s",siteurl(),'minha-area'),
									[
										"text"   => "Nota fiscal cadastrada com sucesso!<br> Veja seu(s) número(s) da sorte gerado na aba números da sorte.",
										"status" => "success",
										"class"  => "",
										"hasValeBrinde" => $hasValeBrinde
									]
								 );		
	}else{
		Redirect::url(siteurl());
	}

	