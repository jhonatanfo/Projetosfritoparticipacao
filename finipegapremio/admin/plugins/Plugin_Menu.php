<?php
/**
 * 
 * Plugin gerador do menu da area administrativa
 * Criar um menu, basta informar o id e o nome do menu na função addMenu
 * Para adicionar um sublink dentro do menu, basta usar a função addSubMenu e informar o id do menu o nome do submenu e o link
 * 
 * @copyright 2012 Entortament Entertainment
 *  
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */
load_js('functions.js');
load_js('bootstrap');

class Plugin_Menu
{
	protected $menus;
	
	protected $sublinks;

	protected $auth_menu;

	protected $current_url;
	
	public $enabled = true;
	
	public function __construct(){
		
		$this->menus = array();
		$this->sublinks = array();
		$this->current_url= siteurl();
		if(the_module() != 'home'){
			$this->current_url .= the_module();
		}
		if(the_action() != 'index'){
			$this->current_url .= '/'.the_action();	
		}

		// será chamado quando for enviado as variáveis para a view
		SsxActivity::addListener('ssx_display', array($this, 'draw'));
		SsxActivity::addListener('ssx_display', array($this, 'drawSidebarMenu'));
	}
	
	public function &addMenu($menu_id, $menu_name, $module_permission="Home", $url="")
	{
		if(!is_string($menu_id) || !is_string($menu_name))
			return $this;

		if(!SsxAcl::checkPermissionForModule($module_permission,the_platform()))	
			return $this;
			
		if($this->getMenuExists($menu_id))
			return $this;
			
		array_push($this->menus, 
					array(
							'id'=>"menu_" . $menu_id,
							'name'=>$menu_name,
							'url'=>$url
					));	
		return $this;
	}
	
	private function getMenuExists($menu_id)
	{
		if(!$menu_id)
			return false;
			
		if(is_array($this->menus))
		{
			foreach($this->menus as $menu)
			{
				if($menu['id'] == "menu_" . $menu_id)
					return true;
			}
		}
		return false;
	}

	private function getMenuById($menu_id)
	{
		if(!$menu_id)
			return false;
			
		if(is_array($this->menus))
		{
			foreach($this->menus as &$menu)
			{
				if($menu['id'] == "menu_" . $menu_id){
					return $menu;
					break;
				}	
			}
		}
		return false;
	}

	private function removeMenuExists($menu_id){
		if(!$menu_id){
			return false;
		}
		
		if(is_array($this->menus))
		{
			$i =0;
			foreach($this->menus as &$menu)
			{
				if($menu['id'] == "menu_" . $menu_id){					
					unset($this->menus[$i]);
					return true;
				}
				$i++;	
			}
		}
		return false;	
	}
	
	public function &addSubmenu($menu_id, $menu_name, $url, $module_permission="Home", $action_permission="index")
	{
		if(!is_string($menu_id) || !is_string($menu_name) || !is_string($url))
			return $this;
			
		if(!SsxAcl::checkPermissionForAction($module_permission,$action_permission, the_platform()))
			return $this;
			
		if(!$this->getMenuExists($menu_id))
			return $this;
			
		if(is_array($this->sublinks))
		{
			if($menu_name != "DIVIDER"){
				$this->sublinks["menu_".$menu_id][] = array(
															'name'=>$menu_name,
															'url'=>$url,
/*															'sub'=>$sub*/
														);
			}else{
				$this->sublinks["menu_".$menu_id][] = array('divider'=>true);
			}
		}
			
		return $this;
	}
	
	private function scriptToFuncionability()
	{
		ob_start();
		?>
			<script type="text/javascript">
				cssdropdown.startchrome("chromemenu"); 
		 	</script>
		<?php 
		$scriptToFunc = ob_get_clean();
		return $scriptToFunc;
	}
	
