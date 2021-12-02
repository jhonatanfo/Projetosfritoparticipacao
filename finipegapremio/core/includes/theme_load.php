<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

  defined("SSX") or die;
  
  global $Ssx;
  

  // verifica se o arquivo de configurações fixas do projeto existe
  if(file_exists(LOCALPATH . "set/theme_config.php"))
      include(LOCALPATH . "set/theme_config.php");
  elseif(file_exists(COREPATH . "../set/theme_config.php") && defined('IS_AJAX') && IS_AJAX)
  	  include(COREPATH . "../set/theme_config.php");
  	  
  // verifica se o arquivo de funções do projeto
  if(file_exists(LOCALPATH . "set/functions.php"))
      include(LOCALPATH . "set/functions.php");
  elseif(file_exists(COREPATH . "../set/functions.php") && defined('IS_AJAX') && IS_AJAX)
  	  include(COREPATH . "../set/functions.php");
  	  
  SsxActivity::dispatchActivity(SsxActivity::SSX_THEME_CONFIG_LOADED);	  
  
  // se caso tiver marcado como ajax, não será carregado nenhum módulo
  if(!defined('IS_AJAX'))
  {
  	  $redirect_url = siteurl() . the_module() . "/" . the_action();
  	
  	  // completando a ação do SsxModules para evitar perca de referencia
  	  if($Ssx->themes->module_found)
  	  {
  	  	  // verifica se o usuário tem permissão para acessar o login
  	  	  if(!SsxAcl::checkPermissionForModule($Ssx->themes->ssx_module, the_platform()))
  	  	  {
  	  	  	  $Ssx->themes->ssx_module = "Home";
  	  	  	  $Ssx->themes->ssx_action = "denied";
  	  	  	  
  	  	  }else{
  	  	  	
	  	  	  // Load no arquivo principal do modulo  	  	  
	  	  	  require_once(LOCALPATH . "modules/". $Ssx->themes->ssx_module . "/" . $Ssx->themes->ssx_module.".php");
	  	  	  
	  	  	  SsxActivity::dispatchActivity(SsxActivity::SSX_MODULE_LOADED);
	  	  	  
	  	  	  if($Ssx->themes->action_found)
	  	  	  {
	  	  	  	  if(!SsxAcl::checkPermissionForAction($Ssx->themes->ssx_module,$Ssx->themes->ssx_action, the_platform()))
	  	  	  	  {
	  	  	  	  	 $Ssx->themes->ssx_module = "Home";
	  	  	  	  	 $Ssx->themes->ssx_action = "denied";
	  	  	  	  	
	  	  	  	  }else
	  	  	  	  {
		  	  	  	  // Load no arquivo secundario, ou seja, da Action
		  	  	  	  require_once(LOCALPATH . "modules/". $Ssx->themes->ssx_module . "/" . $Ssx->themes->ssx_action .".php");
		  	  	  	  
		  	  	  	  if((!defined('NO_RENDER') || !NO_RENDER) && (!defined('IS_AJAX') || !IS_AJAX))
		  	  	  	  {
		  	  	  	  	 if(!file_exists(LOCALPATH . "modules/". $Ssx->themes->ssx_module ."/templates/". $Ssx->themes->ssx_action .".tpl"))
							die(SSX_ERROR_MODULES_03. ":" . $Ssx->themes->ssx_action);
		  	  	  	  }
		  	  	  	  
					  SsxActivity::dispatchActivity(SsxActivity::SSX_ACTION_LOADED);
	  	  	  	  }
	  	  	  }else{
	  	  	  	  $use_slug_action = $Ssx->themes->get_slug_action();
	  	  	  	  if($use_slug_action)
				  {
				  	  $action_replacement = $use_slug_action;
				  	  
				  	  $Ssx->themes->action_found = true;
				  	  $Ssx->themes->ssx_action = $action_replacement;
				  	  
				  	   if(!SsxAcl::checkPermissionForAction($Ssx->themes->ssx_module,$Ssx->themes->ssx_action, the_platform()))
	  	  	  	  	   {
	  	  	  	  	   	
	  	  	  	  	   		 $Ssx->themes->action_found = false;
	  	  	  	  	   		 $Ssx->themes->disable_slug_action();
	  	  	  	  	   		 $Ssx->themes->set_404_action();
	  	  	  	  	   		 
	  	  	  	  	   }else{
	  	  	  	  	   		  if(file_exists(LOCALPATH . "modules/". $Ssx->themes->ssx_module . "/" . $action_replacement .".php"))			  	  
						  	  	 require_once(LOCALPATH . "modules/". $Ssx->themes->ssx_module . "/" . $action_replacement .".php");
						  	  else
						  	  	 die(SSX_ERROR_MODULES_06." Action:'".$action_replacement."'");
						  	  	 
						  	  if(!file_exists(LOCALPATH . "modules/". $Ssx->themes->ssx_module . "/templates/" . $action_replacement .".tpl"))
						  	  	 die(SSX_ERROR_MODULES_07);
		
						  	  SsxActivity::dispatchActivity(SsxActivity::SSX_ACTION_LOADED);
	  	  	  	  	   }
				  }else
				  {
				  	  $Ssx->themes->action_found = false;
				  	  
				  }
	  	  	  }
  	  	  }
  	  }else{
  	  		// modulo não encontrado
  	  		$Ssx->themes->action_found = false;
  	  		$Ssx->themes->disable_slug_action();
  	  		$Ssx->themes->set_404_action();
  	  }
  }