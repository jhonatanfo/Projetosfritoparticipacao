<?php

class FacebookModel{


	public static function getClientObject(){
		
		require_once COREPATH.'../vendor/autoload.php';

		$fb = new Facebook\Facebook([
		  'app_id' => FACEBOOK_APP_ID, // Replace {app-id} with your app id
		  'app_secret' => FACEBOOK_SECRET_KEY,
		  'graph_api_version' => 'v5.0',
		]);
		return $fb;
	}

	public static function getUrlLogin(){
		$fb = self::getClientObject();		
		$helper = $fb->getRedirectLoginHelper();
		$permissions = ['email']; // Optional permissions
		$url = $helper->getLoginUrl(FACEBOOK_CALLBACK_URL_LOGIN, $permissions);
		return htmlspecialchars($url);
	}

	public static function getUrlCadastro(){
		$fb = self::getClientObject();		
		$helper = $fb->getRedirectLoginHelper();
		$permissions = ['email']; // Optional permissions
		$url = $helper->getLoginUrl(FACEBOOK_CALLBACK_URL_CADASTRO, $permissions);
		return htmlspecialchars($url);
	}

	public static function setToken($token){
		$_SESSION['accessTokenFacebook'] = $token;
	}

	public static function getToken(){
		return isset($_SESSION['accessTokenFacebook']) ? $_SESSION['accessTokenFacebook'] : null;
	}

	public static function logout(){
	  unset($_SESSION['accessTokenFacebook']);
	  if(isset($_SESSION['loginFacebook'])){
	  	unset($_SESSION['loginFacebook']);
	  }
	  return true;
	}

	public static function setLogin($facebookLogin){
		$_SESSION['loginFacebook'] = $facebookLogin;
	}

	public static function getLogin(){
		return isset($_SESSION['loginFacebook']) ? $_SESSION['loginFacebook'] : false;
	}

	public static function fillForm($code=null){

		if(self::getToken()){
			self::logout();
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"cadastre-se"),
									[
										"text"   => "Token de acesso do Facebook expirou. Faça seu login novamente.",
										"status" => "danger",
										"class"  => ""
									]
		    );	
		}

		UsuarioModel::dropSessionLogin(true);

		$fb = self::getClientObject();		
		$helper = $fb->getRedirectLoginHelper();
		$accessToken = $helper->getAccessToken();
		$oAuth2Client = $fb->getOAuth2Client();
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken(strval($accessToken));
		self::setToken($longLivedAccessToken);
		$fb->setDefaultAccessToken($longLivedAccessToken);
		if (!$accessToken) {
			return Array("hasError"=>$helper->getErrorDescription());
		}
		$response = $fb->get('/me?fields=name,last_name,email', $accessToken);
		$userData = $response->getDecodedBody();
		if(isset($userData['id'])){
			$usuario = UsuarioModel::where('facebook_login',$userData['id']);
			self::setLogin($userData['id']);
			if(!$usuario){
				return Array(
							"nome"=>$userData['name'],
							"sobrenome"=>$userData['last_name'],
							"email" => (isset($userData['email']) ? $userData['email'] : ""),
							"facebook_login"=>$userData['id']
					   );
			}
			return Array('hasUser'=>true);
		}
		return false;	
	}

	public static function login($code){
		$fb = self::getClientObject();		
		$helper = $fb->getRedirectLoginHelper();
		$accessToken = $helper->getAccessToken();
		$oAuth2Client = $fb->getOAuth2Client();
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken(strval($accessToken));
		self::setToken($longLivedAccessToken);
		$fb->setDefaultAccessToken($longLivedAccessToken);
		if (!$accessToken) {
			return Array("hasError"=>$helper->getErrorDescription());
		}
		$response = $fb->get('/me?fields=name,last_name,email', $accessToken);
		$userData = $response->getDecodedBody();
		if(isset($userData['id'])){
			$usuario = UsuarioModel::where('facebook_login',$userData['id']);
			if(is_array($usuario) && !empty($usuario)){
				return isset($usuario[0]) ? $usuario[0] : false;
			}
			return Array('hasNotUser'=>true);
		}
		return false;		
	}


}
