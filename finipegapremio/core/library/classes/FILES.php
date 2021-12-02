<?php

class FILES{

	public static function field($name){
		$field = false;
		if( isset($_FILES[$name]) && $_FILES[$name]['name'] != "" ){
			Sanitize::filter(array($_FILES[$name]['name']));
			$field = $_FILES[$name];		
		}
		return $field;
	}

	public static function all(){
		$files_fields = $_FILES;
		if(is_array($files_fields) && !empty($files_fields)){
			 foreach ($files_fields as $key => &$value) {
			 	$files_fields[$key] = false;
			 	if( isset($_FILES[$key]) && $_FILES[$key]['name'] != "" ){
			 		$files_fields[$key] = $_FILES[$key];
			 	}
			 }
		}
		return $files_fields;
	}

	public static function unsetField($name){
		if(isset($_FILES[$name])){
			unset($_FILES[$name]);
			return true;
		}
		return false;
	}

}
