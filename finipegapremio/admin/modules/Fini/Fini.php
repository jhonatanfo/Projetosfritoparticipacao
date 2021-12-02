<?php

	global $Ssx;


	/*Mandar flashMessage*/
	if(isset($_SESSION['flashMessage'])){
		$Ssx->themes->assign('flashMessage',$_SESSION['flashMessage']);
		unset($_SESSION['flashMessage']);
	}