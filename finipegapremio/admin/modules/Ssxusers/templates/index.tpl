<div class="content">
    <div class="page-header">
        <h4>Usuários</h4>
    </div>
    <!-- <h1 class='module_title'><img src="{$image_url}big/businessman.gif" align="middle" />&nbsp; Usu&aacute;rios</h1>
	<br /> -->
    <div class="row no-space">
        <div class="col-md-10">
            <form class="form-inline form-search" method="post" action="{$siteurl}ssxusers">
                <div class="form-group">
                    {if $ssxacl.this_module.edit}
                    <a href="{$siteurl}{$this_module}/edit" class='btn btn-small btn-success form-control'>
                        <i class="glyphicon glyphicon-plus"></i> Adicionar usu&aacute;rio
                    </a>
                    {/if}
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="search_user" class="input-large search-query form-control" placeholder="Buscar por...">
                        <span class="input-group-btn">
				        <button class="btn btn-primary" name="send_search" type="submit">
				        	<span class="glyphicon glyphicon-search"></span> &nbsp;
                        </button>
                        </span>
                    </div>
                    <!-- /input-group -->
                </div>
            </form>
        </div>

        {if $user_deleted}
        <div id='popup' class='error_field'>Usu&aacute;rio deletado com sucesso</div>
        <script type='text/javascript'>
            setTimeout(function() {}, 3000);
        </script>
        {/if}
    </div>
</div>
<div class='content-list'>
    {if $pagination}
    <div class="pagination pagination-right">
        <ul>
            {section name=i loop=$pagination} {if $pagination[i] neq $pagination_page}
            <li>
                <a href="{$siteurl}{$this_module}/{$this_action}?page={$pagination[i]}">{$pagination[i]}</a> {else}
                <li class="active">
                    <span>{$pagination[i]}</span> {/if}
                </li>
                {/section}
        </ul>
    </div>
    {/if} {if $all}
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th>&nbsp;</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Usu&aacute;rio</th>
                <th>Criado em</th>
                <th>Ultima modificação em</th>
                <th>Status</th>
                <th width="15%">&nbsp;</th>
            </tr>
            {section name=i loop=$all}
            <tr>
                <td><i class="icon-user"></i></td>
                <td>{$all[i].name}</td>
                <td>{$all[i].email}</td>
                <td>{$all[i].user}</td>
                <td style='font-size:11px'>{$all[i].date_created} por {$all[i].created_by}</td>
                <td style='font-size:11px'>{$all[i].date_modified} por {$all[i].modified_by}</td>
                <td>{if $all[i].status eq 1}Ativo{else}Inativo{/if}</td>
                {if $ssxacl.this_module.view}
                <td align="right">
                    <a href="{$siteurl}{$this_module}/view?id={$all[i].id}" class='btn btn-small btn-info'><span class="glyphicon glyphicon-eye-open"></span> Ver usu&aacute;rio</a>
                </td>
                {/if}
            </tr>
            {/section}
        </table>
    </div>
    {else}
    <p class="text-error text-center">Nenhum usuário cadastrado</p>
    {/if} {if $pagination}
    <div class="pagination pagination-right">
        <ul>
            {section name=i loop=$pagination} {if $pagination[i] neq $pagination_page}
            <li>
                <a href="{$siteurl}{$this_module}/{$this_action}?page={$pagination[i]}">{$pagination[i]}</a> {else}
                <li class="active">
                    <span>{$pagination[i]}</span> {/if}
                </li>
                {/section}
        </ul>
    </div>
    {/if}
</div>