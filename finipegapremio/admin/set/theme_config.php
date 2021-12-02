<?php
/**
 *
 * @author jasiel macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

  global $Ssx;



  $Ssx->themes->set_theme_title('Ssx - Área administrativa', true);


  $Ssx->plugins->load('Plugin_Menu')
  				->addMenu('users', 'Usuários', 'Ssxusers')
  					->addSubmenu('users', 'Usu&aacute;rios', get_url('ssxusers','index'), 'Ssxusers', 'index')
  					->addSubmenu('users', 'Adicionar usu&aacute;rio', get_url('ssxusers','edit'),  'Ssxusers', 'edit')
  					->addSubmenu('users', 'Usu&aacute;rios do site', get_url('usersdata','index'),  'Usersdata', 'index')
  				->addMenu('groups', 'Grupos de usuários', 'Ssxgroups')
  					->addSubmenu('groups', 'Grupos', get_url('ssxgroups','index'), 'Ssxgroups', 'index')
  					->addSubmenu('groups', 'Adicionar Grupo', get_url('ssxgroups','edit'), 'Ssxgroups', 'edit')
  					->addSubmenu('groups', 'Permissões', get_url('ssxacl','edit'), 'Ssxacl', 'edit')

          ->addMenu('fini', 'Fini', 'Fini')
            ->addSubmenu('fini', 'Dashboard', get_url('fini','index'), 'Fini', 'index')
            ->addSubmenu('fini', 'Cadastros de Usuários', get_url('fini','cadastros-de-usuarios'), 'Fini', 'cadastros-de-usuarios')
            ->addSubmenu('fini', 'Cadastros de Notas Fiscais', get_url('fini','cadastros-de-notas-fiscais'), 'Fini', 'cadastros-de-notas-fiscais')
	          ->addSubmenu('fini', 'Auditoria Vale Brinde',sprintf('%s/%s',get_url('fini','auditoria-vale-brinde'),'em_avaliacao'),'Fini','auditoria-vale-brinde')            

          ->addMenu('project', 'Projeto', 'Ssxproject',get_url('ssxproject', 'index'))

  				->addMenu('plugins', 'Plugins', 'Ssxplugins')
  					->addSubmenu('plugins', 'Plugins instalados', get_url('ssxplugins','index'), 'Ssxplugins', 'index')
  					->addSubmenu('plugins', 'Instalar plugin', get_url('ssxplugins','install'),  'Ssxplugins', 'install')

        	->addMenu('auth','Minha conta','Home')
  					->addSubmenu('auth', 'Alterar senha', get_url('auth','change_pass'), 'Auth', 'change_pass')
  					->addSubmenu('auth', 'Alterar Perfil', get_url('profile','index'), 'Profile', 'index')
  					->addSubmenu('auth', 'DIVIDER', get_url('auth','change_pass'), 'Auth', 'login')
  					->addSubmenu('auth', 'Sair', get_url('auth','logout'), 'Auth', 'login');

  	if($Ssx->utils->isMobile())
  	{
  		$Ssx->themes->assign('is_mobile', true);
  		$Ssx->themes->add_head_content('<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" >');
  	}
