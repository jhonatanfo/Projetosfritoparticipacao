<?php

class Redirect{

	public static function url($url){
		try{
			header("Location: ".$url);
			exit();	
	   }catch(Exception $ex){
			echo 'Problemas no redirecionamento: ',$e->getMessage(),"\n";
	   }			   
	}

	public static function withMessage($url,$msg){
	   try{
		   	if(!session_id()){
				session_start();
			}
	   		$_SESSION['flashMessage'] = $msg;
			header("Location: ".$url);
			exit();	
	   }catch(Exception $ex){
			echo 'Problemas no redirecionamento: ',$e->getMessage(),"\n";
	   }
	}

}