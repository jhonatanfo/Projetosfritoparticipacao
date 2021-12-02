<!-- <div class="row">
	<div class="page-header">
	  <h1>Esqueci minha senha <small>formuário</small></h1>
	</div>
</div>


<div class="row">
	<div class="col-md-6 col-md-offset-3" style="padding:60px 0px;">
		<form class="form" method="POST" action="">
			<input type="hidden" name="_csrfTokenEsqueci" value="{$csrfTokenEsqueci}">
			<div class="form-group">
				<label>Digite o seu CPF</label>
				<input type="text" name="cpf" class="form-control ipt-cpf">
			</div>
			<div class="form-group">
				<button type="submit" class="btn">Enviar</button>
			</div>
		</form>
	</div>
</div> -->

<div class="bg esqueci-senha">

	<div class="container">

		<div class="row">
			<div class="page-header">
				<h1>Esqueci minha senha</h1>
				<i class="arrow senha"></i>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<span>Digite seu CPF para gerar uma nova senha temporária. Esta senha será enviada para o email
					cadastrado por este CPF.</span>
			</div>

			<div class="col-md-6">
				<div class="form-group col-md-12">
					<label for="exampleInputEmail1">CPF*</label>
					<input type="text" name="cpf" class="form-control ipt-cpf" id="cpf">
					<p class="erro" style="display: none;">Preencha o CPF</p>
				</div>

				<button type="submit">Enviar</button>
			</div>
		</div>

	</div>

</div>