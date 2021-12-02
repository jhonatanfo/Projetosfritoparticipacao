<div class='content'>
	<h1 class='module_title'><img src="{$image_url}big/businessman.gif" align="middle" />&nbsp; {if $edit}Editar{else}Adicionar{/if} Badge ao usuário</h1>
	<div class='error_field'>{$data_error}</div>
</div>
<div class='content'>
<form action="" method="post">
	<label class="label_table">Badges: </label>
	<select multiple="multiple" name="badges[]" id="badge">
		{if $badges}
			{section name=i loop=$badges}
				<option value="{$badges[i].id}">{$badges[i].name}</option>
			{/section}
		{/if}
	</select>
	<span>* Segure o CTRL para selecionar mais de um Badge.</span>
	<br />
	<br />
	<input type="hidden" name="id" value="{$edit.id}" />
	<input class="btn btn-primary" type="submit" name="save" Value="Salvar" />
</form>
</div>
<script type="text/javascript">
	$(function(){
		$('#badge').focusout(function(){
			var badgeSelected = $('#badge option:selected').attr('data-badge');

			if(badgeSelected == undefined){
				alert('Selecione um badge.');
			}
			$('#badge option:selected').each(function(){
			
				}
			});
		});
	});
</script>