<?php
/**
 *  @author Andre Zapala <andre.zapala@gmail.com>
 *  @version 1.0.0
 */
defined("SSX") or die;

class SsxFormModel{
	
	public static function generateForm(array $rules, array $options){
		
		if(!is_array($rules))
			return false;
		
		$form = "<form " . SsxFormModel::generateOptions($options) . ">";
		
		foreach ($rules as $key => $value){
			switch ($value[1]){
				case 'hidden' 	: $form .= "<input type='hidden' name='".$value[0]."' value='' /><br />"; break;
				case 'textarea' : $form .= $value[0].": <textarea name='".$value[0]."'></textarea><br />"; break;
				case 'checkbox'	: $form .= $value[0].": <input type='checkbox' name='".$value[0]."' value='' /><br />"; break;
				default			: $form .= $value[0].": <input type='text' name='".$value[0]."' value='' /><br />"; break;
			}
		}
		
		$form .= "<input type='submit' name='saveValues' value='Submit' /></form>";
		
		return $form;
	}
	
	public function generateOptions(array $options){
		
		if(!is_array($options))
			return false;
		
		$stringOptions = "";
		
		foreach($options as $key => $value){
			$stringOptions .= $key . "='" . $options[$key] ."' ";
		}
		
		if(!isset($options['action']) && !$options['action'])
			$stringOptions .= ' action=""';		
		
		return $stringOptions;
	}
	
}