	public function draw()
	{
		global $Ssx;
		
		if(!$this->enabled)
			return;
		
		$contentPane = "";
		
		$this->auth_menu = $this->getMenuById('auth');
		$this->removeMenuExists('auth');

		$contentPane .= '<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">';
		$contentPane .= '	<div class="container-fluid">';
		$contentPane .='		<div class="navbar-header">';
		$contentPane .='		    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">';
		$contentPane .='		     <span class="sr-only">Toggle navigation</span>';
		$contentPane .='		     <span class="icon-bar"></span>';
		$contentPane .='		     <span class="icon-bar"></span>';
		$contentPane .='		     <span class="icon-bar"></span>';
		$contentPane .='		    </button>';
		$contentPane .= '			<a class="navbar-brand" href="'.siteurl().'">Ssx | Admin</a>';
		$contentPane .= '		</div>';

		if(count($this->menus))
		{
			$SsxUses = new SsxUsers();
			$id_user = SsxUsers::getUser();
			
			$name_user = $SsxUses->fill($id_user);
			$contentPane .= '		<div class="navbar-collapse collapse ">';
			$contentPane .= '			<ul class="nav navbar-nav hidden-sm hidden-md hidden-lg">';
			
			foreach($this->menus as $row)
			{
				$url = isset($row['url']) && $row['url']?$row['url']:"javascript:void(0);";
				$rel = "";
				if(isset($this->sublinks[$row['id']]) && $this->sublinks[$row['id']] && count($this->sublinks)>0)
				{
					$contentPane .= "\t\t\t\t<li class=\"dropdown\">\n";
					$contentPane .= "\t\t\t\t\t<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$row['name']."<b class=\"caret\"></b></a>\n";
					foreach($this->sublinks as $key => $list)
					{
						
						if($list && ($key == $row['id']))
						{

							$contentPane .= "\t\t\t\t\t<ul class=\"dropdown-menu\">\n";
							foreach($list as $subitems)
							{
								$subitems['divider'] = (isset($subitems['divider']) ? $subitems['divider'] : false);
								if(!$subitems['divider'])
									$contentPane .= "\t\t\t\t\t\t<li><a href=\"".$subitems['url']."\">".$subitems['name']."</a></li>\n";
								else
									$contentPane .= "<li class='divider'></li>";
								
							}
							$contentPane .= "\t\t\t\t\t</ul>\n\t\t\t\t</li>\n";
						}						
					}
					
				}else{
					$contentPane .= "\t\t\t\t<li><a ".$rel." href='".$url."' >".$row['name']."</a></li>\n";
				}
			}

			$contentPane .= "\t\t\t</ul>\n\t\t";
			$contentPane .=' <ul class="nav navbar-nav navbar-right">';
			$contentPane .=' 	<li class="dropdown">';
			$contentPane .='	<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
			$contentPane .='		<span class="glyphicon glyphicon-user"></span>';
			$contentPane .='		'.$name_user['name']."<b class='caret'></b>";
			$contentPane .='	</a>';
			$contentPane .=' 		<ul class="dropdown-menu">';
									foreach($this->sublinks[$this->auth_menu['id']] as $row){
										$row['url'] = (isset($row['url']) ? $row['url'] : '');
										$row['name'] = (isset($row['name']) ? $row['name'] : '');
			$contentPane .=' 			<li><a href="'.$row['url'].'">';
			$contentPane .=	'				'.$row['name'];
			$contentPane .=' 			</a></li>';
									}
			$contentPane .=' 		</ul>';
			$contentPane .=' 	</li>';
			$contentPane .=' </ul>';
			
		}else{
			$user_error = (isset($Ssx->themes->smarty->tpl_vars['user_error']->value) ? $Ssx->themes->smarty->tpl_vars['user_error']->value : false);
			if($user_error){
				$contentPane .='<div class="alert alert-warning alert-dismissible hidden-sm hidden-md hidden-lg" role="alert">';
				$contentPane .='  <button type="button" class="close" data-dismiss="alert" aria-label="Close">';
				$contentPane .='  	<span aria-hidden="true">&times;</span>';
				$contentPane .='  </button>';
				$contentPane .='  '.$user_error;
				$contentPane .='</div>';				
			}

			$menuAberto = get_request('l','REQUEST') ? "in" : ""; 
			$contentPane .='<div class="navbar-collapse collapse '.$menuAberto.' ">';

			if(get_request('l','REQUEST')){
				/* NOVA SENHA */
				$user_id = get_request('m', 'REQUEST', 36);
  				$token = get_request('t', 'REQUEST', 36);
				$SsxUserToken = new SsxUserToken();
				$auth = $SsxUserToken->filterData(array('token'=>$token, 'user_id'=>$user_id, 'used'=>'0'), true);
				$contentPane .='			<form action="'.siteurl().strtolower($Ssx->themes->ssx_module)."/".strtolower($Ssx->themes->ssx_action).'?l=1" method="post" onsubmit="return validaPass()" class="form form-new-password hidden-sm hidden-md hidden-lg">';
				/*HTML*/
				$contentPane .= '				<input type="hidden" name="m" value="'.$auth['user_id'].'" />';
				$contentPane .= '				<input type="hidden" name="t" value="'.$auth['token'].'" />';
				$contentPane .= '				<div class="form-group">';
				$contentPane .= '					<label>Nova Senha</label>';
				$contentPane .= '					<input type="password" name="new_pass" class="form-control" required>';
				$contentPane .= '				</div>';
				$contentPane .= '				<div class="form-group">';
				$contentPane .= '					<label>Confirma Senha</label>';
				$contentPane .= '					<input type="password" name="new_pass_confirm" class="form-control" required>';
				$contentPane .= '				</div>';
				$contentPane .= '				<div class="form-group">';
				$contentPane .= '					<button class="btn btn-success form-control" type="submit" name="change_pass" value="enviar"><i class="glyphicon glyphicon-ok"></i> Enviar</button>';
				$contentPane .= '				</div>';
				$contentPane .= '				<div class="form-group">';
				$contentPane .= '					<button class="btn btn-danger form-control" type="resert" name=""><i class="glyphicon glyphicon-trash"></i> Limpar</button>';
				$contentPane .= '				</div>';
				$contentPane .='			</form>';	
			}else{
				/* LOGIN*/
				/*HTML*/
				$contentPane .='	<form class="form form-login-m hidden-sm hidden-md hidden-lg" action="'.siteurl().strtolower($Ssx->themes->ssx_module).'/'.strtolower($Ssx->themes->ssx_action).'" method="post">';
				$contentPane .='		<div class="form-group">';
				$contentPane .='			<label class="">Usuário</label>';			
				$contentPane .='			<input type="text" name="user" class="form-control" required>';
				$contentPane .='		</div>';
				$contentPane .='		<div class="form-group">';
				$contentPane .='			<label class="">Senha</label>';			
				$contentPane .='			<input type="password" name="pass" class="form-control" required>';
				$contentPane .='		</div>';
				$contentPane .='		<div class="form-group">';
				$contentPane .='			<button type="button" class="btn btn-link link-color" onclick="openForgotPasswordM();">Esqueci minha senha?</button>';
				$contentPane .='		</div>';
				$contentPane .='		<div class="form-group">';
				$contentPane .='			<button type="submit" class="btn btn-success form-control" name="login" value="ok">';
				$contentPane .='				<span class="glyphicon glyphicon-log-in"></span> Logar';
				$contentPane .='			</button>';
				$contentPane .='		</div>';
				$contentPane .='		<div class="form-group">';
				$redirect = $Ssx->themes->smarty->tpl_vars['redirect']->value;
				$contentPane .='		<input type="hidden" name="redirect" value='.$redirect.'>';
				$contentPane .='			<button type="reset" class="btn btn-danger form-control"><span class="glyphicon glyphicon-trash"></span> Limpar</button>';
				$contentPane .='		</div>';
				$contentPane .='	</form>';


				/* ESQUECI MINHA SENHA */
				/*HTML*/
				$contentPane .='		<form action="'.siteurl().strtolower($Ssx->themes->ssx_module).'/'.strtolower($Ssx->themes->ssx_action).'" method="post" class=" form form-forgot-password-m">';
				$contentPane .='			<div class="form-group">';
				$contentPane .='				<label class="">Email</label>';
				$contentPane .='				<input type="text" name="forgot_email" class="form-control" required>';
				$contentPane .='			</div>';
				$contentPane .='			<div class="form-group">';
				$contentPane .='				<button class="btn btn-success"><i class="glyphicon glyphicon-send" type="submit" name="forgot" value="enviar"></i> Enviar</button>';
				$contentPane .='			</div>';
				$contentPane .='			<div class="form-group">';
				$contentPane .='				<a href="javascript:void(0);" class="link-color" onclick="openLoginM();"> Voltar</a>';
				$contentPane .='			</div>';
				$contentPane .='		</form>';
				/*SCRIPT*/
				$contentPane .='	<script type="text/javascript">';
				$contentPane .='		function openForgotPasswordM(){';
				$contentPane .='			$(".form-login-m").fadeOut("slow",function(){';
				$contentPane .='			 $(".form-forgot-password-m").css("display","block");';
				$contentPane .='			});';
				$contentPane .='		}';
				$contentPane .='		function openLoginM(){';
				$contentPane .='			$(".form-forgot-password-m").fadeOut("slow",function(){';
				$contentPane .='				$(".form-login-m").css("display","block")';
				$contentPane .='			});';
				$contentPane .='		}';
				$contentPane .='	</script>';		
			}					

		}

		$contentPane .="</div></div></div></nav>";
		
		$Ssx->themes->assign('plugin_menu', $contentPane);
	}

