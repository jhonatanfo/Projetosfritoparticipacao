<?php

class REQUEST{
	
	public static function field($name){
		$field = (isset($_REQUEST[$name]) ? Sanitize::filter(array($_REQUEST[$name])) : '');
		$field = is_array($field) && isset($field[0]) ? $field[0] : '';
		return $field;
	}

	public static function all(){
		$request_fields = $_REQUEST;
		if(is_array($request_fields) && !empty($request_fields)){
			 $request_fields = Sanitize::filter($_REQUEST);
		}
		return $request_fields;
	}

	public static function unsetField($name){
		if(isset($_REQUEST[$name])){
			unset($_REQUEST[$name]);
			return true;						
		}
		return false;
	}

}