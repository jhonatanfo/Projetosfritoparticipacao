<?php

global $Ssx;

$clear = get_request("clear", "REQUEST");

if($clear){
	$msg_return = "";
	
	$result = clearCache();

	if($result)
		$msg_return = "msg_ok";
	else 
		$msg_return = "meg_error";
		
	header_redirect(get_url(the_module(),'index', array('report'=>$msg_return)));
}
	