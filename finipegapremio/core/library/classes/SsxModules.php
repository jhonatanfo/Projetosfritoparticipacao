<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

defined("SSX") or die;

class SsxModules
{
	/**
	 * Controlador de itens do smarty dentro do tema
	 * @var Smarty
	 */
	public $smarty;
	
	/**
	 * modulo a ser chamado pelo sistema
	 * @var string
	 */
	public $ssx_module;
	
	/**
	 * action a ser chamada logo a seguir pelo sistema
	 * @var string
	 */
	public $ssx_action;
	
	/**
	 * tema do projeto
	 * @var string
	 */
	public $ssx_theme;
	
	/**
	 * locatização de hierarquia de pastas do tema do projeto
	 * @var string
	 */
	public $ssx_theme_path;
	
	/**
	 * url do tema do projeto para a localização do site
	 * @var string
	 */
	public $ssx_theme_url;
	
	/**
	 * Usado para verificar se o modulo foi iniciado com sucesso
	 * @var boolean
	 */ 
	public $module_found = false;
	
	/**
	 * Usado para verificar se a action foi iniciada com sucesso
	 * @var boolean
	 */ 
	public $action_found = false;
	
	/**
	 * url do template que será usado pelo sistema para ser adicionado
	 * @var string
	 */ 
	public $ssx_modules_template;
	
	/**
	 * Define se em caso de 404 será direcionado a uma slug
	 * @var boolean
	 */
	private $ssx_use_slug_action = false;
	
	/**
	 * Noma da action que será usada para receber a slug
	 * @var string
	 */
	private $ssx_slug_action = "";
	
	/**
	 * define o .tpl que será exibido como principal
	 * @var string
	 */
	private $ssx_display;
	
	/**
	 * parametros de URL
	 * @var string
	 */
	private $params;
	
	/**
	 * define o conteudo padrao de configuracao que ira no header
	 * como css e afins
	 * 
	 * @var array
	 */ 
	private $ssx_head = array();

	/**
	 * define o conteudo padrao de configuracao que ira no header
	 * como js e afins
	 * 
	 * @var array
	 */ 
	private $ssx_footer = array();

	
	/**
	 * define meta tags que sero enviadas para o tema
	 * @var array
	 */
	private $ssx_head_meta = array();
	
	/**
	 *  controle de titulo do tema
	 * @var string
	 */
	private $__ssx_theme_title;
	
	/**
	 * Define que o header nao será exibido, caso haja uma condição no tema para isso
	 * @var boolean
	 */
	private $_disable_header = false;
	
	/**
	 * Define que o footer nao será exibido, caso haja uma condição no tema para isso
	 * @var boolean
	 */
	private $_disable_footer = false;

	public function __construct()
	{
		$this->get_params();
		
		require_once(RESOURCEPATH . "smarty/libs/Smarty.class.php");
		
		$this->smarty = new Smarty;    
		//Pasta padrão de templates
		$this->smarty->template_dir = "templates";
		//Pasta de templates compilados
		$this->smarty->compile_dir = COREPATH . "cache/templates_c";
		//Pasta de cache 
		$this->smarty->cache_dir = COREPATH . "cache";   
	      
		//Ativa uso de cache
		$this->smarty->cache_modified_check="true";
		//15 dias para manter o cache
		$this->smarty->cache_lifetime=60*60*24*15; // 15 dias
		
		// $this->smarty->error_reporting = 0;
		// $this->smarty->error_reporting = E_ALL & ~E_NOTICE;
		// $this->smarty->debugging = true;
				
		
		$this->startVisual();
	}
	
