<?php

class AdminAjaxControl extends SsxAjaxElement {

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

	public function searchUsers($dados){
		$orderby = isset($dados['orderby']) ? $dados['orderby'] : "";
		$orderbyside = isset($dados['orderbyside']) ? $dados['orderbyside'] : "";
		$limit  = isset($dados['limit'])  ? intval($dados['limit']) : 30;
		$offset = isset($dados['offset']) ? intval($dados['offset']) : 0;
		$where = null;
		$whereField = isset($dados['where_field']) ? $dados['where_field'] : "";
		$whereValue = isset($dados['where_value']) ? $dados['where_value'] : "";
		if($whereField && $whereValue){
			$where = new Where();
			$where->addClause($whereField,"LIKE",$whereValue);
		}
		$search = UsuarioModel::search($limit,$offset,$orderby,$orderbyside,$where);
		return $search;
	}   

	public function searchNotas($dados){
		
		$orderby = isset($dados['orderby']) ? $dados['orderby'] : "";
		$orderbyside = isset($dados['orderbyside']) ? $dados['orderbyside'] : "";
		$limit  = isset($dados['limit'])  ? intval($dados['limit']) : 30;
		$offset = isset($dados['offset']) ? intval($dados['offset']) : 0;
		$where = null;
		$whereField = isset($dados['where_field']) ? $dados['where_field'] : "";
		$whereValue = isset($dados['where_value']) ? $dados['where_value'] : "";
		if($whereField && $whereValue){
			$where = new Where();
			if(is_array($whereField) && is_array($whereValue)){
				for($i=0;$i < count($whereField);$i++){
					$whereF = $whereField[$i];
					$whereV = $whereValue[$i];
					if($i > 0){
						$where->whereConcat('AND');
					}
					$where->addClause($whereF,"LIKE",$whereV);		
				}
			}else{
				$where->addClause($whereField,"LIKE",$whereValue);	
			}			
		}
		$search = NotaFiscalModel::search($limit,$offset,$orderby,$orderbyside,$where);
		return $search;
	}


	public function searchValeBrindes($dados){
		
		$orderby = isset($dados['orderby']) ? $dados['orderby'] : "";
		$orderbyside = isset($dados['orderbyside']) ? $dados['orderbyside'] : "";
		$limit  = isset($dados['limit'])  ? intval($dados['limit']) : 30;
		$offset = isset($dados['offset']) ? intval($dados['offset']) : 0;
		$where = null;
		$whereField = isset($dados['where_field']) ? $dados['where_field'] : "";
		$whereValue = isset($dados['where_value']) ? $dados['where_value'] : "";
		if($whereField && $whereValue){
			$where = new Where();
			if(is_array($whereField) && is_array($whereValue)){
				for($i=0;$i < count($whereField);$i++){
					$whereF = $whereField[$i];
					$whereV = $whereValue[$i];
					if($i > 0){
						$where->whereConcat('AND');
					}
					$where->addClause($whereF,"LIKE",$whereV);		
				}
			}else{
				$where->addClause($whereField,"LIKE",$whereValue);	
			}			
		}
		$search = ValeBrindeModel::search($limit,$offset,$orderby,$orderbyside,$where);
		return $search;
	}

	public function managerStatusValeBrinde($dados){

		ini_set('display_errors',1);

		$status = isset($dados['status']) ? $dados['status'] : "";
		$idValeBrinde = isset($dados['id_vale_brinde']) ? $dados['id_vale_brinde'] : "";
		$motivo = isset($dados['motivo']) ? $dados['motivo'] : "";

		/*VERIFICAR SE VALE-BRINDE EXISTE*/
		$valeBrinde = ValeBrindeModel::find($idValeBrinde);

		if($valeBrinde){

			$valeBrinde->{'motivo'} = $motivo;

			if($valeBrinde->{'status_premio'} == 'EM_PROCESSO'){ // CASO UMA SEGUNDA PESSOA QUEIRA ALTERAR O STATUS DA NOTA  BLOQUEIA ATÉ ENVIO DE EMAIL
				return array('success'=>false, "id_vale_brinde" => $idValeBrinde,'error' => 'vale_brinde_em_processo');		
			}else if($valeBrinde->{'status_premio'} == "EM_AVALIACAO"){ 
				$valeBrinde->{'status_premio'} = "EM_PROCESSO";
				$valeBrinde->save();
			}		

			// if(ValeBrindeModel::updateStatusVbAndSendEmail($valeBrinde,$status)){
			if(ValeBrindeModel::updateStatusVb($valeBrinde,$status)){
				
				return array(
							 	"success" => true,
							 	"total_vale_brinde" => ValeBrindeModel::getTotalValeBrindes(),
							 	"id_vale_brinde" => $idValeBrinde
							);	
			}
			
			$nota = NotaFiscalModel::find($valeBrinde->{'id_rel_nota_fiscal'});
			$usuario = UsuarioModel::find($nota->{'id_rel_usuario'});
			return array('success'=>false, "id_vale_brinde" => $idNotaFiscal,'error'=>'email_nao_enviado','email'=>$usuario->{'email'});	
		}
		return array('success'=>false, "id_vale_brinde" => $idNotaFiscal,'error'=>'nota_fiscal_nao_encontrada');
	}
	

}