<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

defined("SSX") or die;

/* Define o tipo de banco de Dados*/
define('SSX_DB_TYPE', 'mysql');

/* Define o user do banco*/
define('SSX_DB_USER', 'fini_pegapremio');

/* Define o password do banco de dados*/
define('SSX_DB_PASS', 'Cq2FC6wVb6vyLSyu');

/* Define o host (localizacao) do banco de dados */
define('SSX_DB_HOST', '205.186.154.82');

define('SSX_DB_PORT','3306');

/* Define o nome do banco de dados*/
define('SSX_DB_DATABASE', 'fini_promo_pegapremio');

/* Define o tema do projeto */
define('SSX_THEME', 'default');

/* Define a encoding do projeto */
define('SSX_ENCODING', 'UTF-8');

/* desativa o acesso ao arquivo de instalação */
define('DISABLE_INSTALL', false);


/*Define dados do enviador de email*/
define('PHPMAILER_CHARSET','UTF-8');

define('PHPMAILER_HOST','smtp.gmail.com');

define('PHPMAILER_PORT',587);

define('PHPMAILER_SMTPSECURE','tls');

define('PHPMAILER_SMTPAUTH',true);

define('PHPMAILER_USERNAME',"dennis.santana@fri.to");

define('PHPMAILER_PASSWORD',"qgwfroqgqvofhkuu");

define('PHPMAILER_DEBUG',false);

/*Define os dados de email do contato da promo*/
define('EMAILCONTATO','dennis.santana@fri.to');
define('NOMECONTATO', 'FINI - Pega Prêmio');
define('ASSUNTOCONTATO','Promoção Fini Pega Prêmio | Contato');

/*
	Define o dados de inicio e fim promoção
	PRODUÇÃO
	define("INI_PROMO",strtotime('2020-02-21 00:00:00'));
	define("FIM_PROMO",strtotime('2020-04-06 23:59:59'));
*/

/*
	Define o dados de inicio e fim promoção
	DESENVOLVIMENTO
*/
define("INI_PROMO",strtotime('2020-02-03 00:00:00'));
define("FIM_PROMO",strtotime('2020-04-06 23:59:59'));


/*Define número da sorte máximo que é possível sair na sua geração*/
define('NUMERO_DA_SORTE_MAX',99999);
/*Define série máxima que é possível sair na sua geração*/
define('SERIE_MAX',99);

/*Define a quantidade máxima de cadastro de notas fiscais*/
// define('MAX_CAD_NOTA_POR_USR',30);

/*Define a quantidade máxima de produto por nota fiscal*/
define('MAX_PROD_POR_NOTA',100);

/*Define o tamanho máximo de upload de imagem de nota fiscal*/
define('MAX_MB_IMAGE_FILE',10);

/*Define proporção de Megabyte*/
define('MB',(1024*1024));

/*Define url usado no esqueci minha senha*/
define("SITEURL",siteurl());

define("GOOGLE_API_KEY","AIzaSyAVwMRrC5xmNs9epwkSV_1XeAw_yUkDmq4");
define("GOOGLE_CLIENT_ID","209208663890-q7rn16dukumumoigprg9mcoqb3hbe85s.apps.googleusercontent.com");
define("GOOGLE_SECRET_KEY","ixdjARzT5Zka8zAxvHbAXFtJ");
define("GOOGLE_APPLICATION_CREDENTIALS","client_secret_209208663890-q7rn16dukumumoigprg9mcoqb3hbe85s.apps.googleusercontent.com.json");
define("GOOGLE_CALLBACK_URL_LOGIN",sprintf("%s%s",siteurl(),"login/google"));
define("GOOGLE_CALLBACK_URL_CADASTRO",sprintf("%s%s",siteurl(),"cadastre-se/google"));

// define("FACEBOOK_APP_ID","1233074886897106");
// define("FACEBOOK_SECRET_KEY","fbd84641e80dd2efe86db673fc8dccd0");

define("FACEBOOK_APP_ID","596946084419397");
define("FACEBOOK_SECRET_KEY","7c1e9547e1a916f07b1885fd173fe025");
define("FACEBOOK_CALLBACK_URL_LOGIN",sprintf("%s%s",str_replace(':443','', siteurl()),"login/facebook"));
define("FACEBOOK_CALLBACK_URL_CADASTRO",sprintf("%s%s",str_replace(':443','', siteurl()),"cadastre-se/facebook"));

