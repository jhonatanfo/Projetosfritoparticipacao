	<?php

class AjaxControl extends SsxAjaxElement {

	/*
		Para usar ajax ssx
		ex:
		<script>
			Ssx.ajax("nomeDaClasseAjax_nomedaFuncaonaClasse",dadosDeEntrada,"nomeDaFuncaoCallback");
			nomeDaFuncaoCallback(respostadoajax){
				console.log(respostadadoajax);
			}
		</script>
	*/

	public function getEnderecoByCep($dados){
		$control =new Control();
		if(is_array($dados) && !empty($dados)){
			$cep = $dados['cep'];
			$endereco  = $control->getEnderecoByCep($cep);
			if(is_array($endereco) && !empty($endereco)){
				return array('success'=>true,'endereco'=>$endereco);
			}
			return array("success"=>false);			
		}
		return array("success"=>false);		
	}    

	public function getAllCidadesByNomeUf($dados){
		$estadoModel = new EstadosModel();
		if(is_array($dados) && !empty($dados)){
			$uf = $dados['uf'];
			$cidades = $estadoModel->getCidadesByUfEstado($uf);
			if(is_array($cidades) && !empty($cidades)){
				return array('success'=>true,'cidades'=>$cidades);
			}
		}
		return array("success"=>false);		
	}

	public function getEmail($dados){
		if(is_array($dados) && !empty($dados)){
			$email = $dados['email'];
			$hasEmail = UsuarioModel::where('email',$email) ? true : false;
			$userSession = UsuarioModel::getSessionLogin();
			if($userSession){
			 	$usuario = UsuarioModel::find($userSession['userId']);
			 	$usuario = $usuario->getArrayData();
			 	if($usuario['email'] == $email){
					return array("hasEmail"=>false);	 			
			 	}
				return array("hasEmail"=>$hasEmail);	 				 	
			}
			return array('hasEmail'=>$hasEmail);
		}
		return array("hasEmail"=>true);
	}

	public function getCpf($dados){
		if(is_array($dados) && !empty($dados)){
			$cpf = $dados['cpf'];
			$hasCpf = UsuarioModel::where('cpf',$cpf) ? true : false;
			$userSession = UsuarioModel::getSessionLogin();
			if($userSession){
			 	$usuario = UsuarioModel::find($userSession['userId']);
			 	$usuario = $usuario->getArrayData();
			 	if($usuario['cpf'] == $cpf){
					return array("hasCpf"=>false);	 			
			 	}
				return array("hasCpf"=>$hasCpf);	 				 	
			}
			return array('hasCpf'=>$hasCpf);
		}
		return array("hasCpf"=>true);
	}

	public function validateHasNfAndCnpj($dados){
		if(is_array($dados) && !empty($dados)){
			if(isset($dados['numero']) && $dados['numero'] && isset($dados['cnpj']) && $dados['cnpj']){
				$nota = new NotaFiscalModel();	
				$numero = $dados['numero'];
				$cnpj = $dados['cnpj'];
				$validateHasNfAndCnpj = $nota->validateHasNfAndCnpj($numero,$cnpj);
				if(is_array($validateHasNfAndCnpj)){
					return array("success"=>true,"hasNota"=>true);
				}else{
					return array("success"=>true,"hasNota"=>false);				
				}				
			}
			return array("success"=>false);		
		}
		return array("success"=>false);
	}

	public function validateHasCnpj($dados){
		if(is_array($dados) && !empty($dados)){
			$cnpj = isset($dados['cnpj']) ? $dados['cnpj'] : false;
			return array("success"=> LojaParticipanteModel::checkHasCnpj($cnpj));
		}
		return array("success"=>false);	
	}


	public function searchProducts($dados){
		$keyword = (isset($dados['keyword']) ? $dados['keyword'] : "");
		$type = (isset($dados['type']) ? $dados['type'] : "");
		$produtos = ProdutoModel::searchProductsByKeyword($keyword,$type);
		if($produtos){
			return array("success"=>true,"produtos"=>$produtos);
		}else{
			return array("success"=>false,"produtos"=>[]);
		}
	}

	public function getAllLojas($dados){
		$lojas = LojaParticipanteModel::getAll();
		if(is_array($lojas) && !empty($lojas)){
			return array("success"=>true,"lojas"=>$lojas);
		}else{
			return array("success"=>true,"lojas"=>$lojas);	
		}
	}

}