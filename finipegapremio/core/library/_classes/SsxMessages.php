<?php
/**
 *  @author Andre Zapala <familia.zapala@gmail.com>
 *  @version 1.0.0
 */

defined("SSX") or die;

class SsxMessages
{
	
	public static function getMessage($tag){
		
		$_path_file = COREPATH . "config/messages.sh";
		$array_msg = array();
		
		
		$file = fopen($_path_file, 'r');
				
		if($file == false) die("Erro ao ler arquivo de mensagens.");
		
		while(!feof($file)){
			$linha = explode("=", fgets($file));
			$array_msg[trim($linha[0])] = trim($linha[1]);
		}
		
		fclose($file);
		
		if(array_key_exists($tag, $array_msg))
			return $array_msg[$tag];
		else 
			return false;
	}
}