<div class='content'>
 <h2 class='module_title'><img src="{$image_url}big/lock_new.gif" align="middle" /> &nbsp; Alterar senha</h2>
 Logado como: {$user.name}
 <hr />
 <form action="" method="post" onsubmit='return valida()' autocomplete='off' class="form-horizontal col-md-3">
 	<div class="control-group">
		<div class="controls">
    		<span class='error_field'>{$pass_error}</span>
    	</div>
    </div>
 	<div class="form-group">
		<label class="control-label" for="old_pass">Senha atual:</label>
		<div class="controls">
 			<input type='password'  class="form-control" name='old_pass' value='' id='old_pass' />
 			<span class='error_field' id='old_pass_error'></span>
 		</div>
 	</div>
 	<div class="form-group">
			<label class="control-label" for="new_pass">Nova senha:</label>
			<div class="controls">
 				<input type='password' class="form-control" name='new_pass' value='' id='new_pass' />
 				<span class='error_field' id='new_pass_error'></span>
 			</div>
 	</div>
 	<div class="form-group">
		<label class="control-label" for="new_pass_confirm">Confirmar senha:</label>
		<div class="controls">
 			<input type='password' class="form-control" name='new_pass_confirm' value='' id='new_pass_confirm' />
 			<span class='error_field' id='new_pass_error'></span>
 		</div>
 	</div>
 	<div class="form-group">
		<div class="controls">
 			<input  class="btn btn-primary form-control" type='submit' name='saveChange' value='Salvar' />
 		</div>
 	</div>
 
 </form>
 <script type='text/javascript'>
 	function valida()
 	{
 		var submit = 1;
 		var old_pass = $('#old_pass').val();
 		var new_pass = $('#new_pass').val();
 		var new_pass_confirm = $('#new_pass_confirm').val();
 		
 		if(old_pass == "")
 		{
 			$('#old_pass_error').html("Informe a senha anterior");
 			submit = 0;
 		}else{
 			$('#old_pass_error').html("");
 		}
 		
 		if(new_pass == "")
 		{
 			$('#new_pass_error').html("Informe a nova senha");
 			submit = 0;
 		}else if(new_pass_confirm == "")
 		{
 			$('#new_pass_error').html("Confirme a nova senha");
 			submit = 0;
 		}else if(old_pass == new_pass)
 		{
 			$('#new_pass_error').html("Senha anterior e a nova senha n&atilde;o podem ser iguais");
 			submit = 0;
 		}else if(new_pass != new_pass_confirm)
 		{
 			$('#new_pass_error').html("Senha e confirmação de senha precisam ser iguais");
 			submit = 0;
 		}else{
 			$('#new_pass_error').html("");
 		}
 		if(submit)
 			return true;
 		return false;
 	}
 </script>