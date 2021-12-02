<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

 // obrigatorio definir LOCALPATH como local de inicio de tudo
 define( 'LOCALPATH', dirname(__FILE__) . '/' );
 
 // define que se trata de um admin
 define('IS_ADMIN', true);
 
 include_once(LOCALPATH . "../core/core.php");
 
 global $Ssx;
 
 $Ssx->themes->display();
 