	/**
	 * Inicia todo o sistema de carregamento de modulos e visualização 
	 */
	public function startVisual()
	{
		if(defined('IS_AJAX'))
		   return;

		
		$_theme = constant('SSX_THEME');
		
		if(defined('IS_ADMIN') && IS_ADMIN)
		{
			// marca o tema para o admin com default
			// TODO: Deixar alteravel esse valor, sem precisar mexer na core	
			$_theme = "default";
			
			
		
		}
		
		$this->ssx_theme_path = LOCALPATH . "themes/".$_theme;
		$this->ssx_theme_url = siteurl() . "themes/".$_theme;
		$this->ssx_theme = $_theme;
		
		// pega o primeiro parametro da URL
		$module = $this->get_param(0);
		// var_dump($module);
		// die();
		$action = $this->get_param(1);		
		
		// obriga o modulo ter a primeira letra maiuscula
		$module = ucfirst($module);
		

		// Inicia o arquivo principal do modulo
		if((!file_exists(LOCALPATH . "modules/".$module."/".$module.".php") || empty($module)))
		   $module = "Home";

		
		// segunda verificação para ter certeza que o modulo Home existe
		if(!file_exists(LOCALPATH . "modules/".$module."/".$module.".php")) 
			die(SSX_ERROR_MODULES_01);

		$this->module_found	= true;
		
		$this->ssx_module = $module;	
		
		
		
		if($module == "Home" && strtolower($this->get_param(0)) != "home")
		   $action = $this->get_param(0);
		   
		if(empty($action)) $action = "index";
		
		if(file_exists(LOCALPATH . "modules/".$module."/".$action.".php")){
			$this->action_found = true;
		}else
			// var_dump(LOCALPATH . "modules/".$module."/".$action.".php");
			// die();
			$this->action_found = false;
			
		
		
		if($this->action_found)
		{
			$this->ssx_action = $action;
		}
		
		
		
		if(!file_exists($this->ssx_theme_path ."/". $this->ssx_theme . ".tpl"))
			die(SSX_ERROR_MODULES_02 . "<br />".$this->ssx_theme." : '".$this->ssx_theme.".tpl'");
		$this->ssx_display = $this->ssx_theme_path ."/". $this->ssx_theme . ".tpl";
		
		SsxActivity::dispatchActivity('ssx_start_visual');
		
		// project SEO
		SsxActivity::addListener(SsxActivity::SSX_THEME_CONFIG_LOADED,array($this,'project_seo'));
	}
	
	/**
	 * Marca uma action para exibir o erro 404
	 * @param string $this_module
	 */
	public function set_404_action($this_module=true)
	{
		if($this->is_404())
		{
			$module_call = "Home";
			if($this_module)
				$module_call = $this->ssx_module;
			else
				$this->ssx_module = $module_call;
				
			if(!file_exists(LOCALPATH . "modules/".$module_call."/templates/404.tpl"))
				die('SSX MODULES: Action 404 precisa existir');
			
			$this->ssx_action = "404";

		}
	}
	
	/**
	 * Marca que se caso não seja encontrado nenhuma action, redireciona para a action informada
	 * @param string $action
	 */
	public function set_slug_action($action)
	{
		$this->ssx_use_slug_action = true;
		$this->ssx_slug_action = $action;
	}
	
	public function get_slug_action()
	{
		if($this->ssx_use_slug_action)
			return $this->ssx_slug_action;
		return false;
	}
	
	public function disable_slug_action()
	{
		$this->ssx_use_slug_action = false;
		$this->ssx_slug_action = "";
	}
	
	/**
	 * Retorna se foi gerado o erro 404
	 */
	public function is_404()
	{
		if(!$this->action_found && !$this->ssx_use_slug_action)
		  return true;
		return false;
	}
	
	/**
	 * Habilita ou desabilita o header no tema
	 * @param boolean $visible
	 */
	public function showHeader($visible=true)
	{
		$this->_disable_header = ($visible)?false:true;
	}
	
	/**
	 * Habilita ou desabilita o footer no tema
	 * @param boolean $visible
	 */
	public function showFooter($visible=true)
	{
		$this->_disable_footer = ($visible)?false:true;
	}
	
