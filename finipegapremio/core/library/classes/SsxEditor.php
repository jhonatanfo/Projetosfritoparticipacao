<?php
/**
 * 
 * Usa o editor js tinymce como base para manipular o editor
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * @uses tinymce
 */

/**
 * 
 * Implementação simples
 * não há formas de customizar o tinymce ainda
 *
 */
class SsxEditor
{
	public $editor_uri;
	
	public $editor_url;

	public $type = "full";
	
	public $value;
	
	public function __construct()
	{
		$this->editor_uri = RESOURCEPATH . "tinymce/jscripts/tiny_mce/tiny_mce.js";

		$this->editor_url = coreurl() . "resources/tinymce/jscripts/tiny_mce/tiny_mce.js";

		if(!file_exists($this->editor_uri))
			die("SsxEditor: Editor tinymce não encontrado");
			
	}
	
	public function editor($content="")
	{
		$this->value = $content;
		
		SsxActivity::addListener(SsxActivity::SSX_HEAD, array($this, 'addDependences'));
	}
	
	public function setValue($content)
	{
		$this->value = $content;
	}
	
	private function typingEditor()
	{
		switch($this->type)
		{
			case "full":
			default:
				load_js("tiny_mce_full");
			break;
		}
	}
	
	public function drawEditor($fieldName="ssx_editor", $fieldValue="")
	{
		global $Ssx;
		
		$this->typingEditor();
		load_js($this->editor_url);
		
		return "<textarea width='900' height='450' name='".$fieldName."' id='ssx_editor'>".$fieldValue."</textarea>";
	}
	
	public function addDependences()
	{
		global $Ssx;
		
		$this->typingEditor();
		load_js($this->editor_url);
		
		$Ssx->themes->assign('ssx_editor', "<textarea width='900' height='450' name='ssx_editor' id='ssx_editor'>".$this->value."</textarea>");
	}
}
