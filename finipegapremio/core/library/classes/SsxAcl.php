<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * @since 02/05/2012
 * 
 */

defined("SSX") or die;

class SsxAcl extends SsxModels
{
	public $link;
	
	public $table_name = "ssx_acl_group";
	
	public $fields = array(
		'id',
		'created_by',
		'date_created',
		'modified_by',
		'date_modified',
		'group_id',
		'permissions'
	);
	
	private $_cache_dir;
	
	public function __construct()
	{
		// jamais usar SsxAcl dentro de algum ajax
		parent::super();
	}
	
	public function save($data)
	{
		return parent::saveValues($data);
	}
	
	public function getByGroup($group_id)
	{
		return parent::filterData(array('group_id'=>$group_id), true);
	}
	
	/**
	 * Lista todos os modulos e actions que tem no projeto
	 * Tanto dentro do admin como também no proprio projeto em sí
	 * para configurar o sistema de acl partindo das actions.
	 * 
	 * 
	 */
	public function getModulesAndActions()
	{
		if($this->_cache_dir)
			return $this->_cache_dir;
		
		$pathInfo_project = false;
		$pathInfo_admin = false;
		
		if(defined('IS_ADMIN'))
		{
			if(!defined('ADMIN_ONLY') || !ADMIN_ONLY)
				$pathInfo_project = realpath(LOCALPATH . "../") . "/";
			$pathInfo_admin = LOCALPATH;
		}else
		{
			$pathInfo_project = LOCALPATH;
			if(defined('ADMIN_EXISTS') && ADMIN_EXISTS)
			{
				$pathInfo_admin = LOCALPATH . "admin/";
			}
		}	

		$returnData = array();
		
		if($pathInfo_project)
		{
			$projectInfo = $this->getModulesByDir($pathInfo_project . "modules/");
			if($projectInfo)
				$returnData['project'] = $projectInfo;
		}
		
		if($pathInfo_admin)
		{
			$adminInfo = $this->getModulesByDir($pathInfo_admin . "modules/");
			if($adminInfo)
				$returnData['admin'] = $adminInfo;
		}
		$this->_cache_dir = $returnData;	
		
		return $returnData;
	}
	
	public function defaultPermission()
	{
		$modulesAndActions = $this->getModulesAndActions();
		if(!is_array($modulesAndActions) || !$modulesAndActions)
			return false;
			
		foreach($modulesAndActions as $local => $pos)
		{
			$modulesAndActions[$local]['_access'] = 'A';
			foreach($pos['modules'] as $modules => $actions)
			{					
				foreach($actions as $act)
				{
					$action_permissions = array();
					foreach($act as $action)
					{
						if(($modules == "Auth" && ($action == "login" || $action == "logout")))
							$action_permissions[$action] = 'A';
						else
							$action_permissions[$action] = 'D';
					}
					
					$modulesAndActions[$local]['modules'][$modules]['actions'] = $action_permissions;
				}
				
			}
		}
		return $modulesAndActions;
	}
	
	public function setPermission($groupPermissions)
	{	
		if(!is_array($groupPermissions) && $groupPermissions != "all_access")
			return false;
			
		$modulesAndActions = $this->defaultPermission();

		
		foreach($modulesAndActions as $local => $pos)
		{
			if(is_array($groupPermissions) && isset($groupPermissions[$local]['_access']) && $groupPermissions[$local]['_access'])
				$modulesAndActions[$local]['_access'] = $groupPermissions[$local]['_access'];
			else
				$modulesAndActions[$local]['_access'] = 'A';
			
			foreach($pos['modules'] as $modules => $actions)
			{					
				foreach($actions as $act)
				{
					$action_permissions = array();
					foreach($act as $action => $value)
					{
						if(is_array($groupPermissions) && isset($groupPermissions[$local]['modules'][$modules]['actions'][$action]) && $groupPermissions[$local]['modules'][$modules]['actions'][$action])
						{
							
							$modulesAndActions[$local]['modules'][$modules]['actions'][$action] = $groupPermissions[$local]['modules'][$modules]['actions'][$action];
							
						}else if($groupPermissions == "all_access")
						{
							$modulesAndActions[$local]['modules'][$modules]['actions'][$action] = "A";
						}
					}
					
					
				}
				
			}
		}
		
		
		return $modulesAndActions;
	}
	
