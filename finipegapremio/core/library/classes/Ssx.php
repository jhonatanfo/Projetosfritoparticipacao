<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

defined("SSX") or die;

class Ssx
{
	/**
	 * Item de conexão de banco de dados que será
	 * partilhado em todos as classes que acessarem o banco de dados
	 * 
	 * @var SsxDatabase
	 */
	public $link;
	/**
	 * Contem o controlador geral do tema do projeto
	 * @var SsxModules
	 */
	public $themes;
	
	
	/**
	 * Ativado apenas quando framework esta em modo ajax
	 * @var SsxAjax
	 */
	public $ajax;
	
	/**
	 * Utilitarios gerais do sistema
	 * @var SsxUtils
	 */
	public $utils;
	
	/**
	 * Controle de plugins
	 * @var SsxPlugins
	 */
	public $plugins;
	
	
	/**
	 * Instancia do facebook
	 * @var Facebook
	 */
	public $facebookService;
	
	
	
	
	public function __construct()
	{
		global $Ssx;
		if($Ssx)
		  unset($Ssx);
		  
		$this->openLink();
		
		$this->themes  = new SsxModules();
		$this->utils   = new SsxUtils();
		$this->plugins = new SsxPlugins($this->link);
		
		new SsxRecovery($this->link);
	}
	
	private function openLink()
	{
		
		if((!defined('SSX_DB_HOST') || !SSX_DB_HOST) || (!defined('SSX_DB_TYPE') || !SSX_DB_TYPE))
		{
			die(SSX_ERROR_CORE_03);
		}
		
		$user = defined('SSX_DB_USER') && SSX_DB_USER?SSX_DB_USER:"";
		$pass = defined('SSX_DB_PASS') && SSX_DB_PASS?SSX_DB_PASS:"";
		$database = defined('SSX_DB_DATABASE') && SSX_DB_DATABASE?SSX_DB_DATABASE:"";
		
		$Hosts = new SsxHosts($user, $pass, SSX_DB_HOST, $database, SSX_DB_TYPE);
		
		$Database = new SsxDatabase($Hosts,false);
		// conexão aberta
		$this->link = $Database;
		
		unset($Hosts);
	}   
	
	public function startAcl()
	{
		if(defined('IS_AJAX') && IS_AJAX)
			return false;
		
		global $Ssx;
		
		$SsxUsers = new SsxUsers();
		$SsxAcl = new SsxAcl();
		$SsxGroups = new SsxGroups();
		
		if(!SsxUsers::getUser(true))
			$SsxUsers->auth('guest','123');
		
		
		$_session_name = SsxUsers::getSessionName();
		
		$_session = SsxSession::getSession($_session_name);
		
		$redirect_url = siteurl() . the_module() . "/" . the_action();
		
		if($_session)
		{	
			$permissions = $SsxAcl->getPermissionByGroup($_session['group_id']);
			

			// Apartir desse momento em qualquer momento da view é possível saber se ela tem permissão ou não
			SsxUsers::setPermission($permissions);
						
			$exists = $SsxUsers->fill($_session['user_id']);
			
			if(!$exists)
			{
				SsxSession::dropSession($_session_name);
				
				if(!is_location('auth', 'login'))
				{
					header_redirect(get_url('auth', 'login', array('redirect'=>$redirect_url)));
				}
				return;
			}else{
				$pl = SsxAcl::checkPermissionForLocal(the_platform());
				$group_detail = $SsxGroups->fill($_session['group_id']);
				if(the_platform() == "admin")
				{
					if(!$pl || !SsxAcl::checkPermissionForAction('Home', 'index','admin') || $group_detail['level'] == SsxGroups::LEVEL_GUEST)
					{
						if(!is_location('auth', 'login'))
						{
							header_redirect(get_url('auth', 'login',array('redirect'=>$redirect_url)));
						}
					}
				}
			}
		}else
		{
			$guest_group = $SsxGroups->getGuestGroup();
			$guest_id = isset($guest_group) && isset($guest_group['id'])?$guest_group['id']:"";
			$permissions = $SsxAcl->getPermissionByGroup($guest_id);
			
			SsxUsers::setPermission($permissions);
			
			$pl = SsxAcl::checkPermissionForLocal(the_platform());
			
			if(the_platform() == "admin")
			{
				if(!is_location('auth', 'login'))
				{
					header_redirect(get_url('auth', 'login',array('redirect'=>$redirect_url)));
				}
			}
			return;
		}
	}
    
    
    public function shutDown()
    {
    	$this->link->off();
    }
}