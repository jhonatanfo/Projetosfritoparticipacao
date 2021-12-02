<?php
		
	global $Ssx;

	$Ssx->themes->assign('onRegulamento',true);
		
	if(strtolower($Ssx->themes->get_param(1)) == "download"){

		header("Content-type: application/pdf");
		header("Content-disposition: attachment; filename=regulamento.pdf");
		readfile(COREPATH."../files/regulamento.pdf");

	} 