	public function display()
	{
		$SsxAcl = new SsxAcl();
		
		// caso seja ajax ou que seja solicitado a não renderização dos templates
		if((defined('IS_AJAX') && IS_AJAX) || (defined('NO_RENDER') && NO_RENDER))
			return;

		$this->ssx_modules_template = LOCALPATH . "modules/".$this->ssx_module."/templates/".$this->ssx_action.".tpl";
		
		// acrescenta a chance de um modulo ou açao se tornar um WebService
		if(defined('IS_WEBSERVICE') && IS_WEBSERVICE)
		{
			if(file_exists($this->ssx_theme_path ."/". "webservice.xml"))
			{
				define_xml();
				$this->ssx_display = $this->ssx_theme_path ."/". "webservice.xml";
			}else
				die(SSX_ERROR_MODULES_04);
		}
		
		// acrescenta a chance de um modulo ou açao se tornar um WebService
		if(defined('IS_FEED') && IS_FEED)
		{
			if(file_exists($this->ssx_theme_path ."/". "feed.xml"))
			{
				define_feed();
				$this->ssx_display = $this->ssx_theme_path ."/". "feed.xml";
			}else
				die(SSX_ERROR_MODULES_05);
		}
		
		$acl = $SsxAcl->convertToViewAccess(SsxUsers::getPermission());
		
		// ssx_head
		$this->smarty->assign('ssx_head', $this->head_content());		
		$this->smarty->assign('ssx_footer', $this->footer_content());		
		// gatilho ssx_display
		SsxActivity::dispatchActivity(SsxActivity::SSX_DISPLAY);
		
		$ssx_display = $this->ssx_display;		
		
		$this->smarty->assign('ssxacl', $acl);
		
		$this->smarty->assign('ssx_encoding', SSX_ENCODING);

		$this->smarty->assign('ssx_content_path', $this->ssx_modules_template);
		
		$this->smarty->assign('siteurl', siteurl());
		
		$this->smarty->assign('projecturl', projecturl());
		
		$this->smarty->assign('coreurl', coreurl());
		
		$this->smarty->assign('serverurl', serverurl());
		
		$this->smarty->assign('theme_path', $this->ssx_theme_path);
		
		$this->smarty->assign('theme_url', $this->ssx_theme_url);
		
		$this->smarty->assign('image_url', siteurl() . "images/");
		
		$this->smarty->assign('this_module', strtolower($this->ssx_module));
		
		$this->smarty->assign('this_action', strtolower($this->ssx_action));
		
		$this->smarty->assign('ssx_theme_title', $this->__ssx_theme_title);
		
		$this->smarty->assign('ssx_disable_header', $this->_disable_header);
		
		$this->smarty->assign('ssx_disable_footer', $this->_disable_footer);	
		
		//$this->smarty->debugging = true;
		
		if($this->is_404())

			define_404();
			
		// show template
		$this->smarty->display($ssx_display);
		//die('123');
	}
	
    public function get_param($key)
	{
	  	  $params = $this->params;
	  	  if($params && is_array($params) && isset($params[$key]) && $params[$key])
	  	  	  return $params[$key];
	  	  return false;
	}
	
	private function get_params()
	{
		$has = false;
		$friendly_url = $_SERVER['REQUEST_URI'];
 		$friendly_url = preg_replace("/(\/[a-zA-Z0-9_]*\.php)/i", "", $friendly_url);
 		$friendly_url = preg_replace("/(\?.*)/i", "", $friendly_url);

 		
 		$localscript = $_SERVER['SCRIPT_NAME'];
 		$localscript = preg_replace("/(\/[a-zA-Z0-9_]*\.php)/i", "", $localscript);
 		
        $onlyothers = "";
        
 		if(strlen($localscript)>1){
 			$onlyothers = str_replace($localscript, "", $friendly_url);
 			if(count(explode($localscript, $friendly_url)) >= 3){
 				$has = true;
 			}
 		}else{
 			$onlyothers = $friendly_url;
 		}	
 		
 		if(substr($onlyothers,0,1) == "/")
 		{
 			$onlyothers = substr($onlyothers,1,strlen($onlyothers)-1);
 		}

 		$params = explode("/", $onlyothers);
 		
 		if($has){
 			$arr = explode("/", $friendly_url);
 			foreach($arr as $key => &$value){
 				if($value == ''){
 					unset($arr[$key]);
 				}
 			}
 			$arr= array_values($arr);
 			unset($arr[0]); 			
 			$arr = array_values($arr);
 			$params = $arr;
 		}

 		$this->params = $params;
	}
	
	/**
	 * Configura padrão de SEO para o projeto,
	 * Todos esses padrões podem ser substituídos
	 */
	public function project_seo()
	{
		 global $Ssx;
		 
		 if(the_platform() == "project")
		 {
			 // declare constantes e use funções de configurações aqui
			 $title 		= SsxConfig::get(SsxConfig::SSX_SEO_TITLE);
			 
			 $description 	= SsxConfig::get(SsxConfig::SSX_SEO_DESCRIPTION);
			 
			 $keywords 		= SsxConfig::get(SsxConfig::SSX_SEO_KEYWORDS);
			 
			 $Ssx->themes->set_theme_title(($title)?$title:"Ssx Framework", true);
			 
			 $Ssx->themes->add_head_meta(array('name'=>'description', 'content'=>$description));
			 
			 $Ssx->themes->add_head_meta(array('property'=>'og:description', 'content'=>$description));
			 
			 $Ssx->themes->add_head_meta(array('name'=>'keywords', 'content'=>$keywords));
		 
		 }
				
	}
	
	
	/*****************************
	 * Theme Utils
	 */
	
	public function add_head_content($content)
	{
		if(!is_string($content))
		   return;	
		array_unshift($this->ssx_head, $content."\n");
	}

	public function add_footer_content($content){
		if(!is_string($content))
		   return;	
		array_unshift($this->ssx_footer, $content."\n");	
	}
	
