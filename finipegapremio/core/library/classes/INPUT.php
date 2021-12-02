<?php

class INPUT{

	public static function field($name){
		$field = false;
		$fields = file_get_contents('php://input');
		if($fields){
			$fields = urldecode($fields);
			parse_str($fields, $_INPUT);
			$field = (isset($_INPUT[$name]) ? Sanitize::filter(array($_INPUT[$name])) : '');
			$field = is_array($field) && isset($field[0]) ? $field[0] : '';
		}		
		return $field;
	}

	public static function all(){
		$input_fields = file_get_contents('php://input');
		if($input_fields){
			$input_fields = urldecode($input_fields);
			parse_str($input_fields, $_INPUT);
			if(is_array($input_fields) && !empty($input_fields)){
				$input_fields = Sanitize::filter($_INPUT);
			}
			return $input_fields;
		}		
		return $input_fields;
	}
	
}