	/*
		Menu lateral para desktop
	*/
	public function drawSidebarMenu(){
		global $Ssx;
		
		if(!$this->enabled)
			return;
		
		$contentPane = "";
		
		$this->auth_menu = $this->getMenuById('auth');
		$this->removeMenuExists('auth');

		if(count($this->menus))
		{
			$SsxUses = new SsxUsers();
			$id_user = SsxUsers::getUser();
			$name_user = $SsxUses->fill($id_user);

			foreach($this->menus as $row)
			{
				// $open_menu = self::checkIfisOpenMenuBySublinks($this->sublinks[$row['id']]) || $row['url'] == $this->current_url ? 'open' : '';
				// $contentPane .= '<ul class="nav nav-sidebar '.$open_menu.'">';
				$contentPane .= '<ul class="nav nav-sidebar">';
				$url = isset($row['url']) && $row['url']?$row['url']:"javascript:void(0);";
				$rel = "";
				if(isset($this->sublinks[$row['id']]) && $this->sublinks[$row['id']] && count($this->sublinks)>0)
				{
					$contentPane .= '<li class="active">';
					$contentPane .= '<a href="#">'.$row['name'].' <b class="caret"></b></a>';
					// $contentPane .= '<a href="#">'.$row['name'].' <span class="glyphicon glyphicon-chevron-down drop-indicator"></span></a>';
					foreach($this->sublinks as $key => $list)
					{
						if($list && ($key == $row['id']))
						{
							foreach($list as $subitems)
							{
								$subitems['divider'] = (isset($subitems['divider']) ? $subitems['divider'] : false);
								if(!$subitems['divider']){
									// $active_menu = $subitems['url'] == $this->current_url ? 'sub_active' : '';
									// $contentPane .= "<li class='submenu ".$active_menu."'><a href='".$subitems['url']."'>".$subitems['name']."</a></li>";
									$contentPane .= "<li class='submenu'><a href='".$subitems['url']."'>".$subitems['name']."</a></li>";
								}else{
									$contentPane .= "<li class='divider submenu'></li>";
								}
								
							}
							$contentPane .= "</li>";
						}						
					}		
				}else{
					$contentPane .= "<li class='active'><a ".$rel." href='".$url."' >".$row['name']."</a></li>\n";
				}
				$contentPane .= "</ul>";
			}
			
		}else{
			/*
				Menu login na barra lateral
			*/
			$user_error = (isset($Ssx->themes->smarty->tpl_vars['user_error']->value) ? $Ssx->themes->smarty->tpl_vars['user_error']->value : false);
			if($user_error){
				$contentPane .='<div class="alert alert-warning alert-dismissible" role="alert">';
				$contentPane .='  <button type="button" class="close" data-dismiss="alert" aria-label="Close">';
				$contentPane .='  	<span aria-hidden="true">&times;</span>';
				$contentPane .='  </button>';
				$contentPane .='  '.$user_error;
				$contentPane .='</div>';				
			}	

			if(get_request('l','REQUEST')){
				/* NOVA SENHA */
				$user_id = get_request('m', 'REQUEST', 36);
  				$token = get_request('t', 'REQUEST', 36);
				$SsxUserToken = new SsxUserToken();
				$auth = $SsxUserToken->filterData(array('token'=>$token, 'user_id'=>$user_id, 'used'=>'0'), true);
				$contentPane .='			<form action="'.siteurl().strtolower($Ssx->themes->ssx_module)."/".strtolower($Ssx->themes->ssx_action).'?l=1" method="post" onsubmit="return validaPass()" class="form form-new-password">';
				/*HTML*/
				$contentPane .= '				<input type="hidden" name="m" value="'.$auth['user_id'].'" />';
				$contentPane .= '				<input type="hidden" name="t" value="'.$auth['token'].'" />';
				$contentPane .= '				<div class="form-group">';
				$contentPane .= '					<label>Nova Senha</label>';
				$contentPane .= '					<input type="password" name="new_pass" class="form-control" required>';
				$contentPane .= '				</div>';
				$contentPane .= '				<div class="form-group">';
				$contentPane .= '					<label>Confirma Senha</label>';
				$contentPane .= '					<input type="password" name="new_pass_confirm" class="form-control" required>';
				$contentPane .= '				</div>';
				$contentPane .= '				<div class="form-group">';
				$contentPane .= '					<button class="btn btn-success form-control" type="submit" name="change_pass" value="enviar"><i class="glyphicon glyphicon-ok"></i> Enviar</button>';
				$contentPane .= '				</div>';
				$contentPane .= '				<div class="form-group">';
				$contentPane .= '					<button class="btn btn-danger form-control" type="resert" name=""><i class="glyphicon glyphicon-trash"></i> Limpar</button>';
				$contentPane .= '				</div>';
				$contentPane .='			</form>';	

			}else{

				/*LOGIN*/		
				/*HTML*/
				$contentPane .='	<form class="form form-login" action="'.siteurl();
				$contentPane .=		strtolower($Ssx->themes->ssx_module).'/'.strtolower($Ssx->themes->ssx_action).'" method="post">';
				$contentPane .='		<div class="form-group">';
				$contentPane .='			<label class="">Usuário</label>';			
				$contentPane .='			<input type="text" name="user" class="form-control" required>';
				$contentPane .='		</div>';
				$contentPane .='		<div class="form-group">';
				$contentPane .='			<label class="">Senha</label>';			
				$contentPane .='			<input type="password" name="pass" class="form-control" required>';
				$contentPane .='		</div>';
				$contentPane .='		<div class="form-group">';
				$contentPane .='			<button type="submit" class="btn btn-success form-control" name="login" value="ok">';
				$contentPane .='				<span class="glyphicon glyphicon-log-in"></span> Logar';
				$contentPane .='			</button>';
				$contentPane .='		</div>';
				$contentPane .='		<div class="form-group">';
				$redirect = $Ssx->themes->smarty->tpl_vars['redirect']->value;
				$contentPane .='		<input type="hidden" name="redirect" value='.$redirect.'>';
				$contentPane .='			<button type="reset" class="btn btn-danger form-control"><span class="glyphicon glyphicon-trash"></span> Limpar</button>';
				$contentPane .='		</div>';
				$contentPane .='		<div class="form-group" style="padding:0px;">';
				$contentPane .='			<button type="button" class="btn btn-link link-color" onclick="openForgotPasswordD();">Esqueci minha senha?</button>';
				$contentPane .='		</div>';
				$contentPane .='	</form>';
				
				/* ESQUECI MINHA SENHA */
				/*HTML*/
				$contentPane .='		<form action="'.siteurl().strtolower($Ssx->themes->ssx_module).'/'.strtolower($Ssx->themes->ssx_action).'" method="post" class=" form form-forgot-password">';
				$contentPane .='			<div class="form-group">';
				$contentPane .='				<label class="">Email</label>';
				$contentPane .='				<input type="text" name="forgot_email" class="form-control" required>';
				$contentPane .='			</div>';
				$contentPane .='			<div class="form-group">';
				$contentPane .='				<button class="btn btn-success" type="submit" name="forgot" value="enviar"><i class="glyphicon glyphicon-send"></i> Enviar</button>';
				$contentPane .='			</div>';
				$contentPane .='			<div class="form-group">';
				$contentPane .='				<a href="javascript:void(0);" class="link-color" onclick="openLoginD();"> Voltar</a>';
				$contentPane .='			</div>';
				$contentPane .='		</form>';
				/*SCRIPT*/
				$contentPane .='	<script type="text/javascript">';
				$contentPane .='		function openForgotPasswordD(){';
				$contentPane .='			$(".form-login").fadeOut("slow",function(){';
				$contentPane .='				$(".form-forgot-password").css("display","block");';
				$contentPane .='			});';
				$contentPane .='		}';
				$contentPane .='		function openLoginD(){';
				$contentPane .='			$(".form-forgot-password").fadeOut("slow",function(){';
				$contentPane .='				$(".form-login").css("display","block")';
				$contentPane .='			});';
				$contentPane .='		}';
				$contentPane .='	</script>';
			}

		}
		$contentPane .='';
		$Ssx->themes->assign('plugin_menu_sidebar', $contentPane);
	}
	
	public function disableMenu()
	{
		global $Ssx;
		
		$Ssx->themes->assign('plugin_menu', "");	
		
		$this->enabled = false;
	}

	public function checkIfisOpenMenuBySublinks($sublinks=array()){
		if(is_array($sublinks) && !empty($sublinks)){
			foreach($sublinks as $link){
				if($this->current_url == $link['url']){
					return true;
				}
			}
			return false;
		}
		return false;
	}
}