<div class='content'>
	<h1 class='module_title'><img src="{$image_url}big/note.gif" align="middle" />&nbsp; Configurações do Projeto</h1>
	<div class='error_field'>{$data_error}</div>
	{if $saved}
		<div class='success_field'>Dados alterados com sucesso</div>
		{literal}
		<script type='text/javascript'>
			setTimeout(function(){ 
				$('.success_field').fadeOut(); 
			}, 3000);
		</script>
		{/literal}
	{/if}
</div>
{$fields}
<script type='text/javascript'>
	{$js_content}
</script>