<?php

/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */
 // obrigatorio definir LOCALPATH como local de inicio de tudo
 
 define( 'LOCALPATH', dirname(__FILE__) . '/' );
 
 define( 'ADMIN_EXISTS', true );
 
 include_once(LOCALPATH . "core/core.php");
	 
 global $Ssx;
 
 $Ssx->themes->display();
 
 // fecha conexão com banco
 $Ssx->shutDown();
