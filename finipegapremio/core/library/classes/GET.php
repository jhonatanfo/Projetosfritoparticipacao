<?php

class GET{

	public static function field($name){
		$field = (isset($_GET[$name]) ? Sanitize::filter(array($_GET[$name])) : '');
		$field = is_array($field) && isset($field[0]) ? $field[0] : '';
		return $field;
	}

	public static function all(){
		$get_fields = $_GET;
		if(is_array($get_fields) && !empty($get_fields)){
			 $get_fields = Sanitize::filter($_GET);
		}
		return $get_fields;
	}

	public static function unsetField($name){
		if(isset($_GET[$name])){
			unset($_GET[$name]);
			return true;
		}
		return false;
	}
	
}