<?php
/**
 * Classe de controle e criação de sessão
 * Usa cookie e session para manter tudo organizado
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 */

defined("SSX") or die;

/**
 * 
 * @package Ssx
 * @subpackage SsxSession
 * @version 1.0
 * 
 */
class SsxSession
{
	/**
	 * Nome que sera dado a sessao
	 * @var string static
	 */
	public static $__session_name = "s1623_8_8321_0u13_ssx";
	
	/**
	 * Nome que sera dado a um cookie
	 * @var string static
	 */
	public static $__cookie_name = "ssx_sd175";
	
	/**
	 * Abre uma sessão no sistema
	 * 
	 * @param array $session_val Dados que serão armazenados na sessao, necessario ser array
	 * @param boolean $replace 
	 * @param string $session_name Nome da sessão, se não for informada, ira usar um nome padrão
	 * @param boolean $use_cookie_verification Usa um cookie com hash para prender a sessão em dois lugares
	 * @return void
	 */
	public static function openSession(array $session_val, $replace=false, $session_name="", $use_cookie_verification=true)
	{
		if(!session_id())
			session_start();
			
		if(!$session_name)
		{
			$session_name = SsxSession::$__session_name;
			$cookie_name = SsxSession::$__cookie_name;
		}else{
			$cookie_name = md5($session_name);
		}
		
		$hash = microtime() * 100000;
		
		$hash_session = md5($hash);
		
		if((!SsxSession::getSession($session_name)) || (SsxSession::getSession($session_name) && $replace))
		{
			SsxSession::dropSession($session_name);
			
			$_SESSION[$session_name]['value'] = $session_val;
			
			$_SESSION[$session_name]['check_cookie'] = $use_cookie_verification;
			
			$_SESSION[$session_name]['__hash'] = $hash_session;
				
			setcookie($cookie_name,$hash_session,0,"/");
			
			$_COOKIE[$cookie_name] = $hash_session;
			
		}
	}
	
	/**
	 * Verifica se existe uma sessão valida no sistema
	 * @return boolean
	 */
	public static function getSession($session_name="")
	{
		
		if(!$session_name)
		{
			
			$session_name = SsxSession::$__session_name;
			
			$cookie_name  = SsxSession::$__cookie_name;
			
		}else
		{
			$cookie_name = md5($session_name);
		}
		
		if(isset($_SESSION[$session_name]) && $_SESSION[$session_name])
		{
			if(isset($_SESSION[$session_name]['check_cookie']) && $_SESSION[$session_name]['check_cookie'])
			{
				if(isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name])
				{
					if($_SESSION[$session_name]['__hash'] == $_COOKIE[$cookie_name])
					{
						return $_SESSION[$session_name]['value'];
					}
				}
			}else{
				return $_SESSION[$session_name]['value'];
			}
		}
		return false;
	}
	
	/**
	 * Altera
	 * @param string $session_name
	 */
	public static function setSessionValue($session_name="")
	{
		if(!$session_name)
		{
			
			$session_name = SsxSession::$__session_name;
			
			$cookie_name  = SsxSession::$__cookie_name;
			
		}else
		{
			$cookie_name = md5($session_name);
		}
		
		
	}
	
	/**
	 * Derruba a sessao existe
	 * @return void
	 */
	public static function dropSession($session_name="")
	{
		if(!$session_name)
		{
			$session_name = SsxSession::$__session_name;
			
			$cookie_name = SsxSession::$__cookie_name;
			
		}else
		{
			$cookie_name = md5($session_name);
		}
		
		if(isset($_SESSION[$session_name]) && $_SESSION[$session_name])
		{
			unset($_SESSION[$session_name]);
		}
		
		if(isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name])
		{
			unset($_COOKIE[$cookie_name]);
		}
	}
}