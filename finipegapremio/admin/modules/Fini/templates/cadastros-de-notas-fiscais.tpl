<div class="row">
    <div class="col-md-12">
        <div class="page-header">
                <h3>
                    Cadastros 
                    <small>Notas Fiscais</small>
                    <button class="btn btn-xs btn-primary" type="button">
                        Total Cadastrados <span class="badge">{$tot_cad}</span>
                    </button>  
                    <a href="{$siteurl}fini/cadastros-de-notas-fiscais/exportar-notas-fiscais" class="btn btn-xs btn-success">
                        <i class="glyphicon glyphicon-download-alt"></i> Exportar
                    </a> 
                </h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12" style="margin: 15px 0px;">
        <form class="form form-inline form-search">
            <div class="col-md-4 no-padding">
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
                    <span class="pull-left" style="margin: 5px 5px;">Busca obteve <span class="count-result">{$tot_cad_search}</span> resultados</span>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-2 no-padding">
                <div class="pull-right">
                    <div class="rotulo">
                        <span>Ordenar por</span>    
                    </div>                      
                    <div class="input-group">
                        <select class="form-control orderby btn-sm">
                            {foreach key=key item=item from=$order_fields}
                                <option value="{$key}">{$item}</option> 
                            {/foreach}
                        </select>   
                        <span class="input-group-btn">
                            <button class="btn btn-success orderbyside" type="button" value="ASC">&nbsp;<span class="glyphicon glyphicon-chevron-up"></span></button>
                        </span>
                    </div>      
                </div>
            </div>      
        </form>                 
    </div>  
</div>

<div class="row">   
    <div class="col-md-12">     
        {if isset($notas)}
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                {assign var="contador" value="0"}
                {foreach $notas as $nota}   
                  <div class="panel panel-default panel-id-{$nota.id_nota_fiscal}">
                    <div class="panel-heading" role="tab" id="heading{$nota.id_nota_fiscal}">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{$nota.id_nota_fiscal}" aria-expanded="true" aria-controls="collapse{$nota.id_nota_fiscal}" style="font-size:14px;">
                         <span class="glyphicon glyphicon-list-alt"></span> ID: {$nota.id_nota_fiscal} | Número: {$nota.numero} | CNPJ: {$nota.cnpj} | Data Compra: {$nota.data} | CPF: {$nota.cpf}
                        </a>
                      </h4>
                    </div>
                    <div id="collapse{$nota.id_nota_fiscal}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{$nota.id_nota_fiscal}">
                      <div class="panel-body">
                       <div class="table-responsive">
                        <table class="table table-bordered">                
                            <tbody>
                                <tr>
                                    <td>ID</td>
                                    <td>{$nota.id_nota_fiscal}</td>
                                </tr>
                                <tr>
                                    <td>Número</td>
                                    <td>{$nota.numero}</td>
                                </tr>
                                <tr>
                                    <td>CNPJ</td>
                                    <td>
                                        <a href="{$siteurl}fini/cadastros-de-notas-fiscais?wf=cnpj&wv={urlencode($nota.cnpj)}">
                                            {$nota.cnpj}
                                        </a>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>Produtos NF</td>
                                    <td>
                                        {$nota.produtos}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Data Compra</td>
                                    <td>
                                        {$nota.data}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cpf Usuário</td>
                                    <td>
                                        <a href="{$siteurl}fini/cadastros-de-usuarios?wf=cpf&wv={$nota.cpf}">
                                            {$nota.cpf}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="text-center">
                                    <a href="{$projecturl}files/notas-fiscais/{$nota.imagem}" data-extension="{$nota.imagem_extension}" target="_blank">
                                      {if $nota.imagem_extension eq 'pdf'}
                                        {$nota.imagem}
                                      {else}
                                        <img src="{$projecturl}files/notas-fiscais/{$nota.imagem}" style="width:200px">
                                      {/if}
                                    </a>
                                  </td>
                                </tr>
                                <tr>
                                    <td>Data Cadastro</td>
                                    <td>{$nota.data_criacao}</td>
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
                <button type="button" class="btn btn-success btn-next-results" {if $tot_cad lt 30}style="display:none;"{/if}>
                    <span class="glyphicon glyphicon-plus"></span> Mais resultados
                </button>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-to-top" {if $tot_cad lt 30}style="display:none;"{/if}>
                        <span class="glyphicon glyphicon-arrow-up"></span>
                    </button>
                </div>
            </div>
        {else}
            <h4>Não há notas fiscais cadastradas!</h4>
        {/if}
    </div>
</div>
</div>
{if isset($whereField) && $whereField && isset($whereValue) && $whereValue}
<script type="text/javascript">
    $(function(){
        var where_field = "{$whereField}";
        var where_value = "{$whereValue}";
        $('.where').val(where_field);
        $(".find-value").val(where_value);
        $('.btn-clear-find').show();
        if($('.panel-default').length){
            $('.btn-clear-find').unbind('click');
            $('.btn-clear-find').click(function(){
                window.location = _ssx_siteurl+'fini/cadastros-de-notas-fiscais';
            });
        }       
    }); 
</script>
{/if}