<?php

class GoogleModel{


	public static function getClientObject($callbackUrl='login'){
		
		require_once COREPATH.'../vendor/autoload.php';

		$client_id = GOOGLE_CLIENT_ID;
		$client_secret = GOOGLE_SECRET_KEY;
		
		if($callbackUrl == "login"){
			$redirect_uri = GOOGLE_CALLBACK_URL_LOGIN;	
		}else if($callbackUrl == "cadastro"){
			$redirect_uri = GOOGLE_CALLBACK_URL_CADASTRO;	
		}		

		$simple_api_key = GOOGLE_API_KEY;
		$client = new Google_Client();
		$client->setApplicationName("Pega Prêmio Fini");
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		$client->setDeveloperKey($simple_api_key);
		$client->addScope("https://www.googleapis.com/auth/userinfo.email");
		return $client;
		
	}

	public static function setToken($token){
		$_SESSION['accessTokenGoogle'] = $token;
	}

	public static function getToken(){
		return isset($_SESSION['accessTokenGoogle']) ? $_SESSION['accessTokenGoogle']:null;
	}

	public static function getUrlLogin(){
		$client = self::getClientObject($callbackUrl="login");
		return  $client->createAuthUrl();
	}

	public static function getUrlCadastro(){
		$client = self::getClientObject($callbackUrl="cadastro");
		return  $client->createAuthUrl();
	}

	public static function logout(){
	  $client = self::getClientObject();
	  unset($_SESSION['accessTokenGoogle']);
	  if(isset($_SESSION['loginGoogle'])){
	  	unset($_SESSION['loginGoogle']);
	  }
	  $client->revokeToken();
	  return true;
	}

	public static function authenticate($client,$code){
		$client->authenticate($code);
		$accessToken = $client->getAccessToken();
		self::setToken($accessToken);
		return $client;
	}

	public static function setLogin($googleLogin){
		$_SESSION['loginGoogle'] = $googleLogin;
	}

	public static function getLogin(){
		return isset($_SESSION['loginGoogle']) ? $_SESSION['loginGoogle'] : false;
	}

	public static function fillForm($code=null){

		if(self::getToken()){
			self::logout();
			Redirect::withMessage(
									sprintf("%s%s",siteurl(),"cadastre-se"),
									[
										"text"   => "Token de acesso do Google expirou. Faça seu login novamente.",
										"status" => "danger",
										"class"  => ""
									]
		    );	
		}

		UsuarioModel::dropSessionLogin(true);


		// INICIAR O OBJETO GOOGLE CLIENT A PARTIR DAS CONSTANTES DO PROJETO
		$client = self::getClientObject($callbackUrl='cadastro');

		// AUTENTICAR USUARIO COM O PARAMETRO CODE OBTIDO NO CALLBACK DO LOGIN, CASO NAO TIVER TOKEN ATIVO.
		if($code){
		   $client = self::authenticate($client,$code); 
		}

		// SETTAR TOKEN NO OBJETO GOOGLE CLIENT
		if(self::getToken()){
		  $client->setAccessToken(self::getToken());
		}

		// VERIFICAR SE O TOKEN ESTA ATIVO NO OBJETO GOOGLE CLIENT
		if($client->getAccessToken()) {
		  
		  // ENVIA O OBJETO CLIENT COM O TOKEN PARA OBTER DADOS DO USUARIO POSTERIORMENTE
		  $objOAuthService = new Google_Service_Oauth2($client);		  

		  // ARMAZENAR OS DADOS DO USUARIO NA VARIAVEL
		  $userData = $objOAuthService->userinfo->get();
		  		  
		  // VERIFICAR SE A VARIAVEL DE USUARIO ESTA COM DADOS
		  if(!empty($userData)) {
			$usuarioGoogle = UsuarioModel::where('google_login',$userData->id); 
			if(!$usuarioGoogle) { 
				self::setLogin($userData->id);
				return Array(
							"nome"=>$userData->name,
							"sobrenome"=>$userData->family_name,
							"email" =>$userData->email,
							"google_login"=>$userData->id
							//,"data_nascimento"=>$userData->BirthDate
					   );
			}
			return Array("hasUser"=>true);
		  }

		  return false;
		}
		return false;
	}

	public static function login($code=null){

		// INICIAR O OBJETO GOOGLE CLIENT A PARTIR DAS CONSTANTES DO PROJETO
		$client = self::getClientObject($callbackUrl="login");

		// AUTENTICAR USUARIO COM O PARAMETRO CODE OBTIDO NO CALLBACK DO LOGIN, CASO NAO TIVER TOKEN ATIVO.
		if($code && !self::getToken()){
		   $client = self::authenticate($client,$code); 
		}

		// SETTAR TOKEN NO OBJETO GOOGLE CLIENT
		if(self::getToken()){
		  $client->setAccessToken(self::getToken());
		}

		// VERIFICAR SE O TOKEN ESTA ATIVO NO OBJETO GOOGLE CLIENT
		if($client->getAccessToken()) {
		  
		  // ENVIA O OBJETO CLIENT COM O TOKEN PARA OBTER DADOS DO USUARIO POSTERIORMENTE
		  $objOAuthService = new Google_Service_Oauth2($client);		  

		  // ARMAZENAR OS DADOS DO USUARIO NA VARIAVEL
		  $userData = $objOAuthService->userinfo->get();

		  // VERIFICAR SE A VARIAVEL DE USUARIO ESTA COM DADOS
		  if(isset($userData->id)) {
			$usuario = UsuarioModel::where('google_login',$userData->id);  // OBTER USUARIO ATRAVES DO ID DO GOOGLE
			if(is_array($usuario) && !empty($usuario)) {  // CASO ENCONTRE RETORNE O USUARIO
				return isset($usuario[0]) ? $usuario[0] : false;
			}
			return Array('hasNotUser'=>true);
		  }
		  return false;		  
		}
		return false;
	}


}
