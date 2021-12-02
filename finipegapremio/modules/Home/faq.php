<?php

	load_js('faq.js');

	global $Ssx;
	$Ssx->themes->assign('produtos',ProdutoModel::all());

