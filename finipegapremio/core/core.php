<?php
/**
 *  Arquivo de inicialização do Ssx
 *   
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.2.0
 *  @since 09/01/2011
 *  
 *  Todos os arquivos dentro da pasta CORE, são de propriedade
 *  da Skyjaz Games
 *  skyjaz.com
 *  
 */
  
  require_once('Sanitize.php');
 
  // Filtra HTML e SQL Injection em todos os campos
  $_GET = Sanitize::filter($_GET);
  $_POST = Sanitize::filter($_POST);
  $_REQUEST = Sanitize::filter($_REQUEST);

  // Coloca todos os cookies como HttpOnly
  // ini_set("session.cookie_httponly", 1);
  // ini_set("session.cookie_secure", 1);
  // ini_set("session.cookie_path", '/adidas/runbase/admin/');
  
  set_time_limit(0);
  
  if(!session_id())
    session_start(); 
    
  header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
  
  
  if(!defined('COREPATH'))
   define( 'COREPATH', dirname(__FILE__) . '/' );
   
  if(!defined('LOCALPATH'))
     define('LOCALPATH', COREPATH );
  
  define( 'SSX', 'secure' );
  
  include_once( COREPATH . "includes/integration.php");
