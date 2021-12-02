<?php
/**
 * Classe de contrução de forms para o admin usando um modelo padrão de construção por table
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * @copyright Ideia original Welson Tavares
 * 
 */

defined("SSX") or die;

class SsxEditConstruct
{
	private $args;
	
	private $fields;
	
	private $method = "post";
	
	private $action = "";
	
	private $editor = false;
	
	
	/**
	 * Objeto do plugin ckeditor
	 * @var SsxEditor
	 */
	private $editor_plugin;
	
	public function __construct($args)
	{
		if(!is_array($args))
			die(SSX_EDIT_CONSTRUCT_ERROR_00);
			
		$this->args = $args;
		$this->prepare();
	}
	
	private function prepare()
	{
		global $Ssx;
		
		if($this->args)
		{
			if(isset($this->args['fields']) && $this->args['fields'])
			{
				$kReserv = 1;
				foreach($this->args['fields'] as $fields)
				{
					if(isset($fields['field']) && $fields['field'])
					{
						$this->fields[$fields['field']] = array(
							'label'=>isset($fields['label']) && $fields['label']?$fields['label']:"Campo ".$kReserv.":",
							'link'=>isset($fields['link']) && $fields['link']?$fields['link']:"",
							'error'=>isset($fields['error']) && $fields['error']?$fields['error']:"Preencha o campo corretamente",
							'type'=>isset($fields['type']) && $fields['type']?$fields['type']:"text",
							'required'=>isset($fields['required']) && $fields['required']?$fields['required']:false,
							'compare'=>isset($fields['compare']) && $fields['compare']?$fields['compare']:false,
							'value'=>isset($fields['value']) && $fields['value']?$fields['value']:"",
							'classes'=>isset($fields['classes']) && $fields['classes']?$fields['classes']:"",
							'options'=>isset($fields['options']) && $fields['options']?$fields['options']:false
						);
						
						if($this->fields[$fields['field']]['type'] == "email")
						{
							$this->fields[$fields['field']]['email_error'] = isset($fields['email_error']) && $fields['email_error']?$fields['email_error']:"Email inv&aacute;lido";
						}
					}
					$kReserv++;
				}
			}
			
			if(isset($this->args['editor']) && $this->args['editor'])
			{
				$this->editor = true;
				$this->editor_plugin = new SsxEditor();
			} 
		}
	}
	
	public function save()
	{
		return get_request('saveValues', 'POST');
	}
	
	public function setFieldsValue($args)
	{
		if(!is_array($args) || !$this->fields)
			return;
			
		if($args)
		{
			foreach($args as $fieldKey => $fieldValue)
			{
				if(isset($this->fields[$fieldKey]) && $this->fields[$fieldKey])
				{
					$this->fields[$fieldKey]['value'] = $fieldValue;
				}
			}
		}
	}
	
	public function ocultFields($args)
	{
		if(!$this->fields)
			return;
			
		if($args)
		{
			foreach($args as $fieldKey)
			{
				if(isset($this->fields[$fieldKey]) && $this->fields[$fieldKey])
				{
					$this->fields[$fieldKey]['hidden'] = true;
				}
			}
		}
	}
	
