<div class="row">
	<div class="col-md-12 col">
		<div class="page-header">
		  <h1>Adicionar Nota Fiscal <small>formulário</small></h1>
		</div>
	</div>
	<div class="col-md-12">
		<form method="POST" action="" class="form" enctype="multipart/form-data">
			<input type="hidden" name="_csrfTokenNotaFiscal" value="{$csrfTokenNotaFiscal}">
			<div class="form-group">
				<div class="col-md-12">
					<label for="nome">Número</label>
					<div>
						<input type="text" class="form-control ipt-numero" name="numero">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<label for="data_compra">Data Compra</label>
					<div>
						<input type="text" class="form-control ipt-data-compra" name="data_compra">
					</div>
				</div>
				<div class="col-md-6">
					<label for="cnpj">Cnpj</label>
					<div>
						<input type="text" class="form-control ipt-cnpj" name="cnpj">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<label for="imagem">Imagem Nota Fiscal</label>
					<div>
						<input type="file" class="form-control ipt-imagem" name="imagem">
						<p class="help-block" style="font-size: 11px;">(Tamanho máximo: 10MB. Formatos: PNG,JPG OU PDF)</p>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<p style="padding: 35px 25px;font-weight:800;font-size: 15px;">
						Insira nos campos abaixo o nome e a quantidade de produtos participantes presentes em sua nota fiscal. Confira a lista de produtos clicando
						<a href="#">aqui</a>.
					</p>
				</div>
			</div>
			<div class="form-group content-produtos">
				<div class="content-produto">
					<div class="col-md-10">
						<label  for="">Produto</label>
						<div>
							<input type="text" class="form-control ipt-produto" name="produto[]" autocomplete="off">
							<input type="hidden" class="ipt-id-produto" name="id_produto[]">
							<div style="background-color:#FFF;border: 1px solid #ccc;padding: 10px 20px 8px 20px;border-radius: 3px;cursor: pointer;font-size: 11px;position: absolute;z-index: 1000;display: none;" class="search-product">
							</div>
						</div>
					</div>
					<div class="col-md-1">
						<label for="nome">Quantidade</label>
						<div>
							<input type="number" class="form-control ipt-quantidade" name="quantidade[]">
						</div>
					</div>
					<div class="col-md-1">
						<label  for="nome">&nbsp;</label>
						<div>
							<button type="button" class="btn form-control btn-mais-produto" name="btn_mais_produto">
								<i class="glyphicon glyphicon-plus"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12" style="margin-top: 15px;">
					<button type="submit" class="btn btn-enviar" name="enviar" value="enviar">Enviar</button>		
				</div>
			</div>
		</form>
	</div>
</div>
