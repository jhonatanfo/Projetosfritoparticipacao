<?php
/**
 * Arquivo principal do modulo
 * Nao tem contato direto com o view, mas é possível enviar algo para lá,
 * Atravéz daqui
 * 
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

 global $Ssx;
 
 
 
 // 404 error só pode ser marcado pelo arquivo principal do modulo
 if($Ssx->themes->is_404())
 {
 	// marca a chamada do template 404.tpl
 	$Ssx->themes->set_404_action();
 	
 	$Ssx->themes->set_theme_title('| Page not found', false);
 	
 }else{

 	$Ssx->themes->set_theme_title('| Dashboard', false);
 } 

 
 