<?php
/**
 * Arquivo de instalação do framework
 * Configuração de banco de dados e afins
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

/* Indica que a aplicação irá exibir os erros que ocorrerem no mysql */
define('MYSQL_ERROR_SHOW_WARNINGS', false);

/* Indica que a aplicação dropar toda a aplicação quando ocorrer algum erro de mysql
 * Exibirá o errro e dropará a aplicacao mesmo que a opção se aviso esteja desabilitada */
define('MYSQL_ERROR_DROP_APPLICATION', false);

define('IS_AJAX', true);

require_once('core.php');

defined("SSX") or die;

if(defined('DISABLE_INSTALL') && DISABLE_INSTALL)
	header_redirect(projecturl() . "../");

global $Ssx;

/******
 * HTML JUNTO COM PHP NECESSÁRIO PARA INSTALAÇÃO
 * PORCO, MAS NECESSÁRIO
 */
?>
<html>
 <head>
 	<title>Ssx Framework - Instala&ccedil;&atilde;o de recursos</title>
 </head>
 <body>
<?php 

// Verifica se há uma conexão válida no sistema
if(!$Ssx->link->check_connection())
{
	if(get_request(''))
?>
	<div style='margin:auto; width:920px;'>
		<h2>Ssx Framework - Instala&ccedil;&atilde;o de recursos</h2>
		<p>
			Não h&aacute; uma conex&atilde;o de banco de dados v&aacute;lida para o framework
		</p>
		<div>
			<h4>Informe os dados de acesso do banco de dados</h4>
			<form action="" method="post">
			<table>
				<tr>
					<td>Host:</td>
					<td><input type='text' value='localhost' name='host_name' /></td>
				</tr>
				<tr>
					<td>User:</td>
					<td><input type='text' value='root' name='user_name' /></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type='text' value='password' name='pass_text' /></td>
				</tr>
				<tr>
					<td>Database name:</td>
					<td><input type='text' value='' name='db_name' /></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type='submit' name='connect' value='Conectar' />
					</td>
				</tr>
			</table>
			</form>
		</div>
	</div>
<?php 
}else{
	
}

?>
</body>
</html>