<?php

class ValeBrindeNaoConcedidoModel extends Model{
	
	public $table = 'fn_vale_brinde_bkp_nao_concedido';
	public $idField = 'id_fini_vale_brinde';
	public $logTimestampOnInsert = true;

	public static  $order_fields = Array(
										"vb.id_fini_vale_brinde" => "ID Vale-brinde",
										"nf.numero" => "Número NF",
										"nf.cnpj" => "CNPJ NF",
										"nf.data_compra" => "Data da Compra NF",
										"u.cpf" => "CPF Usuário",
										"nf.data_criacao" => "Data de Criação NF"
								   );

	public static  $find_fields = Array(
										"vb.id_fini_vale_brinde" => "ID Vale-brinde",
										"nf.numero" => "Número NF",
										"nf.cnpj" => "CNPJ NF",
										"nf.data_compra" => "Data da Compra NF",
										"u.cpf" => "CPF Usuário",
										"nf.data_criacao" => "Data de Criação NF"
								   );

	public 	$hasNext  = true;
	public 	$isNext   = false;
	public 	$rowCount = 0;

	public static function orderFields(){
		$class = get_called_class();
		return $class::$order_fields;
	}
	public static function findFields(){
		$class = get_called_class();
		return $class::$find_fields;
	}


	public static function search($limit = 30 ,$offset = 0,$orderBy="id_fini_vale_brinde",$orderBySide="ASC",$where){
		
		$class = get_called_class();
		$self = new $class();
		
		$sql = sprintf("SELECT 
						vb.id_fini_vale_brinde,
						DATE_FORMAT(vb.data,'%s')as data_vb,
						vb.horario as horario_vb,
						vb.status_premio,
						vb.motivo,
						nf.*,
						nf.id_fini_nota_fiscal,
						nf.numero,
						DATE_FORMAT(nf.data_compra,'%s')as data,
						DATE_FORMAT(nf.data_criacao,'%s')as data_criacao,
						SUBSTRING_INDEX(imagem,'.', -1) as imagem_extension,
						IF(nf.data_alteracao IS NOT NULL, DATE_FORMAT(nf.data_alteracao,'%s'),'--') as data_alteracao,
						u.cpf
						FROM %s as vb
						LEFT JOIN fn_nota_fiscal nf
						ON(nf.id_fini_nota_fiscal=vb.id_rel_nota_fiscal)
						LEFT JOIN fn_usuario u
						ON(u.id_fini_usuario=nf.id_rel_usuario)
						%s
						%s",
								'%d/%m/%Y',
								'%d/%m/%Y',
								'%d/%m/%Y %H:%i:%s',
								'%d/%m/%Y %H:%i:%s',
								$self->table,
								$where       ? sprintf("WHERE %s", $where->get()) : "",
								$orderBy     ? sprintf("ORDER BY %s %s", $orderBy,$orderBySide) : "" 
						);
		$dbn = DatabaseConnection::getInstance();
		$q = $dbn->prepare($sql);
		$q->execute();
		$self->{'rowCount'} = $q->rowCount();
		if($limit){
			$sql = sprintf("%s %s %s",
									$sql,
									sprintf("LIMIT %s",  $limit),
									sprintf("OFFSET %s", $offset)
						   );
		}	
				
		$q = $dbn->prepare($sql);
		$q->execute();		
		$notas = $q->fetchAll(PDO::FETCH_CLASS,$class);
		$newNotas = [];
		if(is_array($notas)){
			foreach ($notas as &$nota) {
				unset($nota->{'senha'});
				unset($nota->{'senha_tmp'});
				$nota->{'produtos'} = NotaFiscalModel::getProductsByIdNf($nota->{'id_fini_nota_fiscal'});
				$nota->{'id_nota_fiscal'} = $nota->{'id_fini_nota_fiscal'};
				$newNotas[] = $nota->getArrayData();
			}
		}
		if( ($limit+$offset) >= $self->{'rowCount'}){
			$self->{'hasNext'} = false;
		}
		if($offset >= 1){
			$self->{'isNext'} = true;
		}
		if(is_array($newNotas) && !empty($newNotas)){
	      return array(
	      				'success' => true,
            			'page'=>$offset,
            			'dados' => $newNotas,
            			'rowCount'=>$self->{'rowCount'},
            			'hasNext'=>$self->{'hasNext'},
            			'isNext'=>$self->{'isNext'}
          );
	    }else{
	    	return array(
	    				"success"=>false,
	    				'page'=>$offset,
	    				'dados'=>$newNotas,
	    				'rowCount'=>$self->{'rowCount'},
	    				'hasNext'=>$self->{'hasNext'},	
	    				'isNext'=>$self->{'isNext'}
	    			);
	    }
	    
	}

	public static function allToRelatorioWithStatus($status){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT
						vb.id_fini_vale_brinde,
						DATE_FORMAT(vb.data,'%s')as data_vb,
						vb.horario,
						CASE 
							WHEN vb.status_premio = 'CONCEDIDO' THEN 'CONCEDIDO'
							WHEN vb.status_premio = 'NAO_CONCEDIDO' THEN 'NÃO CONCEDIDO'
							ELSE 'EM AVALIAÇÃO'
						END as vb_status,
						CONCAT('\'',nf.numero),CONCAT(lp.nome_razao,' | ',lp.nome_fantasia),nf.cnpj,DATE_FORMAT(nf.data_compra,'%s'),p.produtos,
						UPPER(CONCAT(u.nome,'',u.sobrenome)),
						u.cpf,
						u.cep,
						CONCAT(u.logradouro,', ',u.numero,IF(u.complemento != '',CONCAT(' ',u.complemento),''),' ',u.bairro,', ',u.cidade,'-',u.uf),
						CONCAT('%s',nf.imagem),DATE_FORMAT(nf.data_criacao,'%s'),'--'
						FROM %s vb
						LEFT JOIN fn_nota_fiscal nf
						ON(nf.id_fini_nota_fiscal=vb.id_rel_nota_fiscal)
						LEFT JOIN fn_usuario u
						ON(u.id_fini_usuario=nf.id_rel_usuario)
						LEFT JOIN fn_loja_participante lp
						ON(lp.cnpj=REPLACE(REPLACE(REPLACE(nf.cnpj,'.',''),'-',''),'/',''))
						LEFT JOIN (
							SELECT GROUP_CONCAT(
								CONCAT(' - Produto: ',p.nome,' , - Qnt: ',rpnf.quantidade)
								SEPARATOR ' | '
							)as produtos,
							rpnf.id_rel_nota_fiscal
							FROM fn_rel_produto_nota_fiscal rpnf
							LEFT JOIN fn_produto p
							ON(p.id_fini_produto=rpnf.id_rel_produto)
							GROUP BY rpnf.id_rel_nota_fiscal
						)AS p ON p.id_rel_nota_fiscal = nf.id_fini_nota_fiscal
						WHERE vb.status_premio = '%s'",
						$dateFormatDataVb="%d/%m/%Y",
						$dateFormatDataCompraNF="%d/%m/%Y",
						$linkUrl = serverurl()."/files/notas-fiscais/",
						$dateFormatDataCriacaoNF="%d/%m/%Y %H:%i:%s",
						$self->table,
						strtoupper($status) 
					   );		
		
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$notas = $result->fetchAll(PDO::FETCH_ASSOC);	
		return $notas ? $notas : false;
	}



}
