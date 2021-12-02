<div class="content">
	<div class="page-header">
		<h4>Grupos</h4>	
	</div>
	{if $ssxacl.this_module.edit}
		<a href="{$siteurl}{$this_module}/edit" class='btn btn-small btn-success'><span class="glyphicon glyphicon-plus"></span> Adicionar grupo</a>
	{/if}	
	{if $group_deleted}
	<div id='popup' class='error_field'>Grupo deletado com sucesso</div>
	<script type='text/javascript'>
		setTimeout(function(){ $('#popup').fadeOut(); }, 3000);
	</script>
	{/if}
</div>
<div class='content-list'>
	{if $pagination}
	<div class="pagination">
		   <div class='pages'>
			{section name=i loop=$pagination}
				<div class='page_item'>
				{if $pagination[i] neq $pagination_page}
					<a href="{$siteurl}{$this_module}/{$this_action}?page={$pagination[i]}">{$pagination[i]}</a>
				{else}
					{$pagination[i]}
				{/if}
				</div>
			{/section}
			<div class="clear"></div>
		  </div>
		  <div class="clear"></div>
	</div>
	{/if}
	{if $all}
	<table class="table table-hover">
		<tr>
		    <td>&nbsp;</td>
			<td>Nome</td>
			<td>Criado em</td>
			<td>Ultima modificação em</td>
			<td>Status</td>
			
			<td width='20%'>&nbsp;</td>
		</tr>
		{section name=i loop=$all}
		<tr>
		    <td nowrap="nowrap" width="5"><i class="icon-th"></i></td>
			<td>{$all[i].name}</td>
			<td style='font-size:11px'>{$all[i].date_created} por {$all[i].created_by}</td>
			<td style='font-size:11px'>{$all[i].date_modified} por {$all[i].modified_by}</td>
			<td>{if $all[i].status eq 1}Ativo{else}Inativo{/if}</td>
			{if $ssxacl.this_module.view}
			<td align="right">
			  	<a href="{$siteurl}{$this_module}/view?id={$all[i].id}" class="btn btn-small btn-info"><i class="glyphicon glyphicon-eye-open"></i> ver grupo</a>
			</td>
			{/if}
		</tr>
		{/section}
	</table>
	{else}
	<p class='label error_field'>Nenhum grupo cadastrado</p>
	{/if}
</div>