<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h3>
				Auditoria 
				<small>
					Vale Brinde
					<button class="btn btn-xs btn-primary" type="button">
                        Total <span class="badge">{$totalValeBrindesGeral}</span>
                    </button> 
					 <a href="{$siteurl}fini/auditoria-vale-brinde/exportar-vale-brinde" class="btn btn-xs btn-success">
                        <i class="glyphicon glyphicon-download-alt"></i> Exportar
                    </a> 
				</small>
			</h3>
		</div>	
	</div>	
</div>

<!-- Modal -->
<div class="modal fade defaultModal" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Informação</h4>
      </div>
      <div class="modal-body">
      			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success btn-submit-function">OK</button>
      </div>
    </div>
  </div>
</div>

<div class="row">
	<div class="col-md-12">
		
		<!-- 
		<div class="alert alert-warning alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> 
			<strong>Aviso!</strong> Para a premiação de nota fiscal é necessário o cadastro de códigos uber que é feito na área planilhas códigos Uber. 
		</div>
		 -->

		<div class="bs-example bs-example-tabs" data-example-id="togglable-tabs"> 
			
			<ul class="nav nav-tabs" id="myTabs" role="tablist"> 
				<li role="presentation" {if $statusActive eq 'em_avaliacao'} class="active" {/if}>
					<a href="{$siteurl}fini/auditoria-vale-brinde/em_avaliacao" id="home-tab" >
						Em avaliação <span class="total-avaliada">({$totalValeBrindes.em_avaliacao})</span>
					</a>
				</li> 
				<li role="presentation" {if $statusActive eq 'concedido'} class="active"{/if}>
				   <a href="{$siteurl}fini/auditoria-vale-brinde/concedido" id="home-tab">
						Concedidos <span class="total-concedidos">({$totalValeBrindes.concedido})</span>
					</a>
				</li> 
				<li role="presentation" {if $statusActive eq 'nao_concedido'} class="active"{/if}>
					<a href="{$siteurl}fini/auditoria-vale-brinde/nao_concedido" id="home-tab">
						Não Concedidos <span class="total-nao-concedidos">({$totalValeBrindes.nao_concedido})</span>
					</a>
				</li> 
			</ul> 

			<div class="tab-content" id="myTabContent"> 
				<!-- STATUS NOTA -->
				<input type="hidden" name="" class="ipt-status" value="{$statusActive}">
				<div class="tab-pane fade {if $statusActive eq 'em_avaliacao'}active in{/if}" role="tabpanel" id="avaliacao" aria-labelledby="avaliacao-tab" style="padding: 25px 5px;"> 
					{if isset($valeBrindes) && $statusActive eq 'em_avaliacao'}
					<div class="row">					
						<!-- BUSCADOR -->
					    <div class="col-md-12">
					        <div class="col-md-12 col-xs-12 no-padding" style="padding: 0">
					            <form class="form form-inline form-search" style="margin-bottom: 7px;">
					            <div class="pull-left">
					                <div class="form-group">
					                    <div class="rotulo">
					                        <span>Buscar Por</span> 
					                    </div>                      
					                    <select class="form-control where btn-sm">
					                        {foreach key=key item=item from=$find_fields}
					                            <option value="{$key}">{$item}</option> 
					                        {/foreach}
					                    </select>
					                </div>          
					                <div class="form-group">
					                    <div class="rotulo">
					                        <span>Palavra Chave</span>  
					                    </div>      
					                    <div class="input-group">
					                      <input type="text" class="form-control find-value" name="find_value">
					                      <span class="input-group-btn">
					                        <button class="btn btn-primary btn-find-value" type="button">&nbsp;<span class="glyphicon glyphicon-search"></span></button>
					                      </span>
					                    </div>
					                </div>
					                <div class="form-group" style="margin-top: 20px;">
					                    <button type="button" class="btn btn-danger btn-clear-find" style="display: none;">&nbsp;<span class="glyphicon glyphicon-trash"></span></button>
					                </div>
					                <div class="label-count-results">
					                    <span class="pull-left" style="margin: 5px 5px;">Busca obteve <span class="count-result">{$totCad}</span> resultados</span>
					                </div>
					            </div>
					        </div>
					        </form>                 
					    </div>  
					    <!-- FIM BUSCADOR -->
					</div>		

				    <div class="row">   
				    	<!-- LISTA FEITOS -->
					    <div class="col-md-12">     
					        {if isset($valeBrindes)}

					            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					                {assign var="contador" value="0"}
					                {foreach $valeBrindes as $valeBrinde}   
					                  <div class="panel panel-warning panel-id-{$valeBrinde.id_fini_vale_brinde}">
					                    <div class="panel-heading" role="tab" id="heading{$valeBrinde.id_fini_vale_brinde}">
					                      <h4 class="panel-title">
					                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{$valeBrinde.id_fini_vale_brinde}" aria-expanded="true" aria-controls="collapse{$valeBrinde.id_fini_vale_brinde}" style="font-size:14px;">
					                         <span class="glyphicon glyphicon-list-alt"></span> ID Vale-brinde: {$valeBrinde.id_fini_vale_brinde} | Data : {$valeBrinde.data_vb} | Horário: {$valeBrinde.horario_vb} | Número NF : <span class="numero-nf">{if isset($valeBrinde.id_fini_nota_fiscal)}{$valeBrinde.numero}{else} -- {/if}</span>
					                        </a>
					                      </h4>
					                    </div>
					                    <div id="collapse{$valeBrinde.id_fini_vale_brinde}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{$valeBrinde.id_fini_vale_brinde}">
					                      <div class="panel-body">
					                       <div class="table-responsive">
					                        <table class="table table-bordered">                

					                            <tbody>
					                            	{if isset($valeBrinde.id_fini_nota_fiscal)}
					                                <tr>
					                                    <td>ID Vale-brinde</td>
					                                    <td>{$valeBrinde.id_fini_vale_brinde}</td>
					                                </tr>
					                                 <tr>
					                                	<td>
					                                		Data/Horário Vale-brinde
					                                	</td>
					                                	<td>
					                                		{$valeBrinde.data_vb} {$valeBrinde.horario_vb}
					                                	</td>
				                                	</tr>
					                                <tr>
					                                    <td>Número NF</td>
					                                    <td>
					                                    	<a href="{$siteurl}fini/cadastros-de-notas-fiscais?wf=id_fini_nota_fiscal&wv={$valeBrinde.id_nota_fiscal}" target="_blank">
					                                    		{$valeBrinde.numero}
					                                    	</a>
					                                    </td>
					                                </tr>
					                                <tr>
					                                    <td>CNPJ NF</td>
					                                    <td>
					                                        <a href="{$siteurl}fini/cadastros-de-notas-fiscais?wf=cnpj&wv={urlencode($valeBrinde.cnpj)}" target="_blank">
					                                            {$valeBrinde.cnpj}
					                                        </a>                                        
					                                    </td>
					                                </tr>
					                                <tr>
					                                    <td>Produtos NF</td>
					                                    <td>
					                                        {$valeBrinde.produtos}
					                                    </td>
					                                </tr>
					                                <tr>
					                                    <td>Data Compra NF</td>
					                                    <td>
					                                        {$valeBrinde.data}
					                                    </td>
					                                </tr>
					                                <tr>
					                                    <td>Cpf Usuário</td>
					                                    <td>
					                                        <a href="{$siteurl}fini/cadastros-de-usuarios?wf=cpf&wv={$valeBrinde.cpf}" target="_blank">
					                                            {$valeBrinde.cpf}
					                                        </a>
					                                    </td>
					                                </tr>
					                                <tr>
					                                  <td colspan="2" class="text-center">
					                                    <a href="{$projecturl}files/notas-fiscais/{$valeBrinde.imagem}" data-extension="{$valeBrinde.imagem_extension}" target="_blank">
					                                      {if $valeBrinde.imagem_extension eq 'pdf'}
					                                        {$valeBrinde.imagem}
					                                      {else}
					                                        <img src="{$projecturl}files/notas-fiscais/{$valeBrinde.imagem}" style="width:200px">
					                                      {/if}
					                                    </a>
					                                  </td>
					                                </tr>
					                                <tr>
					                                    <td>Data Cadastro NF</td>
					                                    <td>{$valeBrinde.data_criacao}</td>
					                                </tr>
					                                <tr>
					                                	<td colspan="2">
					                                		<div>
					                                			<button class="btn btn-success btn-premiar" data-vale-brinde-id="{$valeBrinde.id_fini_vale_brinde}">
					                                				<i class="glyphicon glyphicon-ok"></i>
						                                			Conceder
						                                		</button>	
						                                		<button class="btn btn-danger btn-recusar" data-vale-brinde-id="{$valeBrinde.id_fini_vale_brinde}">
						                                			<i class="glyphicon glyphicon-remove"></i>
						                                			Não Conceder
						                                		</button>	
						                                		<img src="{$siteurl}themes/default/img/loading.gif" class="loader-status hide">	
					                                		</div>
					                                	</td>
					                                </tr>
					                                {else}
					                                	<h3>Não houve nota fiscal premiada ainda.</h3>
					                                {/if}
					                            </tbody>
					                        </table>
					                       </div>
					                      </div>
					                    </div>
					                  </div>
					                {/foreach}
					            </div>      
					            <div class="loader-gif" style="display:none;margin-left:47%; margin-top: 3%;margin-bottom: 3%;">
					                <img src="{$siteurl}themes/default/img/loading.gif" >
					            </div>  
					            <div class="col-md-offset-5 page-controls">
					                <button type="button" class="btn btn-success btn-next-results" {if $totCad lt 30}style="display:none;"{/if}>
					                    <span class="glyphicon glyphicon-plus"></span> Mais resultados
					                </button>
					                <div class="pull-right">
					                    <button type="button" class="btn btn-primary btn-to-top" {if $totCad lt 30}style="display:none;"{/if}>
					                        <span class="glyphicon glyphicon-arrow-up"></span>
					                    </button>
					                </div>
					            </div>
					        {else}
					            <h4>Não há vale-brindes cadastrados!</h4>
					        {/if}
					    </div>
					    <!-- FIM LISTA FEITOS -->
					</div>
					{/if}
				</div> 

				<div class="tab-pane fade {if $statusActive eq 'concedido'}active in{/if}" 
							role="tabpanel" id="concedido" aria-labelledby="concedido-tab" style="padding: 25px 5px;"> 
					{if isset($valeBrindes) && $statusActive eq 'concedido'}
					<div class="row">
						<!-- BUSCADOR -->
					    <div class="col-md-12">
					        <div class="col-md-12 col-xs-12 no-padding" style="padding: 0">
					            <form class="form form-inline form-search" style="margin-bottom: 7px;">
					            <div class="pull-left">
					                <div class="form-group">
					                    <div class="rotulo">
					                        <span>Buscar Por</span> 
					                    </div>                      
					                    <select class="form-control where btn-sm">
					                        {foreach key=key item=item from=$find_fields}
					                            <option value="{$key}">{$item}</option> 
					                        {/foreach}
					                    </select>
					                </div>          
					                <div class="form-group">
					                    <div class="rotulo">
					                        <span>Palavra Chave</span>  
					                    </div>      
					                    <div class="input-group">
					                      <input type="text" class="form-control find-value" name="find_value">
					                      <span class="input-group-btn">
					                        <button class="btn btn-primary btn-find-value" type="button">&nbsp;<span class="glyphicon glyphicon-search"></span></button>
					                      </span>
					                    </div>
					                </div>
					                <div class="form-group" style="margin-top: 20px;">
					                    <button type="button" class="btn btn-danger btn-clear-find" style="display: none;">&nbsp;<span class="glyphicon glyphicon-trash"></span></button>
					                </div>
					                <div class="label-count-results">
					                    <span class="pull-left" style="margin: 5px 5px;">Busca obteve <span class="count-result">{$totCad}</span> resultados</span>
					                </div>
					            </div>
					        </div>
					        </form>                 
					    </div>  
					</div><!-- row -->

					<div class="row">
						<!-- ACEITOS -->
						<div class="col-md-12">     
				        {if isset($valeBrindes)}
				            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				                {assign var="contador" value="0"}
				                {foreach $valeBrindes as $valeBrinde}   
				                  <div class="panel panel-success panel-id-{$valeBrinde.id_fini_vale_brinde}">
				                    <div class="panel-heading" role="tab" id="heading{$valeBrinde.id_fini_vale_brinde}">
				                      <h4 class="panel-title">
				                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{$valeBrinde.id_fini_vale_brinde}" aria-expanded="true" aria-controls="collapse{$valeBrinde.id_fini_vale_brinde}" style="font-size:14px;">
				                         <span class="glyphicon glyphicon-list-alt"></span> ID Vale-brinde: {$valeBrinde.id_fini_vale_brinde} | Data: {$valeBrinde.data_vb} | Horário: {$valeBrinde.horario_vb} | Número NF : {if isset($valeBrinde.id_fini_nota_fiscal)}{$valeBrinde.numero} {/if}
				                        </a>
				                      </h4>
				                    </div>
				                    <div id="collapse{$valeBrinde.id_fini_vale_brinde}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{$valeBrinde.id_fini_vale_brinde}">
				                      <div class="panel-body">
				                       <div class="table-responsive">
				                        <table class="table table-bordered">                
				                            <tbody>
				                                <tr>
				                                    <td>ID Vale-brinde</td>
				                                    <td>{$valeBrinde.id_fini_vale_brinde}</td>
				                                </tr>
				                                <tr>
				                                	<td>
				                                		Data/Horário Vale-brinde
				                                	</td>
				                                	<td>
				                                		{$valeBrinde.data_vb} {$valeBrinde.horario_vb}
				                                	</td>
				                                </tr>
			                                    <tr>
				                                    <td>Número NF</td>
				                                    <td>
				                                    	<a href="{$siteurl}fini/cadastros-de-notas-fiscais?wf=id_fini_nota_fiscal&wv={$valeBrinde.id_nota_fiscal}" target="_blank">
				                                    		{$valeBrinde.numero}
				                                    	</a>
				                                    </td>
				                                </tr>
				                                <tr>
				                                    <td>CNPJ NF</td>
				                                    <td>
				                                        <a href="{$siteurl}fini/cadastros-de-notas-fiscais?wf=cnpj&wv={urlencode($valeBrinde.cnpj)}" target="_blank">
				                                            {$valeBrinde.cnpj}
				                                        </a>                                        
				                                    </td>
				                                </tr>
				                                <tr>
				                                    <td>Produtos NF</td>
				                                    <td>
				                                        {$valeBrinde.produtos}
				                                    </td>
				                                </tr>
				                                <tr>
				                                    <td>Data Compra NF</td>
				                                    <td>
				                                        {$valeBrinde.data}
				                                    </td>
				                                </tr>
				                                <tr>
				                                    <td>Cpf Usuário</td>
				                                    <td>
				                                        <a href="{$siteurl}fini/cadastros-de-usuarios?wf=cpf&wv={$valeBrinde.cpf}" target="_blank">
				                                            {$valeBrinde.cpf}
				                                        </a>
				                                    </td>
				                                </tr>
				                                <tr>
				                                  <td colspan="2" class="text-center">
				                                    <a href="{$projecturl}files/notas-fiscais/{$valeBrinde.imagem}" data-extension="{$valeBrinde.imagem_extension}" target="_blank">
				                                      {if $valeBrinde.imagem_extension eq 'pdf'}
				                                        {$valeBrinde.imagem}
				                                      {else}
				                                        <img src="{$projecturl}files/notas-fiscais/{$valeBrinde.imagem}" style="width:200px">
				                                      {/if}
				                                    </a>
				                                  </td>
				                                </tr>
				                                <tr>
				                                    <td>Data Cadastro NF</td>
				                                    <td>{$valeBrinde.data_criacao}</td>
				                                </tr>
				                            </tbody>
				                        </table>
				                       </div>
				                      </div>
				                    </div>
				                  </div>
				                {/foreach}
				            </div>      
				            <div class="loader-gif" style="display:none;margin-left:47%; margin-top: 3%;margin-bottom: 3%;">
				                <img src="{$siteurl}themes/default/img/loading.gif" >
				            </div>  
				            <div class="col-md-offset-5 page-controls">
				                <button type="button" class="btn btn-success btn-next-results" {if $totCad lt 30}style="display:none;"{/if}>
				                    <span class="glyphicon glyphicon-plus"></span> Mais resultados
				                </button>
				                <div class="pull-right">
				                    <button type="button" class="btn btn-primary btn-to-top" {if $totCad lt 30}style="display:none;"{/if}>
				                        <span class="glyphicon glyphicon-arrow-up"></span>
				                    </button>
				                </div>
				            </div>
				        {else}
				            <h4>Não há vale-brindes concedidos!</h4>
				        {/if}
						</div>
						<!-- FIM ACEITOS -->	
					</div><!-- row -->
					{/if}
				</div><!-- tab -->

				<div class="tab-pane fade {if $statusActive eq 'nao_concedido'}active in{/if}" 
							role="tabpanel" id="nao_concedido" aria-labelledby="nao_concedido-tab" style="padding: 25px 5px;"> 
					<!-- RECUSADA -->	
					{if isset($valeBrindes) && $statusActive eq 'nao_concedido'}
					<div class="row">					
						<!-- BUSCADOR -->
					    <div class="col-md-12">
					        <div class="col-md-12 col-xs-12 no-padding" style="padding: 0">
					            <form class="form form-inline form-search" style="margin-bottom: 7px;">
					            <div class="pull-left">
					                <div class="form-group">
					                    <div class="rotulo">
					                        <span>Buscar Por</span> 
					                    </div>                      
					                    <select class="form-control where btn-sm">
					                        {foreach key=key item=item from=$find_fields}
					                            <option value="{$key}">{$item}</option> 
					                        {/foreach}
					                    </select>
					                </div>          
					                <div class="form-group">
					                    <div class="rotulo">
					                        <span>Palavra Chave</span>  
					                    </div>      
					                    <div class="input-group">
					                      <input type="text" class="form-control find-value" name="find_value">
					                      <span class="input-group-btn">
					                        <button class="btn btn-primary btn-find-value" type="button">&nbsp;<span class="glyphicon glyphicon-search"></span></button>
					                      </span>
					                    </div>
					                </div>
					                <div class="form-group" style="margin-top: 20px;">
					                    <button type="button" class="btn btn-danger btn-clear-find" style="display: none;">&nbsp;<span class="glyphicon glyphicon-trash"></span></button>
					                </div>
					                <div class="label-count-results">
					                    <span class="pull-left" style="margin: 5px 5px;">Busca obteve <span class="count-result">{$totCad}</span> resultados</span>
					                </div>
					            </div>
					        </div>
					        </form>                 
					    </div>  
					    <!-- FIM BUSCADOR -->
					</div>		

				    <div class="row">   
				    	<!-- LISTA APROVADOS -->
					    <div class="col-md-12">     
					        {if isset($valeBrindes)}
					            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					                {assign var="contador" value="0"}
					                {foreach $valeBrindes as $valeBrinde}   
					                  <div class="panel panel-danger panel-id-{$valeBrinde.id_fini_vale_brinde}">
					                    <div class="panel-heading" role="tab" id="heading{$valeBrinde.id_fini_vale_brinde}">
					                      <h4 class="panel-title">
					                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{$valeBrinde.id_fini_vale_brinde}" aria-expanded="true" aria-controls="collapse{$valeBrinde.id_fini_vale_brinde}" style="font-size:14px;">
					                         <span class="glyphicon glyphicon-list-alt"></span> ID Vale-brinde: {$valeBrinde.id_fini_vale_brinde} | Data: {$valeBrinde.data_vb} | Horário: {$valeBrinde.horario_vb} | Número NF: {if isset($valeBrinde.id_fini_nota_fiscal)}{$valeBrinde.numero}{else} -- {/if}
					                        </a>
					                      </h4>
					                    </div>
					                    <div id="collapse{$valeBrinde.id_fini_vale_brinde}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{$valeBrinde.id_fini_vale_brinde}">
					                      <div class="panel-body">
					                       <div class="table-responsive">
					                        <table class="table table-bordered">                
					                            <tbody>
					                                <tr>
					                                    <td>ID Vale-brinde</td>
					                                    <td>{$valeBrinde.id_fini_vale_brinde}</td>
					                                </tr>
					                                 <tr>
					                                	<td>
					                                		Data/Horário Vale-brinde
					                                	</td>
					                                	<td>
					                                		{$valeBrinde.data_vb} {$valeBrinde.horario_vb}
					                                	</td>
				                                	</tr>
					                                <tr>
					                                    <td>Número NF</td>
					                                    <td>
					                                    	<a href="{$siteurl}fini/cadastros-de-notas-fiscais?wf=id_fini_nota_fiscal&wv={$valeBrinde.id_nota_fiscal}" target="_blank">
					                                    		{$valeBrinde.numero}
					                                    	</a>
					                                    </td>
					                                </tr>
					                                <tr>
					                                    <td>CNPJ NF</td>
					                                    <td>
					                                        <a href="{$siteurl}fini/cadastros-de-notas-fiscais?wf=cnpj&wv={urlencode($valeBrinde.cnpj)}" target="_blank">
					                                            {$valeBrinde.cnpj}
					                                        </a>                                        
					                                    </td>
					                                </tr>
					                                <tr>
					                                    <td>Produtos NF</td>
					                                    <td>
					                                        {$valeBrinde.produtos}
					                                    </td>
					                                </tr>
					                                <tr>
					                                    <td>Data Compra</td>
					                                    <td>
					                                        {$valeBrinde.data}
					                                    </td>
					                                </tr>
					                                <tr>
					                                    <td>Cpf Usuário</td>
					                                    <td>
					                                        <a href="{$siteurl}fini/cadastros-de-usuarios?wf=cpf&wv={$valeBrinde.cpf}" target="_blank">
					                                            {$valeBrinde.cpf}
					                                        </a>
					                                    </td>
					                                </tr>
					                                <tr>
					                                  <td colspan="2" class="text-center">
					                                    <a href="{$projecturl}files/notas-fiscais/{$valeBrinde.imagem}" data-extension="{$valeBrinde.imagem_extension}" target="_blank">
					                                      {if $valeBrinde.imagem_extension eq 'pdf'}
					                                        {$valeBrinde.imagem}
					                                      {else}
					                                        <img src="{$projecturl}files/notas-fiscais/{$valeBrinde.imagem}" style="width:200px">
					                                      {/if}
					                                    </a>
					                                  </td>
					                                </tr>
					                                <tr>
					                                    <td>Data Cadastro NF</td>
					                                    <td>{$valeBrinde.data_criacao}</td>
					                                </tr>
					                                <tr>
					                                	<td>Motivo Não Concessão</td>
					                                	<td>{$valeBrinde.motivo}</td>
					                                </tr>
					                            </tbody>
					                        </table>
					                       </div>
					                      </div>
					                    </div>
					                  </div>
					                {/foreach}
					            </div>      
					            <div class="loader-gif" style="display:none;margin-left:47%; margin-top: 3%;margin-bottom: 3%;">
					                <img src="{$siteurl}themes/default/img/loading.gif" >
					            </div>  
					            <div class="col-md-offset-5 page-controls">
					                <button type="button" class="btn btn-success btn-next-results" {if $totCad lt 30}style="display:none;"{/if}>
					                    <span class="glyphicon glyphicon-plus"></span> Mais resultados
					                </button>
					                <div class="pull-right">
					                    <button type="button" class="btn btn-primary btn-to-top" {if $totCad lt 30}style="display:none;"{/if}>
					                        <span class="glyphicon glyphicon-arrow-up"></span>
					                    </button>
					                </div>
					            </div>
					        {else}
					            <h4>Não há vale-brindes não concedidos!</h4>
					        {/if}
					    </div>
					   <!-- FIM LISTA APROVADOS -->
					</div>
					{/if}
				</div> 
			</div> 
		</div>
	</div>
</div>