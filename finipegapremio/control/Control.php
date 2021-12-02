<?php

class Control{

	public $notAllowedActionsAfterFinalDate = Array( 
													  'minha-area','cadastre-se',
													  'participe','adicionar-nota-fiscal',
													  'alterar-dados'
													);
	
	public $formatDateAtual;
	

	public static function manageEndOfPromotion($action,$dateFinalPromocao){
		
		$class = get_called_class();
		$self = new $class;

		date_default_timezone_set('America/Recife');

		$self->formatDateAtual = mktime(date('H'),date('i'),date('s'),date("m"),date("d"),date("Y"));
		
		if($self->formatDateAtual > $dateFinalPromocao && in_array($action, $self->notAllowedActionsAfterFinalDate)){
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),""),
									[
										"text"   => "Promoção encerrada!",
										"status" => "danger",
										"class"  => ""
									]
								  );
			die();
		}	
		return false;
	}

	public function getEnderecoByCep($cep = null){
		if($cep){
			$cep = preg_replace("/[^0-9]/i", "", $cep);
			$dados = file_get_contents("http://viacep.com.br/ws/".$cep."/json/");
			$dados = json_decode($dados,1);
			return $dados;		        
		}
		return false;
	}
		
}