<?php
/**
 *  Arquivo de configurações do Tema
 *  Caso esse arquivo não exista, o projeto continuará funcionando sem problemas
 *
 *  Esse arquivo será processado antes do modulo e action
 *  Se precisar declarar alguma constante, aqui
 *
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

 defined("SSX") or die;

 global $Ssx;

 // declare constantes e use funções de configurações aqui
 $Ssx->themes->set_theme_title('Promoção Pega Prêmio - FINI', true);
 
 load_js('jquery.mask.min.js');
 load_js('script.js');
 load_js('form.js');
 load_js('bootstrap.min.js');
 load_js('aos.js');
 load_js('jquery.overlayScrollbars.min.js');


 load_css('nuvens.css');
 load_css('OverlayScrollbars.css');