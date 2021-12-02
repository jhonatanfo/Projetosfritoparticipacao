<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

defined("SSX") or die;

class SsxFacebook
{
	/**
	 * Facebook object
	 * @var Facebook
	 */
	public $facebook;
	
	public $userId = 0;
	
	public $signed_request;
	
	public $access_token;
	
	private $session_name = "__ssx_facebook";
	
	private $app_id;
	
	private $app_access_token;
	
	const FB_IMAGE = "https://graph.facebook.com/";
	
	public function __construct($args)
	{
		 if(!class_exists('Facebook'))
 			require (RESOURCEPATH . "facebook/facebook.php");
 			
 		 if(!is_array($args))
 		 	unset($this);	
 			
 		 $this->facebook = new Facebook($args);
		 $this->app_id = $args['appId'];				   
		 $this->access_token = $this->facebook->getAccessToken();
		 $this->getSignedRequest();
		 $this->app_access_token = $this->getApplicationToken( $args['appId'], $args['app_secret']);
	}
	
	
	
	private function getSignedRequest()
	{
		$ssx_facebook_session = SsxSession::getSession($this->session_name);
		
		$signed_request = $this->facebook->getSignedRequest();
		
		if(!$signed_request)
		{
			if(isset($ssx_facebook_session['__signed_request']) && $ssx_facebook_session['__signed_request'])
			{
				$signed_request = $ssx_facebook_session['__signed_request'];
			}
		}else
		{
			$ssx_facebook_session['__signed_request'] = $signed_request;
		}
		if($ssx_facebook_session)
			SsxSession::openSession($ssx_facebook_session,true,$this->session_name,false);
			
		$this->signed_request = $signed_request;
	}
	
	public function signed_request()
	{
		return SsxSession::getSession($this->session_name);
	}
	
	public function permissionsUrl($scope="user_about_me", $redirect_uri="")
	{
		 $permissions = array(
      		'scope'=>$scope,
		 	'cancel_url'    	=> 'http://facebook.com',
		 	
		 ); 
		 
		 if(isset($redirect_uri) && $redirect_uri)
		 {
		 	$permissions['redirect_uri'] = $redirect_uri;
		 }
     
		 $request = $this->facebook->getLoginUrl($permissions);
		 return $request;
	}
	
	public function getPermissions()
	{
		 $id = $this->getUserId();
		 
		 if($id == 0)
		 {
		 	 if(isset($_SESSION['facebook_id_data']) && $_SESSION['facebook_id_data'])
		 		 $id = $_SESSION['facebook_id_data'];
		 	 else
		 	 	return false;
		 }
		 
		 $this->userId = $id;
		 $_SESSION['facebook_id_data'] = $this->userId;
		 $this->access_token = $this->facebook->getAccessToken();
		 return true;
	}
	
	private function getUserId()
	{
		$userId = $this->facebook->getUser();
		return $userId;
	}
	
	public function inCountry($country="br")
	{
		$signed_request = $this->signed_request();
		if(isset($signed_request['user']['country']) && $signed_request['user']['country'] == $country) {
	    	   return true;
	    }
	    return false;
	}
	
	public function isLike()
	{
		$signed_request = $this->signed_request();
		if(!isset($signed_request['page']['liked']) || !$signed_request['page']['liked']) {
	    	   return false;
	    }
	    return true;
	}
	
	public function getDataUser($userId, $detail=false)
	{
		if(!$userId)
		   return false;
		
		try
		{
			$userData = $this->facebook->api("/".$userId);
			if(!$userData)
			   return false;
			   
 
			if(!$detail){
				$userReturn = array(
					'id'=>$userData['id'],    
					'name'=>$userData['name'],
				    'gender'=>$userData['gender'],
					'image'=>self::FB_IMAGE . $userId ."/picture",
				    'image_large'=>self::FB_IMAGE . $userId ."/picture?type=large"
				);
			}else{
				$userData['image'] = self::FB_IMAGE . $userId ."/picture";
				$userData['image_large'] = self::FB_IMAGE . $userId ."/picture?type=large";
				$userReturn = $userData;
			}
			return $userReturn;
			
		}catch(Exception $e)
		{
			return false;
		}
	}
	
	private function getApplicationToken($app_id, $app_secret)
	{
		$token_url =    "https://graph.facebook.com/oauth/access_token?" .
                "client_id=" . $app_id .
                "&client_secret=" . $app_secret .
                "&grant_type=client_credentials";
		$app_token = @file_get_contents($token_url);
		return $app_token;
	}
	
	public function check_have_permission($permission)
	{
		if(!$this->userId)
			return false;
			
		
	}
	
	public function sendMessage($userId,$message = array()) {
		if(!is_array($message)){
			$message = array('message'=>$message);
		}
		try 
		{
			$statusUpdate = $this->facebook->api('/' . $userId . '/feed?access_token='.$this->access_token, 'post', $message );
			return $statusUpdate;
		} catch (FacebookApiException $e) 
		{
			return $e;
		}
	}
	
	public function inviteFriends($userId,$message = array()) 
	{
		if(!is_array($message)){
			$message = array('message'=>$message);
		}
		try {
			$statusUpdate = $this->facebook->api('/' . $userId . '/apprequests?'.$this->app_access_token, 'post', $message );
			return $statusUpdate;
		} catch (FacebookApiException $e) {
			return $e;
		}
	}
	
	public function sendNotification($userId, $url, $message)
	{
		if(!$userId)
			return;	
			
		$params = array(
			'href'=>$url,
			'template'=>$message
		);
		
		try 
		{
			$statusUpdate = $this->facebook->api('/' . $userId . '/notifications?'.$this->app_access_token, 'post', $params );
			return $statusUpdate;
		} catch (Exception $e) 
		{
			return $e;
		}
		
		
	}
	
	
}

