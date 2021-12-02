<?php
			
	global $Ssx;

	$SsxGoogleChart = new SsxGoogleChart();
	/*
		Foi necessario deixar como primeiro parametro uma estancia 
		do SsxGoogleChart, pq ele acrescenta um script no header da 
		página todo vez em que e faço uma nova instancia do objeto. 
	*/
		
	$Ssx->themes->assign('graf_genero', DashboardModel::graficoGenero($SsxGoogleChart));		

	$Ssx->themes->assign('graf_com_sem_nf',DashboardModel::graficoComSemNf($SsxGoogleChart));	

	$Ssx->themes->assign('graf_idade', DashboardModel::graficoIdade($SsxGoogleChart));	

	$Ssx->themes->assign('graf_usuario', DashboardModel::graficoUsuario($SsxGoogleChart));	

	$Ssx->themes->assign('graf_estado', DashboardModel::graficoEstado($SsxGoogleChart));		

	$Ssx->themes->assign('graf_nota', DashboardModel::graficoNotaFiscal($SsxGoogleChart));		

	$Ssx->themes->assign('graf_auditoria', DashboardModel::graficoAuditoria($SsxGoogleChart));		
	
	$Ssx->themes->assign('graf_produtos', DashboardModel::graficoProdutos($SsxGoogleChart));			

	$Ssx->themes->assign('graf_usuariosnotas', DashboardModel::graficoUsuariosNotas($SsxGoogleChart));		

	$Ssx->themes->assign('graf_cnpjs', DashboardModel::graficoCnpjs($SsxGoogleChart));

	$Ssx->themes->assign('total_usuarios',DashboardModel::totalUsuarios());

	$Ssx->themes->assign('media_usuarios_dia',DashboardModel::mediaUsuarioPorDia());

	$Ssx->themes->assign('total_notas_fiscais',DashboardModel::totalNotasFiscaisCadastradas());

	$Ssx->themes->assign('media_notas_fiscais_dia',DashboardModel::mediaNotasFiscaisPorDia());