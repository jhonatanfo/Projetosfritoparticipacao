<?php

class DashboardModel{


	public static function graficoGenero($SsxGoogleChart){
		$dadosGeneros = UsuarioModel::getTotalByGender();
		if($dadosGeneros){
			$SsxGoogleChart->pieChart($dadosGeneros,$title='',$idContainer='graf_genero',$width="'100%'",$height="'250px'",true);
			return $SsxGoogleChart->draw();			
		}else{
			return "";
		}		
	}

	public static function graficoComSemNf($SsxGoogleChart){
		$dadosComSemNf = UsuarioModel::getTotalComSemNf();
		if($dadosComSemNf){
			$SsxGoogleChart->pieChart($dadosComSemNf,$title='',$idContainer='graf_com_sem_nf',$width="'100%'",$height="'250px'",true);
			return $SsxGoogleChart->draw();	
		}else{
			return "";
		}
	}

	public static function graficoIdade($SsxGoogleChart){
		$dadosIdades = UsuarioModel::getTotalByAge();
		if($dadosIdades){
			$SsxGoogleChart->pieChart($dadosIdades,$title='',$idContainer='graf_idade',$width="'100%'",$height="'250px'",true);
			return $SsxGoogleChart->draw();
		}else{
			return "";
		}
	}

	public static function graficoUsuario($SsxGoogleChart){
		$dadosUsuarios = UsuarioModel::getTotalByDate();
		if($dadosUsuarios){
			$SsxGoogleChart->areaChart($dadosUsuarios['datas'],$dadosUsuarios['totais'],$title='','',$idContainer='graf_usuario','',$width="100%",$height="'550px'");
			return $SsxGoogleChart->draw();
		}else{
			return "";
		}
	}

	public static function graficoEstado($SsxGoogleChart){
		$dadosEstados = UsuarioModel::getTotalByState();
		if($dadosEstados){
			$SsxGoogleChart->pieChart($dadosEstados,$title='',$idContainer='graf_estado',$width="'100%'",$height="'250px'",true);
			return $SsxGoogleChart->draw();
		}else{
			return "";
		}
	}

	public static function graficoNotaFiscal($SsxGoogleChart){
		$dadosNotas = NotaFiscalModel::getTotalNotasByDate();
		if($dadosNotas){
			$SsxGoogleChart->areaChart($dadosNotas['datas'],$dadosNotas['totais'],$title='','','graf_nota','',$width="100%",$height="'550px'");
			return $SsxGoogleChart->draw();
		}else{
			return "";
		}
	}

	public static function graficoAuditoria($SsxGoogleChart){
		$dadosAuditorias = ValeBrindeModel::getTotalValeBrindes();
		if($dadosAuditorias){
			$dadosAuditorias['Concedido'] = $dadosAuditorias['concedido'];
			unset($dadosAuditorias['concedido']);
			$dadosAuditorias['Não concedido'] = $dadosAuditorias['nao_concedido']; 
			unset($dadosAuditorias['nao_concedido']);
			$dadosAuditorias['Em avaliação'] = $dadosAuditorias['em_avaliacao'];
			unset($dadosAuditorias['em_avaliacao']);
			$SsxGoogleChart->pieChart($dadosAuditorias,$title='',$idContainer='graf_auditoria',$width="'100%'",$height="'250px'",true);
			return $SsxGoogleChart->draw();
		}else{
			return "";
		}
	}

	public static function graficoProdutos($SsxGoogleChart){
		$dadosProdutos = ProdutoNotaFiscalModel::getTopFiveProductsBestSeller();
		if($dadosProdutos){
			$SsxGoogleChart->barChart($dadosProdutos['nomes'],$dadosProdutos['totais'],'',$idContainer="graf_produtos","",$width="'100%'",$height="'550px'");
			return $SsxGoogleChart->draw();
		}else{
			return "";
		}
	}

	public static function graficoUsuariosNotas($SsxGoogleChart){
		$dadosUsuariosNotas = NotaFiscalModel::getTopFiveUsuariosComMaisNotas();
		if($dadosUsuariosNotas){
			$SsxGoogleChart->barChart($dadosUsuariosNotas['nomes'],$dadosUsuariosNotas['totais'],'',$idContainer="graf_usuariosnotas","",$width="'100%'",$height="'550px'");
			return $SsxGoogleChart->draw();
		}else{
			return "";
		}
	}

	public static function graficoCnpjs($SsxGoogleChart){
		$dadosUsuariosNotas = NotaFiscalModel::getTopFiveCnpjComMaisNotas();
		if($dadosUsuariosNotas){
			$SsxGoogleChart->barChart($dadosUsuariosNotas['cnpjs'],$dadosUsuariosNotas['totais'],'',$idContainer="graf_cnpjs","",$width="'100%'",$height="'550px'");
			return $SsxGoogleChart->draw();
		}else{
			return "";
		}
	}

	public static function totalUsuarios(){
		return UsuarioModel::count();
	}

	public static function mediaUsuarioPorDia(){
		return UsuarioModel::getMediaCadastrosPorDia();
	}

	public static function totalNotasFiscaisCadastradas(){
		return NotaFiscalModel::count();
	}

	public static function mediaNotasFiscaisPorDia(){
		return NotaFiscalModel::getMediaCadastrosPorDia();
	}


}
