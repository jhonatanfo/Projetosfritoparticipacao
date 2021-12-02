<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

defined("SSX") or die;

/**
 * Classe padrão para todos os elementos ajax que forem colocados em tela
 * As classes não precisam extender ela, mas para facilitar parte do trabalho
 * É necessário extende-la
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @since 1.3.3
 * @version 1.0
 *
 */
class SsxAjaxElement
{
	public $ssx;
	public $utils;
	
	private $inAdmin = false;
	
	public function __construct(){ $this->super(); }
	public function SsxAjaxElement(){ $this->super(); }
	
	public function super()
	{
		global $Ssx;
		
		$this->ssx = &$Ssx;
		$this->utils = &$Ssx->utils;
		
		$ad = get_request('ad', 'POST');
		if($ad && $ad != "false")
		{
			$this->inAdmin = true;
		}
	}
	
	/**
	 * Retorna o endereço do projeto, se for feito uma requisição dentro do admin o endereço será de lá
	 * 
	 * @return string Endereço do projeto
	 */
	public function siteurl($useAdmin=true)
	{
		$final = siteurl();
		
		$final = explode('/core/',$final );
		
		$final =  $final[0];
		
		if($this->inAdmin && $useAdmin)
		{
			$final = $final . "/admin";
		}
		$final = $final . "/";
			
		return $final;
	}
}