	public function add_head_meta($params)
	{
		if(!is_array($params))
		   return;	
		   
		array_unshift($this->ssx_head_meta, $params);
	}

	
	
	private function head_content()
	{
		
		SsxActivity::dispatchActivity(SsxActivity::SSX_HEAD);
		
		$theme_css = $this->ssx_theme_url . "/" . $this->ssx_theme . ".css";
		
		$jsParams = $this->jsParams();

		load_css($this->ssx_theme);

		if(is_file(LOCALPATH . "themes/default/bootstrap/bootstrap.css")){
			load_css('bootstrap/bootstrap.css');
		}
		$this->add_head_content('<script type="text/javascript" src="'.coreurl().'library/js/Ssx.js?v='.uniqid().'"></script>');
		$this->add_head_content('
								'.$jsParams.'
								');
		load_js('jquery-1.11.1.min.js');
		// dispara o gatilho de que o head do ssx estão sendo adicionadas a view agora
		
		$this->add_head_meta(array('http-equiv'=>'Pragma','content'=>'no-cache'));
		$this->add_head_meta(array('http-equiv'=>'Expires','content'=>'-1'));
		$this->add_head_meta(array('http-equiv'=>'Cache-control','content'=>'no-store'));
		$this->add_head_meta(array('http-equiv'=>'Content-Type','charset'=>constant('SSX_ENCODING'),'content'=>'text/html'));
		$this->add_head_meta(array('name'=>'generator','content'=>'Ssx '.constant('SSX_VERSION')));
		
		$head_string = "";
		
		if($this->ssx_head_meta)
		{
			foreach($this->ssx_head_meta as $row)
			{
				$head_string .= "<meta ";
				foreach($row as $key => $list)
				{
					$head_string .= $key."='".$list."' ";
				}
				$head_string .= " />\n";
			}
		}
		if($this->ssx_head)
		{
			foreach($this->ssx_head as $row)
			{
				$head_string .= (string)$row;
			}
		}
		return $head_string;

	}

	private function footer_content(){
		// $jsParams = $this->jsParams();
		// $this->add_head_content('<script type="text/javascript" src="'.coreurl().'library/js/Ssx.js"></script>');
		// $this->add_head_content('
		// 						'.$jsParams.'
		// 						');
		// load_js('jquery-1.11.1.min.js');
		$footer_string = '';
		if($this->ssx_footer)
		{
			foreach($this->ssx_footer as $row)
			{
				$footer_string .= (string)$row;
			}
		}
		return $footer_string;
	}
	
	private function jsParams()
	{
		$content = "\n<script type=\"text/javascript\">
						var _ssx_siteurl = \"".siteurl()."\";
						var _ssx_projecturl = \"".projecturl()."\";
						var _ssx_ajaxurl = \"".coreurl()."library/js/ajax.php\";			
					";
		if(defined('IS_ADMIN') && IS_ADMIN)
		{
			$content .= "var ad = true;\n";
		}else{
			$content .= "var ad = false;\n";
		}
	    $content .= "\n</script>";
	    return $content;
	}
	
	
	/**
	 * Define o titulo do projejo, sera enviado quando template for construido
	 * 
	 * @param string $title O titulo que sera colocado na pagina
	 * @param boolean $replace Se o titulo informado deve substituir o que ja existe
	 * @param boolean $before Se o titulo vai ficar antes ou depois do que ja tem
	 * @return void
	 */
	public function set_theme_title($title,$replace=false, $before=false)
	{
		if(!$title)
			return;
			
		if($replace)
		{
			$this->__ssx_theme_title = $title;
		}else{
			if($before)
			{
				$this->__ssx_theme_title = $title." ".$this->__ssx_theme_title;
			}else{
				$this->__ssx_theme_title = $this->__ssx_theme_title . " " . $title;
			}
		}
	}
	
	/**
	 * Util Smarty assign abreviation
	 * 
	 * @param $var_name nome da variavel
	 * @param $object valor da variavel a ser enviada ao tema
	 * @return void
	 */
	public function assign($var_name, $object)
	{
		if(!is_string($var_name))
			return;
		
		$this->smarty->assign($var_name, $object);
	}

	public function unset_head_meta($params){
		if(is_array($this->ssx_head_meta) && !empty($this->ssx_head_meta)){
			foreach($this->ssx_head_meta as $key => $value){
				if(isset($params['name']) && isset($value['name']) && $params['name'] == $value['name']){
					unset($this->ssx_head_meta[$key]);
					$to_return =true;
				}
			}
			return $to_return;
		}
		return;
	}
}