	public static function checkPermissionForLocal($local)
	{
		$permissions = SsxUsers::getPermission();
		if(!is_array($permissions))
			return false;
			
		if(isset($permissions[$local]['_access']) && $permissions[$local]['_access'] == "A")
			return true;
			
		return false;
	}
	
	public static function checkPermissionForModule($module="Home", $local="project")
	{
		
		$permissions = SsxUsers::getPermission();
		if(!is_array($permissions))
			return false;
			
		if($module == "Auth" && $local == "admin")
			return true;
			
				
		if(isset($permissions[$local]['_access']) && $permissions[$local]['_access'] == "A")
		{	
			if(isset($permissions[$local]['modules'][$module]['actions']) && $permissions[$local]['modules'][$module]['actions'])
			{
				foreach($permissions[$local]['modules'][$module]['actions'] as $actions)
				{
					if($actions == "A")
						return true;
				}
			}
		}
			
		return false;
	}
	
	public static function checkPermissionForAction($module="Home", $action="index", $local = "project")
	{
		$permissions = SsxUsers::getPermission();
		if(!is_array($permissions))
			return false;

		if($module == "Auth" && $action == "login" && $local == "admin")
			return true;
			
		if(isset($permissions[$local]['_access']) && $permissions[$local]['_access'] == "A")
		{	
			if(isset($permissions[$local]['modules'][$module]) && $permissions[$local]['modules'][$module])
			{
				if(isset($permissions[$local]['modules'][$module]['actions'][$action]) && $permissions[$local]['modules'][$module]['actions'][$action] == "A")
				{
					return true;
				}
			}
		}
			
		return false;
	}
	
	/**
	 *
	 * Retorna as permissões do grupo
	 * Caso não as encontre, retorna a permissão padrão para todos os grupos que não possuem permissões setadas
	 * que só permite acesso a home e ao login
	 * 
	 * @return array
	 */
	public function getPermissionByGroup($group_id)
	{		
		$data = $this->getByGroup($group_id);
		
		if(!$data)
			return $this->defaultPermission();
			
		$permissions = $data['permissions'];
		if(!$permissions)
			return $this->defaultPermission();
			
		if($permissions == "all_access")
			return $this->setPermission($permissions);	
		
		try
		{
			$permissions = @unserialize($permissions);
			if(!$permissions)
				throw new Exception("Erro");
		}catch(Exception $e)
		{
			return $this->defaultPermission();
		}
			
		return $this->setPermission($permissions);		
	}
	
	/**
	 * Vasculha a pasta indicada para ver se tem um modulo valido e as ações dele
	 * @param string $dir_url
	 */
	private function getModulesByDir($dir_url)
	{
		if(!file_exists($dir_url))
			return false;
			
		$modules_data = array();
		
		$dir = scandir($dir_url);
		
		if($dir)
		{
			foreach($dir as $row)
			{
				if($row == ".." || $row == ".")
					continue;
				
				if(is_dir($dir_url . $row))
				{
					if(file_exists($dir_url . $row . "/" . $row . ".php" ))
					{
						$mod_aval = scandir($dir_url . $row);
						
						if($mod_aval)
						{
							foreach($mod_aval as $list)
							{
								if($list == ".." || $list == "." || $list == $row . ".php" )
									continue;
									
								$action = str_replace(".php", "", $list);
									
								if(!is_dir($dir_url . $row . "/" . $action) && file_exists($dir_url . $row . "/templates/" . $action . ".tpl"))
								{
									$modules_data['modules'][$row]['actions'][] = $action;
								}
							}
						}
					}
				}
			}
		}
		
			
		return $modules_data;
	}
	
	public function convertToViewAccess($permissions)
	{
		if(!$permissions || !is_array($permissions))
		 	$permissions = $this->defaultPermission();
		 	
		 $return = array();	
		 	
		foreach($permissions as $platform => $access)
		{
			if($access['_access'] == "A")
			{
				foreach($access['modules'] as $module => $actions)
				{
					foreach($actions['actions'] as $action => $permission)
					{
						$return[$platform][strtolower($module)][strtolower($action)] =($permission == "A")?true:false;
					}
				}
			}
		}
		if(isset($return[the_platform()][the_module()]))
			$return["this_module"] = $return[the_platform()][the_module()];
		
		if(isset($return[the_platform()][the_module()][the_action()]))
			$return["this_module"]['this_action'] = $return[the_platform()][the_module()][the_action()];
		
		return $return;
	}
}