<?php

class POST{

	public static function field($name){
		$field = (isset($_POST[$name]) ? Sanitize::filter(array($_POST[$name])) : '');
		$field = is_array($field) && isset($field[0]) ? $field[0] : '';
		return $field;
	}

	public static function all(){
		$post_fields = $_POST;
		if(is_array($post_fields) && !empty($post_fields)){
			 $post_fields = Sanitize::filter($_POST);
		}
		return $post_fields;
	}

	public static function unsetField($name){
		if(isset($_POST[$name])){
			unset($_POST[$name]);
			return true;
		}
		return false;
	}

}