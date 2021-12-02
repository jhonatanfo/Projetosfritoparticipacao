<div class='content'>
	<div class="page-header">
		<h4>&nbsp; Grupo de usu&aacute;rio - {$view.name}</h4>	
	</div>
	<span class='error_field'>{$view_error}</span>
	<table class="table table-bordered">
		<tr>
			<td>Nome:</td>
			<td>{$view.name}</td>
		</tr>
		<tr>
			<td>Descrição:</td>
			<td>{if $view.description}{$view.description}{else}---{/if}</td>
		</tr>
		<tr>
			<td>Criado em:</td>
			<td>{$view.date_created} por {$view.created_by}</td>
		</tr>
		<tr>
			<td>Ultima alteração em:</td>
			<td>{$view.date_modified} por {$view.modified_by}</td>
		</tr>
		<tr>
		  <td class='field_submit' colspan='4'>
		 	{if $ssxacl.this_module.edit}
		     <a href="{$siteurl}{$this_module}/edit?id={$view.id}" class="btn btn-small btn-warning"><span class="glyphicon-edit glyphicon"></span> Editar</a>
		     {if $view.id neq "1"}
		    	 <a href="javascript:void(0);" class="btn btn-small btn-danger" onclick="checkStatus('{$view.id}', {$view.status})">
		    	 	<span class="glyphicon-ban-circle glyphicon"></span> {if $view.status eq "1"}Desativar{else}Ativar{/if} grupo
		    	 </a>
		     	<a href="javascript:void(0);" class="btn btn-small btn-danger" onclick="checkDelete('{$view.id}')">
		     		<i class="glyphicon-trash glyphicon"></i> Apagar
		     	</a>
		  	 {/if}
		  	{/if}
		  </td>
		</tr>
	</table>
	<hr />
	{if $users}
	<legend>Usuários do grupo</legend>
	<table class="table table-hover">
		<tr>
		    <td>&nbsp;</td>
			<td>Nome</td>
			<td>Email</td>
			<td>Usu&aacute;rio</td>
			<td>Status</td>
			<td>&nbsp;</td>
		</tr>
		{section name=i loop=$users}
		<tr>
		    <td nowrap="nowrap" width="5"><i class="icon-user"></i></td>
			<td>{$users[i].name}</td>
			<td>{$users[i].email}</td>
			<td>{$users[i].user}</td>
			<td>{if $users[i].status eq 1}Ativo{else}Inativo{/if}</td>
			<td align="right">
			 {if $ssxacl.admin.ssxusers.view} 
			  <a href="{$siteurl}ssxusers/view?id={$users[i].id}" class="btn btn-small btn-info">
			  	<i class="glyphicon-eye-open glyphicon"></i> ver usu&aacute;rio
			  </a>
			 {/if}
			</td>
		</tr>
		{/section}
	</table>
	{else}
		{if $view.level eq "2"}
		<p class='label error_field'>Esse grupo não pode ter usuário</p>
		{else}
		<p class='label error_field'>Nenhum usuário nesse grupo</p>
		{/if}
	{/if}
</div>
<script type='text/javascript'>
{if $ssxacl.this_module.edit}
 function checkDelete(id)
 {
	 if(confirm("Tem certeza que deseja apagar esse grupo? \nTodos os usuários desse grupo não poderão mais logar,\n sendo necessário edita-los e coloca-los em outro grupo"))
	 {
		window.location.href = "{$siteurl}{$this_module}/{$this_action}?delete=true&id={$view.id}";
	 }
 }

 function checkStatus(id, status)
 {
	 var msg;

	 if(status)
	 {
		msg = "Tem certeza que deseja desativar esse grupo?\nNenhum usuário dentro dele conseguirá logar no sistema\n";
	 }
	 else
	 {
		msg = "Tem certeza que deseja ativar esse grupo?";
	 }
	 
	 if(confirm(msg))
	 {
		window.location.href = "{$siteurl}{$this_module}/{$this_action}?group_alter_status=true&id={$view.id}";
	 }
 }
 {/if}
</script>