<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h3>Dashboard <small>Usuários</small></h3>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4 ">
		<div class="panel panel-default">
		  <div class="panel-body">
		    <h5>Cadastros com e sem nota fiscal</h5>	
		     <div id="graf_com_sem_nf"></div>	
		  </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-body">
		    <h5>Cadastros por gênero</h5>		
		    <div id="graf_genero"></div>
		  </div>
		</div>
	</div>	
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-body">
		    <h5>Cadastros por estado</h5>	
		     <div id="graf_estado"></div>	
		  </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-body">
		    <h5>Cadastros por idade</h5>		
		    <div id="graf_idade"></div>	
		  </div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<h5>Cadastro de usuários por dia</h5>
				<div id="graf_usuario"></div>
				<div class="text-right" style="margin-right: 15px">
					<p>Total: <b>{$total_usuarios}</b></p>
		    		<p>Média/Dia: <b>{$media_usuarios_dia}</b></p>	
				</div>				
			</div>			
		</div>
	</div>	
</div>


<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h3>Dashboard <small>Notas Fiscais</small></h3>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-body">
		    <h5>Auditoria Vale-brinde</h5>		
		    <div id="graf_auditoria"></div>	
		  </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-body">
		    <h5>Top 5 produtos mais cadastrados</h5>		
		    <div id="graf_produtos"></div>	
		  </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-body">
		    <h5>Top 5 usuários com mais notas cadastradas</h5>	
		     <div id="graf_usuariosnotas"></div>
		  </div>
		</div>
	</div>	
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-body">
		    <h5>Top 5 cnpjs com mais notas cadastradas</h5>	
		     <div id="graf_cnpjs"></div>
		  </div>
		</div>
	</div>	
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<h5>Cadastro de notas fiscais por dia</h5>
				<div id="graf_nota"></div>
				<div class="text-right" style="margin-right: 15px">
					<p>Total: <b>{$total_notas_fiscais}</b></p>
		    		<p>Média/Dia: <b>{$media_notas_fiscais_dia}</b></p>	
				</div>				
			</div>			
		</div>
	</div>	
</div>

<script type="text/javascript">
	{$graf_genero}
	{$graf_com_sem_nf}
	{$graf_idade}
	{$graf_usuario}
	{$graf_estado}
	{$graf_nota}	
	{$graf_auditoria}
	{$graf_produtos}
	{$graf_usuariosnotas}
	{$graf_cnpjs}
</script>