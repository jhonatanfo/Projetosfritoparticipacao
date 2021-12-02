<?php
/**
 * 
 * @author jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */
  global $Ssx;
  
  $SsxUsers = new SsxUsers();
  $SsxUserToken = new SsxUserToken();
  
  // $Ssx->themes->showHeader(false);
  
  $Ssx->themes->set_theme_title('| Login', false);
  
  // $Ssx->plugins->load('Plugin_Menu')->disableMenu();
  
  $redirect = get_request('redirect', 'REQUEST');
  
  $Ssx->themes->assign('redirect', $redirect);
  
  $slug = $Ssx->themes->get_param(1);
  
  if($slug == "logout")
  {
  	 SsxUsers::logout();
  }


  if (!isset($_SERVER['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_PW'])) {
    header("WWW-Authenticate: Basic realm=\"Bem vindo ao sistema Ssx!\"");
    header("HTTP/1.0 401 Unauthorized");
    $msg ="<h1>Authorization Required</h1>";
    $msg.="<p>This server could not verify you are authorized to access the document<br>";
    $msg.="   request. Either you supplied the wrong credentials (e.g. bad password),or your<br>";
    $msg.="   browser doesn't understand how to supply the credentials required.";
    $msg.="</p>";
    print $msg;
    exit;
  } else if ($_SERVER['PHP_AUTH_USER'] == 'promo.fini.pegapremio' && $_SERVER['PHP_AUTH_PW'] == '1gCt7Mqak1FoJMBw') {
      
  } else {
    header("WWW-Authenticate: Basic realm=\"Please enter your username and password to proceed further\"");
    header("HTTP/1.0 401 Unauthorized");
    $msg ="<h1>Authorization Required</h1>";
    $msg.="<p>This server could not verify you are authorized to access the document<br>";
    $msg.="   request. Either you supplied the wrong credentials (e.g. bad password),or your<br>";
    $msg.="   browser doesn't understand how to supply the credentials required.";
    $msg.="</p>";
    print $msg;
    exit;
  }
  
  if(get_request('alter', 'GET'))
  {
  	  $Ssx->themes->assign('user_error', 'Senha alterada com sucesso. Faça seu login com sua senha nova.');
  }else if(get_request('esend', 'GET'))
  {
  	  $Ssx->themes->assign('user_error', 'Alteração de senha enviada. Verifique seu email para continuar');
  }
  
  /**
   *  Requisição de nova senha
   */
  if(get_request('l', 'GET'))
  {
  	  
  	
  	$user_id = get_request('m', 'REQUEST', 36);
  	$token = get_request('t', 'REQUEST', 36);
  	
  	$auth = $SsxUserToken->filterData(array('token'=>$token, 'user_id'=>$user_id, 'used'=>'0'), true);
  	if($auth)
  	{  		
      
      $Ssx->themes->assign('user_error', 'Digite sua nova senha');

  		$date_request = new DateTime($auth['date_created']);
  		$now_request = new DateTime(date("Y-m-d H:i:s"));
  		
  		$diff = $date_request->diff($now_request);
  		
  		if($diff->d == 0 && $diff->h < 2)
  		{
  			// altera a senha conforme solicitado
  			if(get_request('change_pass', 'POST'))
  			{
  				$new_pass = get_request('new_pass', 'POST');	
  				
  				$data_alter = array(
  					'id'=>$user_id,
  					'modified_by'=>$user_id,
  					'password'=>$new_pass,
  				);
  				
  				$SsxUsers->save($data_alter);
  				
  				$data_token = array(
  					'id'=>$auth['id'],
  					'used'=>'1'
  				);
  				
  				$SsxUserToken->save($data_token);
  				
  				header_redirect(get_url(the_module(),the_action(), array('alter'=>true)));
  			}
  			
  			$Ssx->themes->assign('password_request', true);
  			$Ssx->themes->assign('password_token', $auth['token']);
  			$Ssx->themes->assign('password_user', $auth['user_id']);
  		}else{
  			$Ssx->themes->assign('user_error', 'Requisição de alteração de senha já expirou.');
  		}
  	}else{
  		$Ssx->themes->assign('user_error', 'Requisição de alteração de senha inválida.');
  	}
  }
  
  /**
   * Login
   */
  if(get_request('login', "POST"))
  {
  	  $user = get_request('user', "POST");
  	  $pass = get_request('pass', "POST");  	    	  
  	  
  	  $auth = $SsxUsers->auth($user, $pass);
  	  if(!$auth)
  	  {
  	  	 $Ssx->themes->assign('user_error', 'Usu&aacute;rio ou senha inv&aacute;lidos');
  	  	
  	  }else{

  	  	if($redirect)
  	  	{
  	  		header_redirect(urldecode($redirect));
  	  	}else{
  	  		header_redirect(get_url('Home', 'index'));
  	  	}
  	  }
  }
  
  /**
   * Envia email de alteração de senha
   */
  if(get_request('forgot', 'POST'))
  {

  	  $email = get_request('forgot_email', 'POST');
  	  
  	  $recover = SsxUsers::recoverPass($email);
  	  if(!$recover)
  	  {
  	  		$Ssx->themes->assign('user_error', 'Email inválido.');
  	  }else{
  	  	    header_redirect(get_url(the_module(), the_action(), array('esend'=>true)));
  	  }
  }
  