	public function constructTable()
	{
		if(!is_array($this->fields))
			return false;
			
		$content = "<form autocomplete='off' class=\"form-horizontal col-md-3\" action='".$this->action."' method='".$this->method."' onsubmit='return validForm()' enctype=\"multipart/form-data\">\n";
		//$content .= "<table>\n";
		if($this->fields)
		{
			$hidden = "";
			foreach($this->fields as $fieldName => $fieldArgs)
			{
				if(isset($fieldArgs['hidden']) && $fieldArgs['hidden'])
					continue;
				
				if($fieldArgs['type'] != "hidden")
				{
					//$content .= "<tr>\n";
					if($fieldArgs['type'] != "label"){
						$content .= "<div class=\"form-group\">\n";
						$content .= "<label class=\"control-label\">".$fieldArgs['label']."</label>\n<div class=\"controls\">";
					}
					
					switch($fieldArgs['type'])
					{
						case "label":
							$content .= "<div class=\"form-group\">\n";
							$content .= "<h3>".$fieldArgs['label']."</h3>\n";
						break;
						case "file":
							$content .= "";
							if($fieldArgs['value'])
								$content .= "<img src='".$fieldArgs['value']."' width='210' /><br />";
							$content .= "<input type='file' class='form-control' name='".$fieldName."' id='field_".$fieldName."' /></div>\n";	
						break;
						case "password":
							$content .= "<input class='form-control' type='password' name='".$fieldName."' id='field_".$fieldName."' value='".$fieldArgs['value']."' /></div>\n";
						break;
						case "button":
							$content .= "<input class='form-control ".$fieldArgs['classes']."' type='button' name='".$fieldName."' id='field_'".$fieldName."' value='".$fieldArgs['value']."' /></div>";
						break;
						case "link":
							$content .="<a href='".$fieldArgs['link']."' class='form-control ".$fieldArgs['classes']."'>".$fieldArgs['value']."</a></div>";
						break;
						case "textarea":
							$content .= "<textarea class='form-control' cols='40' rows='5' name='".$fieldName."'>".$fieldArgs['value']."</textarea></div>";
						break;

						case "editor":
							if($this->editor)
							{
								//$content .= "</tr><tr><td colspan='3'>";
								$content .= $this->editor_plugin->drawEditor($fieldName,$fieldArgs['value']);
								//$content .= "</td>";
							}
						break;
						case "select":
							if(isset($fieldArgs['options']) && $fieldArgs['options'] && is_array($fieldArgs['options']))
							{
								$content .= "<select name='".$fieldName."' id='field_".$fieldName."' class='form-control'>";
								$content .= "<option value=''>-- Selecione</option>";
								foreach($fieldArgs['options'] as $selectValue => $selectLabel)
								{
									$content .= "<option value='".$selectValue."' ";
									if($selectValue == $fieldArgs['value'])
									{
										$content .= " selected='selected' ";
									}
									$content .= ">".$selectLabel."</option>";
								}
								$content .= "</select></div>";
							}
						break;
						case "check":
							if(isset($fieldArgs['options']) && $fieldArgs['options'] && is_array($fieldArgs['options']))
							{
								$content .= "";
								foreach($fieldArgs['options'] as $selectValue => $selectLabel)
								{
									$content .= " <input type='checkbox' value='".$selectValue."' name='".$fieldName."' ";
									if($selectValue == $fieldArgs['value'])
									{
										$content .= " checked='checked' ";
									}
									$content .= " /> ".$selectLabel." ";
								}
								$content .= "</div>";
							}
						break;
						case "text":
						case "email":
						default:
							$content .= "<input class='form-control' type='text' name='".$fieldName."' id='field_".$fieldName."' value='".$fieldArgs['value']."' /></div>\n";	
						break;
					}	
					if($fieldArgs['type'] != "ckeditor")
						$content .= "<span class='error_field' id='field_".$fieldName."_error'></span>\n";
						
					$content .= "</div>\n";
				}else{
					$hidden .= "<input type='hidden' name='".$fieldName."' value='".$fieldArgs['value']."' />";
				}
			}
		}
		
		$content .= "<div class=\"form-group\">\n
						  <div class=\"controls\">\n
						  	<button type='submit' class='btn btn-success form-control' name='saveValues' value='Salvar'/>
						  		<span class='glyphicon glyphicon-file'></span>
						  		Salvar
						  	</button>
						  ".$hidden."
						</div>
					</div>
		";
		
		$content .= "\n</form>";
		
		return $content;
	}
	
	public function getDataRequest()
	{
		if(!$this->fields)
			return false;
			
		$data = array();
		
		if($this->fields)
		{
			foreach($this->fields as $fieldKey => $fieldArgs)
			{
				if(isset($fieldArgs['hidden']) && $fieldArgs['hidden'])
					continue;
					
				switch($fieldArgs['type'])
				{
					case "text":
					case "hidden":
					case "password":
					case "textarea":
					case "email":
					case "editor":
					case "select":
						$varTmp = get_request($fieldKey, 'REQUEST');
						$varTmp = str_replace('\r', '', $varTmp);
						$varTmp = str_replace('\n', '', $varTmp);
						$data[$fieldKey] = emptyComplete($varTmp);
					break;	
					case "check":
						$varTmp = get_request($fieldKey, 'REQUEST');
						$data[$fieldKey] = $varTmp;
					case "file":
						if(isset($_FILES[$fieldKey]) && $_FILES[$fieldKey])
						{
							$data[$fieldKey] = $_FILES[$fieldKey];
						}
					break;
				}				
			}
		}
		return $data;
	}
	
	public function constructValidator()
	{
		if(!is_array($this->fields))
			return false;
			
		$content = "function validForm()
					{
						 var submit = 1;
					";
		if($this->fields)
		{
			foreach($this->fields as $fieldName => $fieldArgs)
			{
				if(isset($fieldArgs['hidden']) && $fieldArgs['hidden'])
					continue;
				
				if($fieldArgs['required'])
				{
					$content .= "\n
					if(Ssx.isEmpty($('#field_".$fieldName."').val()))
						{
							submit = 0;
							$('#field_".$fieldName."_error').html('".$fieldArgs['error']."');
						}";
					if($fieldArgs['type'] == "email")
					{
						$content .= "else if(!Ssx.isEmail($('#field_".$fieldName."').val()))
						{
							submit = 0;
							$('#field_".$fieldName."_error').html('".$fieldArgs['email_error']."');
						}";
					}else if($fieldArgs['compare'] && isset($this->fields[$fieldArgs['compare']]))
					{
						$content .= "else if(!Ssx.isEquals($('#field_".$fieldName."').val(), $('#field_".$fieldArgs['compare']."').val()))
						{
							submit = 0;
							$('#field_".$fieldName."_error').html('Campo ".strtolower($this->fields[$fieldArgs['compare']]['label'])." e ".strtolower($fieldArgs['label'])." precisam ser iguais');
						}";
					}
					$content .= "else{
							$('#field_".$fieldName."_error').html('');
						}";
				}
			}
		}
		
							
		$content .= "
						 if(submit)
						 	return true;
						 return false;
					}";
		return $content;
	}
}
