<div class='content'>
	<div class="page-header">
		<h4>&nbsp; Editar permissões</h4>	
	</div>
	<div class='error_field'>{$data_error}</div>
</div>
<div class='content'>
<!--	<div class='content_group'>-->
		<form action="" method="post" class="form form-inline">
			<div class="form-group">
				<label>Grupo</label>
				<select name="group_id" class="form-control" required>
					<option value="" onchange="">-- Selecione</option>
					{foreach $groups as $group}
					<option {if $group_id eq $group.id}selected="selected"{/if} value="{$group.id}">{$group.name}</option>
					{/foreach}
				</select>
			</div>
			<div class="form-group">
				<button class="btn btn-warning form-control" type='submit' value='Editar permissões'>
					<span class="glyphicon-edit glyphicon"></span> Editar permissões
				</button> 
			</div>
		</form>
<!--	</div>-->
	{if $group_permissions && $group_permissions neq "all_access"}
	<p style='font-size:11px'>
	  Ultima alteração em:
	  {$p_details.date_modified} por {$p_details.modified_by}
	</p>
	<form action="" method="post">
		<input type='hidden' name='group_id' value='{$group_id}' />
		<table class="table table-bordered">
			<tr>
				<td colspan="2">
					<button class="pull-right btn btn-success" type="submit" value="Salvar alterações" name="save">
		    			<span class="glyphicon-file glyphicon"></span> Salvar
		    		</button>
				</td>
			</tr>
		{foreach $group_permissions as $locals}
			<tr>
				<td colspan="2" width="100%">
					<legend class="text-center">{if $locals@key eq "admin"}Área administrativa{else}Acesso ao site{/if}</legend>
					<input type='radio' name='data[{$locals@key}][_access]' {if $locals._access eq "A"} checked="checked"{/if} value='A' /> Permitido
					<input type='radio' name='data[{$locals@key}][_access]' {if $locals._access eq "D"} checked="checked"{/if} value='D' /> Restrito<br /><br />
				</td>
			</tr>
			
			{foreach $locals.modules as $itens}
				{if $itens@key neq "_access"}
					<tr>
					   <td><br /><strong>{$itens@key}</strong></td>
					</tr> 
					{foreach $itens as $actions}
						{foreach $actions as $action}
						  <tr>
						    <td>	
								&raquo; {$action@key} 
							</td>
							<td>
								<input type='radio' name='data[{$locals@key}][modules][{$itens@key}][actions][{$action@key}]' {if $action eq "A"}checked="checked"{/if} value='A' /> Permitido
								<input type='radio' name='data[{$locals@key}][modules][{$itens@key}][actions][{$action@key}]' {if $action eq "D"}checked="checked"{/if} value='D'  /> Restrito
							</td>
						  </tr> 
						{/foreach}
					{/foreach}
				{/if}
			{/foreach}
		{/foreach}
			<tr>
		    	<td colspan="3">
				    <button class="pull-right btn btn-success" type="submit" value="Salvar alterações" name="save" />
		    			<span class="glyphicon-file glyphicon"></span> Salvar
		    		</button>
		    	</td>
		    </tr>
		</table>
	</form>
	{else if $group_permissions eq "all_access"}
		<p>
		 Este grupo já possui permissão de acesso a todos os pontos do projeto e do admin
		</p>
	{/if}
</div>