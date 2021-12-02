<?php
/**
 *
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */


 define('IS_AJAX', true);

 require_once('../../core.php');

 require_once(COREPATH.'Sanitize.php');
 // Filtra HTML e SQL Injection em todos os campos
 $_GET = Sanitize::filter($_GET,array('sql', 'html'));
 $_POST = Sanitize::filter($_POST,array('sql', 'html'));
 $_REQUEST = Sanitize::filter($_REQUEST,array('sql', 'html'));

 defined("SSX") or die;

 global $Ssx;

$functions_to_call  = get_request('function_call','POST');
$ajax_data 			= get_request('function_data', 'POST');
$function_to_return = get_request('function_callback', 'POST');

$output = (get_request('output', 'POST'))?get_request('output', 'POST'):"json";

if(!empty($ajax_data) && !is_array($ajax_data)){  $ajax_data = array($ajax_data);}

$SsxAjax = new SsxAjax($ajax_data, $functions_to_call,$function_to_return, $output);

$SsxAjax->returnCall();
