<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

  defined("SSX") or die;

  date_default_timezone_set('America/Recife');
  
  error_reporting(E_ALL);
  
  
  define('RESOURCEPATH', COREPATH . "resources/");
  
  define('LIBPATH', COREPATH . "library/");
  
  define('INCLUDEPATH', COREPATH . "includes/");
  
  define('CONFIGPATH', realpath(COREPATH . "../set/") . "/");

  
  if(defined('IS_ADMIN') && IS_ADMIN)
  {
  	  define('PROJECTPATH', realpath(LOCALPATH . "../") . "/");	  
  }else if(constant('LOCALPATH') == constant('COREPATH'))
  {
  	  define('PROJECTPATH', realpath(LOCALPATH . "../") . "/");	  
  }else
  {
  	  define('PROJECTPATH', LOCALPATH);
  }
  
  // arquivo de erros comuns no sistema
  if(!file_exists(INCLUDEPATH . "errors.php"))
	  die("CONSIST&Ecirc;NCIA DO SISTEMA COMPROMETIDA");
  require_once(INCLUDEPATH . "errors.php");
  
  
  // arquivo de funções gerais do sistema
  if(!file_exists(INCLUDEPATH . "functions.php"))
	  die("CONSIST&Ecirc;NCIA DO SISTEMA COMPROMETIDA");
  require_once(INCLUDEPATH . "functions.php");
  
  // arquivo de funções gerais do sistema
  if(!file_exists(INCLUDEPATH . "ssx_version.php"))
	  die("CONSIST&Ecirc;NCIA DO SISTEMA COMPROMETIDA");
  require_once(INCLUDEPATH . "ssx_version.php");
  
  // arquivo de configurações de banco de dados
  if(file_exists(CONFIGPATH . "config_set.php"))
  {
  	 require_once(CONFIGPATH . "config_set.php");
  }else if(file_exists(LOCALPATH . "set/config_set.php"))
  {
  	 require_once(LOCALPATH . "set/config_set.php");
  }else if(file_exists(PROJECTPATH . "admin/set/config_set.php"))
  {
  	 require_once(PROJECTPATH . "admin/set/config_set.php");
  }else
  {
  	 die("CONSIST&Ecirc;NCIA DO SISTEMA COMPROMETIDA");
  }
  
  if(defined('ADMIN_ONLY') && ADMIN_ONLY)
  {
  	  define('PLUGINPATH', LOCALPATH . "plugins/");
  }else{
  	  define('PLUGINPATH', PROJECTPATH . "plugins/");
  }
  
  
  
  function ssx_load_classes($class)
  {
  	 if(class_exists($class))
  	    return;
  	 
  	 if(file_exists(COREPATH . "library/classes/".$class.".php"))
	  	 require_once(COREPATH . "library/classes/".$class.".php");
	 else if(file_exists(LOCALPATH . "control/".$class.".php"))
	 	  require_once(LOCALPATH . "control/".$class.".php");
	 else if(file_exists(PROJECTPATH . "admin/control/".$class.".php"))
		  require_once(PROJECTPATH . "admin/control/".$class.".php");
     else if(file_exists(LOCALPATH . "../control/".$class.".php"))
		  require_once(LOCALPATH . "../control/".$class.".php");
	 else
	 {
	 	$file = find_file(RESOURCEPATH,strtolower($class).".php");
	 	if($file)
	 		require_once($file);
	    return;	 
	 }
  }
  
  spl_autoload_register('ssx_load_classes');
  

 global $Ssx;
 // core for all integration
 $Ssx = new Ssx();
 // inicia o controle de acl geral do sistema
 $Ssx->startAcl();
 
 // inicia todos os plugins instalados do sistema
 $Ssx->plugins->startPlugins();
  
 // load em todo o conteúdo de modulos
 include_once(COREPATH . "includes/theme_load.php");
 
 