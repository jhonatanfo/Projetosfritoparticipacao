<div class="row">
	<div class="page-header">
	  <h1>Alterar Dados <small>formuário</small></h1>
	</div>
	<div class="col-md-12">
		<form method="POST" action="" class="form">
			<input type="hidden" name="_csrfTokenAlterarDados" value="{$csrfTokenAlterarDados}">
			<div class="form-group">
				<div class="col-md-6">
					<label class="col-sm-2" for="nome">Nome</label>
					<div>
						<input type="text" class="form-control ipt-nome" name="nome" value="{$usuario.nome}">
					</div>
				</div>
				<div class="col-md-6">
					<label class="col-sm-2" for="email">Sobrenome</label>
					<div>
						<input type="text" class="form-control ipt-sobrenome" name="sobrenome" value="{$usuario.sobrenome}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<label class="col-sm-2" for="email">Email</label>
					<div>
						<input type="text" class="form-control ipt-email" name="email" value="{$usuario.email}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<label class="col-sm-2" for="cpf">Cpf</label>
					<div>
						<input type="text" class="form-control ipt-cpf" name="cpf" value="{$usuario.cpf}" disabled>
					</div>
				</div>
				<div class="col-md-6">
					<label class="col-sm-6" for="nome">Data Nascimento</label>
					<div>
						<input type="text" class="form-control ipt-data-nascimento" name="data_nascimento" value="{$usuario.data_nascimento}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<label class="col-sm-2" for="nome">Telefone</label>
					<div>
						<input type="text" class="form-control ipt-telefone" name="telefone" value="{$usuario.telefone}">
					</div>
				</div>
				<div class="col-md-6">
					<label class="col-sm-2" for="nome">Celular</label>
					<div>
						<input type="text" class="form-control ipt-celular" name="celular" value="{$usuario.celular}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<label class="col-sm-2" for="nome">Cep</label>
					<div>
						<input type="text" class="form-control ipt-cep" name="cep" value="{$usuario.cep}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-8">
					<label class="col-sm-2" for="nome">Endereço</label>
					<div>
						<input type="text" class="form-control ipt-logradouro" name="logradouro" value="{$usuario.logradouro}">
					</div>
				</div>
				<div class="col-md-4">
					<label class="col-sm-2" for="nome">Número</label>
					<div>
						<input type="text" class="form-control ipt-numero" name="numero" value="{$usuario.numero}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<label class="col-sm-2" for="nome">Complemento</label>
					<div>
						<input type="text" class="form-control ipt-complemento" name="complemento" value="{$usuario.complemento}">
					</div>
				</div>
				<div class="col-md-6">
					<label class="col-sm-2" for="nome">Bairro</label>
					<div>
						<input type="text" class="form-control ipt-bairro" name="bairro" value="{$usuario.bairro}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<label class="col-sm-2" for="nome">Estado</label>
					<div>
						<select class="form-control ipt-estado" name="estado">
							<option value="">--Selecione o estado</option>
							{foreach $estados as $estado}
								<option value="{$estado.uf}" {if $usuario.uf eq $estado.uf} selected {/if} >{$estado.uf}</option>
							{/foreach}
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<label class="col-sm-2" for="nome">Cidade</label>
					<div>
						<select class="form-control ipt-cidade" name="cidade">
							<option value="">--Selecione a cidade</option>
							<option value="{$usuario.cidade}" selected>{$usuario.cidade}</option>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<label class="col-sm-2" for="nome">Senha</label>
					<div>
						<input type="password" class="form-control ipt-senha" name="senha">
					</div>
				</div>
				<div class="col-md-6">
					<label class="col-sm-6" for="nome">Confirma Senha</label>
					<div>
						<input type="password" class="form-control ipt-conf-senha" name="conf_senha">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="termos" checked class="ipt-termos" disabled> Aceito os termos e serviços
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="newsletter" class="ipt-newsletter" {if $usuario.newsletter eq 'SIM'} checked {/if}> Aceito receber a newsletter
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<button type="submit" class="btn btn-enviar" name="enviar" value="enviar">Enviar</button>		
				</div>
			</div>
		</form>
	</div>
</div>
