<div class='content'>
	<div class="page-header">
		<h4>&nbsp; Usu&aacute;rio - {$view.name}</h4>	
	</div>	
	<span class='error_field'>{$view_error}</span>
	<table class="table table-bordered">
		<tr>
			<td>Login:</td>
			<td>{$view.user}</td>
		</tr>
		<tr>
			<td>Nome:</td>
			<td>{$view.name}</td>
		</tr>
		<tr>
			<td>Email:</td>
			<td>{$view.email}</td>
		</tr>
		<tr>
			<td>Criado em:</td>
			<td style='font-size:11px'>{$view.date_created} por {$view.created_by}</td>
		</tr>
		<tr>
			<td>Ultima alteração em:</td>
			<td style='font-size:11px'>{$view.date_modified} por {$view.modified_by}</td>
		</tr>
		{if $ssxacl.this_module.edit}
		<tr>
		  <td class='field_submit' colspan='4'>
		  	 {if $view.id neq "2"}
		     	<a href="{$siteurl}{$this_module}/edit?id={$view.id}" class="btn btn-small btn-warning">
		     		<span class="glyphicon glyphicon-edit"></span> Editar
		     	</a>
		     {/if}
		     {if !$is_your && $view.id neq "1" && $view.id neq "2"}
		    	 <a href="javascript:void(0);" class="btn btn-small btn-danger" onclick="checkStatus('{$view.id}', {$view.status})">
		    	 	<span class="glyphicon glyphicon-ban-circle"></span> {if $view.status eq "1"}Desativar{else}Ativar{/if} usu&aacute;rio
		    	 </a>
		     	<a href="javascript:void(0);" class="btn btn-small btn-danger" onclick="checkDelete('{$view.id}')">
		     		<span class="glyphicon glyphicon-trash"></span> Apagar
		     	</a>
		  	 {/if}
		  </td>
		</tr>
		{/if}
	</table>
</div>
{if $ssxacl.this_module.edit}
<script type='text/javascript'>
 function checkDelete(id)
 {
	 if(confirm("Tem certeza que deseja apagar este usuário?"))
	 {
		window.location.href = "{$siteurl}{$this_module}/{$this_action}?user_delete=true&id={$view.id}";
	 }
 }

 function checkStatus(id, status)
 {
	 var msg;

	 if(status)
	 {
		msg = "Tem certeza que deseja desativar este usuário?\nEle não poderá mais logar no sistema\n";
	 }
	 else
	 {
		msg = "Tem certeza que deseja ativar este usuário?";
	 }
	 
	 if(confirm(msg))
	 {
		window.location.href = "{$siteurl}{$this_module}/{$this_action}?user_alter_status=true&id={$view.id}";
	 }
 }
</script>
{/if}