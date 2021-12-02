<?php

class Csrf{

	public static function generateToken($suffix=""){
		if(!session_id()){
			session_start();
		}
	    if (empty($_SESSION['token'.$suffix])) {
		    if (function_exists('random_bytes')) {
		        $_SESSION['token'.$suffix] = bin2hex(random_bytes(32));
		    } else {
		        $_SESSION['token'.$suffix] = bin2hex(openssl_random_pseudo_bytes(32));
		    }
		}
		$token = $_SESSION['token'.$suffix];
		return $token;
	}
	
	public static function checkToken($token,$suffix=""){
		if(!session_id()){
			session_start();
		}
		$checkToken = false;
	    if (isset($_SESSION['token'.$suffix]) && hash_equals($_SESSION['token'.$suffix],$token)) {
	    	$checkToken = true;	        
	    }
	    self::clearToken($suffix);
	    return $checkToken;
	}

	public static function clearToken($suffix=""){
		if(!session_id()){
			session_start();
		}
		if(isset($_SESSION['token'.$suffix])){
			unset($_SESSION['token'.$suffix]);
		}
	}

}