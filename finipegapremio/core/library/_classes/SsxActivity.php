<?php
/**
 * Similar a SsxFilterDispatcher
 * mas não está acoplada a nenhuma classe
 * será chamada em qualquer lugar da aplicação
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

defined("SSX") or die;

class SsxActivity
{
	/**
	 * Default activities
	 */
	const SSX_THEME_CONFIG_LOADED 	= "ssx_theme_config_loaded";
	const SSX_MODULE_LOADED 		= "ssx_module_loaded";
	const SSX_ACTION_LOADED 		= "ssx_action_loaded";
	const SSX_HEAD 					= "ssx_head";
	const SSX_DISPLAY 				= "ssx_display";
	const SSX_USER_AUTH 			= "ssx_user_auth";
	const SSX_SAVE_USER 			= "ssx_save_user";
	
	private static $activity = array();
	
	public static function addListener($action, $Function)
	{
		if(!is_string($action))
			return false;
			
		$data = array();
		if(is_callable($Function, true))
		{
			$data = array(
				'callback'=>$Function
			);
			
			if(!isset(self::$activity[$action]))
				self::$activity[$action] = array();
							
			array_push(self::$activity[$action], $data);
		}
	}
	
	
	public static function removeListener($action, $Function)
	{
		if(!is_string($action) || count(self::$activity) < 1)
			return;
			
			
		$data = array();
		$callbackname = "";
		if(is_callable($Function, true, $callbackname))
		{
			if(isset(self::$activity[$action]))
			{
				foreach(self::$activity[$action] as $key => $callbacks)
				{
					$call = "";
					if(is_callable($callbacks['callback'], true, $call))
					{
						if($call == $callbackname)
						{
							unset(self::$activity[$action][$key]);
							return true;
						}
					}
				}
			}			
		}
	}
	
	public static function dispatchActivity($action, $resource=null)
	{
		if(!is_string($action))	
			return;
			
		if(isset(self::$activity[$action]) && count(self::$activity[$action])>0)
		{
			foreach(self::$activity[$action] as $callbacks)
			{
				$resource = call_user_func($callbacks['callback'], $resource);
			}
		}
		return $resource;
	}
}