<?php
/**
 * 
 * @author jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

defined("SSX") or die;

class SsxUsers extends SsxModels
{
	public $link;
	
	public $table_name = "ssx_user";
	
	public $fields = array(
		'id',
	    'created_by',
	    'date_created',
	    'modified_by',
	 	'date_modified',
	    'deleted',
	    'name',
		'user',
	    'email',
	    'password',
	    'status'
	);
	
	
	private static $session_name = "__ssx_user_session";
	
	private static $user_permissions;
	
	public function SsxUsers()
	{
		
		parent::super();
		

	}

	
	public function save($data)
	{
		if(isset($data['password']) && $data['password'])
		{
			$data['password'] = parent::encryptPassword($data['password']);
		}
		
		
		
		$id = parent::saveValues($data, true);
		
		$SsxUserGroups = new SsxUserGroups();
		
		// verifica se o usuário já está em algum grupo
		$in_group = $SsxUserGroups->getGroupByUser($id);
		
		if(!$in_group && (!isset($data['group_id']) || !$data['group_id']))
		{
			// traz o grupo default caso ele tenha sido indicado
			$group_default = SsxConfig::get(SsxConfig::SSX_DEFAULT_USER_GROUP);
			
			if($group_default)
			{
				$data['group_id'] = $group_default;
			}
		}
		/* relações com o grupo */
		if(isset($data['group_id']) && $data['group_id'])
		{
			
			
			$relation = $SsxUserGroups->getRelations($id, $data['group_id']);
			if(!$relation)
			{
				if($in_group)
				{
					$SsxUserGroups->removeRelationByUser($id);
				}
				
				$SsxUserGroups->save(array('group_id'=>$data['group_id'],'user_id'=>$id));
			}
		}
		
		SsxActivity::dispatchActivity(SsxActivity::SSX_SAVE_USER,$id);
		return $id;
	}
	
	public function auth($user, $pass, $cookie_verification=true)
	{
		global $Ssx;
		
		$dataLogin = array(
			'password'=>parent::encryptPassword($pass),
			'status'=>1,
			'deleted'=>"0"								   
		);
		
		if($Ssx->utils->check_email($user))
		{
			$dataLogin['email'] = $user;
		}else{
			$dataLogin['user'] = $user;
		}
		
		$authData = parent::filterData($dataLogin,true);
		if($authData)
		{
			$SsxUserGroups = new SsxUserGroups();
			
			$groups = $SsxUserGroups->getGroupByUser($authData['id']);
			
			if(isset($groups) && $groups)
			{
				
				$session_data = array(
					'user_id'=>$authData['id'],
					'group_id'=>$groups['id']
				);
				
				
				SsxSession::openSession($session_data,true, self::$session_name,$cookie_verification);
				
				SsxActivity::dispatchActivity(SsxActivity::SSX_USER_AUTH);
				
				// gera novas permissões
				$SsxAcl = new SsxAcl();
				
				$permissions = $SsxAcl->getPermissionByGroup($session_data['group_id']);
				
				SsxUsers::setPermission($permissions);
				
				if(!SsxAcl::checkPermissionForLocal(the_platform()))
				{			
					self::logout(false);
					
					return false;
				}
				return true;
			}
			
		}
		return false;
	}
	
	public function delete($id)
	{
		return parent::definityDelete($id);
	}
	
	public static function login($user,$pass)
	{
		$SsxUsers = new SsxUsers;
		return $SsxUsers->auth($user,$pass);
	}
	
	public function activeStatus($id){ $this->save(array('id'=>$id, 'status'=>'1')); }
	public function desactiveStatus($id){ $this->save(array('id'=>$id, 'status'=>'0')); }
	
	public function getByEmail($email){ return parent::filterData(array('email'=>$email, 'deleted'=>'0'),true); }
	public function getByUser($user)  { return parent::filterData(array('user'=>$user, 'deleted'=>'0'),true);   }
	
	public static function getDataSession()
	{
		return SsxSession::getSession(self::$session_name);
	}
	
	/**
	 * Retorna o id do usuário que está logado
	 * @var guest Caso seja indicada, ele retornará false caso o usuário logado seja um visitante
	 * @return string|boolean
	 */
	public static function getUser($guest=false)
	{
		$session = self::getDataSession();
		if(!$session)
			return false;
			
		if(isset($session['user_id']) && $session['user_id'])
		{
			if(!$guest)
			{
				$SsxUserGroups = new SsxUserGroups();
				$gp = $SsxUserGroups->getGroupByUser($session['user_id']);
				if($gp['level'] == SsxGroups::LEVEL_GUEST)
					return false;
			}
			
			return $session['user_id'];
		}
		return false;
	}
	
	public static function getSessionName()
	{
		return self::$session_name;
	}
	
	public static function getPermission(){ return self::$user_permissions;}
	public static function setPermission($permission){self::$user_permissions = $permission;}
	
	/**
	 * Função removida
	 */
	public static function restrict()
	{
		// função removida
	}
	
	public static function recoverPass($email, $url_callback="")
	{
		if(!$url_callback)
			$url_callback = projecturl() . "admin/auth/login";
		
		$SsxUsers = new SsxUsers();
		$SsxUserToken = new SsxUserToken();
		
		$auth = $SsxUsers->getByEmail($email);
		if(!$auth)
			return false;
			
		$token = $SsxUserToken->generateToken($auth['id']);
		
		$urlRequest = array(
			'm'=>$auth['id'],
			'l'=>true,
			't'=>$token
		);
		
		$query = http_build_query($urlRequest);
		
		$callback = $url_callback . "?" . $query;
		
		$SsxMail = new SsxMail();
		
		$SsxMail->mail->CharSet   = "UTF-8"; 
		
		$body = "
			<h2>Recuperação de senha:</h2>
			
			Você solicitou alteração de senha dá area administrativa<br /><br />
			
			Seu login é: ".$auth['user']."
			
			Acesse ".$callback." para alterar sua senha <br /><br />
			
			Equipe Fri.to
		";
		
		$send = $SsxMail->SimpleSend(array(
			  		'from'		=>	array('email'	=>	'no-reply@fri.to', 'name' =>	'Area administrativa fri.to'),
					'addresses' =>  array(
							array('email'	=> $email, 'name'	=>	$auth['name']),
							),
			  		'subject'	=>	'Recuperação de Senha - Área administrativa',
			  		'body'		=>	$body,
			  ));
			  
		return $send;
	}
	
	public static function logout($redirect=true, $redirect_url="")
	{
		if(!$redirect_url)
			$redirect_url = get_url('auth', 'login');
		
		SsxSession::dropSession(self::$session_name);
		
		if($redirect)
			header_redirect($redirect_url);

	}
}