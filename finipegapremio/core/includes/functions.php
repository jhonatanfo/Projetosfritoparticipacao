<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

 defined("SSX") or die;


/**
 * Retorna apenas o dominio na qual o projeto está hospedado, contando também com a PORTA
 * @return string
 */
function serverurl()
{
	$server = $_SERVER['SERVER_NAME'];
	$port = $_SERVER['SERVER_PORT'];

	$protocol = server_protocol();

	$siteurl = $protocol . $server;
	if($port != "80")
	{
		$siteurl .= ":".$port;
	}
	return $siteurl;
}

function server_protocol()
{
	/*
		CASO FOR SUBIR PARA O SERVIDOR LEMBRAR DE INVERTER A VARIAVEL $protocol.
		Comenta http e descomenta https
	*/
	// $protocol = "https://";
	$protocol = "http://";
	if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' || $_SERVER['SERVER_PORT'] == 443 ||(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) {
		$protocol = "https://";
	}
	return $protocol;
}

/**
 * Retorna o endereço do site completo, se ele estiver dentro de alguma subpasta ou não
 * @return string
 */
function siteurl()
{
	$siteurl = serverurl();

	$folder = $_SERVER['SCRIPT_NAME'];

	$pattern = "/([a-zA-Z0-9]*\.php)/";

	$replacement = explode("?",$folder);

	$subject = reset($replacement);

	$folder = preg_replace($pattern, "", $subject);

	return $siteurl . $folder;

}

/**
 *  Retorna a url absoluta do projeto desconsiderando o admin
 *  @return string
 */
function projecturl()
{
	$siteurl = coreurl();
	$siteurl = str_replace("/core/","/", $siteurl);
	return $siteurl;
}

/**
 * Retorna a url absoluta até o tema
 * @return string|string
 */
function themeurl()
{
	global $Ssx;

	$siteurl = siteurl();

	if(!defined("SSX_THEME"))
		return $siteurl;

	$siteurl .= "themes/" .  $Ssx->themes->ssx_theme . "/";

	return $siteurl;
}

/**
 *  Retorna a url absoluta da core
 *  @return string
 */
function coreurl()
{
	$siteurl = siteurl();

	$siteurl = str_replace("http://","",$siteurl);
	$siteurl = str_replace("https://","",$siteurl);

	if(substr($siteurl,strlen($siteurl)-1,1) == "/")
		$siteurl = substr($siteurl,0,strlen($siteurl)-1);

	if(defined('IS_ADMIN') && IS_ADMIN)
	{
		$site_params = explode("/", $siteurl);
		if(count($site_params)>1)
			$siteurl = substr($siteurl,0,strlen($siteurl)-strlen(end($site_params)));
	}

	if(substr($siteurl,strlen($siteurl)-1,1) == "/")
		$siteurl = substr($siteurl,0,strlen($siteurl)-1);

	$protocol = server_protocol();

	$siteurl = $protocol . $siteurl . "/core/";
	return $siteurl;
}

/**
 * Retorna uma requisição _GET ou _POST ou _REQUEST caso ela exista
 *
 * @param $request_name nome do sta
 * @param $check_injection se true, passa o elemento por uma verificação de sql injection
 * @return mixed
 */
function get_request($request_name,$type="GET",$limit=null)
{
	global $Ssx;

	$return = "";

	if($type=="POST")
	{
		if(isset($_POST[$request_name]) && $_POST[$request_name])
		{
			$return = $Ssx->utils->secureSuperGlobalPOST($request_name);
		}
	}else if($type=="REQUEST")
	{
		if(isset($_REQUEST[$request_name]) && $_REQUEST[$request_name])
		{
			$return = $Ssx->utils->secureSuperGlobalREQUEST($request_name);
		}
	}else{
		if(isset($_GET[$request_name]) && $_GET[$request_name])
		{
			$return =  $Ssx->utils->secureSuperGlobalGET($request_name);
		}
	}

	if($return)
	{
		if($limit && is_int($limit))
		{
			$return = substr($return,0,$limit);
		}
		return $return;
	}

	return false;
}



/**
 * Marca no cabeçalho content-type XML
 * @return void
 */
function define_xml()
{
  	header("content-type: text/xml");
  	return;
}

function define_feed()
{
	header("Content-Type: application/rss+xml; charset=".SSX_ENCODING);
	return;
}

function define_json()
{
	header("Content-type: application/json");
	return;
}

/**
 * Marca no cabeçalho o status 404
 * @return void
 */
function define_404()
{
	$protocol = $_SERVER["SERVER_PROTOCOL"];

	if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol )
		$protocol = 'HTTP/1.0';

	$status_header = "$protocol 404 Not Found";
	return header($status_header);
}
/**
 * Monta a url de um modulo e ação
 *
 * @param $module string
 * @param $action string
 * @param $params Array|string
 * @return string Url absoluta ate o modulo
 */
function get_url($module="Home", $action="index", $params="", $admin=false)
{
	$siteurl = siteurl();

	if($admin)
	{
		$siteurl .= "admin/";
	}

	$m = strtolower($module);
	$a = strtolower($action);

	$p = "";
	if($params)
	{
		if(is_array($params))
			$params = http_build_query($params);
		$p = "?" . $params;
	}

	if($m == "home" && $action == "index")
		return $siteurl  . $p;

	if($m == "home")
	{
		return $siteurl . $action . $p;
	}else{
		if($a == "index")
			return $siteurl . $m  . $p;
		else
			return $siteurl . $m . "/" . $a  . $p;
	}


	return $siteurl . $p;
}

/**
 * Redireciona via header
 * @return void
 */
function header_redirect($url)
{
	if(!$url)
		return;

	header("location: ".$url);
	exit;
}

function redirect($url, $inIframe=false)
{
	if($inIframe)
		print "<script type='text/javascript'> top.location.href = '".$url."';</script>";
	else
		print "<script type='text/javascript'> window.location.href = '".$url."';</script>";
	exit;
}

/******************* Utils do modulo **********************/

/**
 * Retorna o modulo que esta sendo carregado
 *
 * @return string
 */
function the_module()
{
	global $Ssx;

	$return = $Ssx->themes->ssx_module;

	if($return)
		return strtolower($return);
	return false;
}

/**
 * Retorna a acao que sera exibida
 *
 * @return string
 */
function the_action()
{
	global $Ssx;

	$return = $Ssx->themes->ssx_action;

	if($return)
		return strtolower($return);
	return false;
}

/**
 *
 * Retorna a plataforma a qual o usuário está acessando
 * return @string
 */
function the_platform()
{
	if(defined('IS_ADMIN') && IS_ADMIN)
		return "admin";
	return "project";
}


/**
 * Envia para a view variaveis
 *
 * @param $var_name nome da variavel a ser enviada para o tema
 * @param $value valor da variavel a ser enviada para o tema
 * @return void
 */
function theme_view_assign($var_name, $value)
{
	global $Ssx;

	$Ssx->themes->assign($var_name, $value);

	return;
}

/**
* Retorna string vazia se a variavel indicada não tiver um valor valido
* @param $var string
* @param $opcional_value caso seja indicada, o valor a ser retornado caso não encontre, será o dessa variável
* @return mixed
*/
function emptyComplete($var,$opcional_value="")
{
	global $Ssx;

	return $Ssx->utils->emptyComplete($var,$opcional_value);
}

/**
 * Mostra no HTML junto com a tag <pre> o conteúdo que ha dentro do elemento informado
 *
 * @param mixed $obj
 * @param boolean $die
 * return void
 */
function debug($obj, $die=false)
{
	global $Ssx;

	$Ssx->utils->debug($obj,$die);

	return;
}


function load_js($js_name, $autocomplete=true,$attr=null)
{
	global $Ssx;

	$str_attr = '';
	if($attr){
		foreach ($attr as $key => &$value) {
			$str_attr .= " ".$key.'="'.$value.'" ';
		}
	}

	if(!is_string($js_name))
		return;
	if($autocomplete)
		$js_name .= substr($js_name,strlen($js_name)-3,3) != ".js"?".js":"";

	$path = COREPATH . "library/js/" . $js_name;
	if(!preg_match('/((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s"]*))/is',$js_name ))
	{
		if(file_exists(LOCALPATH . "themes/" . $Ssx->themes->ssx_theme . "/js/" . $js_name))
		{
			$js_name .= "?v=" . md5(date('Y-m-d H:i:s'));
			$Ssx->themes->add_head_content("<script type='text/javascript' src='".themeurl()."js/".$js_name."' ".$str_attr."></script>");
		}else if(file_exists(COREPATH . "library/js/" . $js_name))
		{
			$js_name .= "?v=" . md5(date('Y-m-d H:i:s'));
			$Ssx->themes->add_head_content("<script type='text/javascript' src='".coreurl()."library/js/".$js_name."' ".$str_attr."></script>");	
		}
	}else{
		$Ssx->themes->add_head_content("<script type='text/javascript' src='".$js_name."' ".$str_attr."></script>");
	}
	return;
}

/**
 *
 * @param string $css_name
 */
function load_css($css_name,$attr=null)
{
	global $Ssx;

	if(!is_string($css_name))
		return;

	$css_name .= substr($css_name,strlen($css_name)-4,4) != ".css"?".css":"";
	$str_attr = '';
	if($attr){
		foreach ($attr as $key => &$value) {
			if($value != ''){
				$str_attr .= " ".$key.'="'.$value.'" ';
			}
		}
	}

	if(file_exists(LOCALPATH . "themes/" . $Ssx->themes->ssx_theme . "/" . $css_name))
	{
		$css_name .= "?v=" . md5(date('Y-m-d H:i:s'));
		$Ssx->themes->add_head_content("<link rel=\"stylesheet\" href=\"".themeurl().$css_name."\" type=\"text/css\"  ".$str_attr."/>");
	}else{
		$Ssx->themes->add_head_content("<link rel=\"stylesheet\" href=\"".$css_name."\" type=\"text/css\"  ".$str_attr."/>");
	}
	return;
}


function find_file($folder, $file_name)
{
	if(!is_dir($folder))
		return false;

	$handle = scandir($folder);
	if(!$handle)
		return false;

	unset($handle[0]);
	unset($handle[1]);

	if(count($handle)<1)
		return false;

	foreach($handle as $row)
	{
		if(is_dir($folder . $row))
			return find_file($folder . "/" .$row, $file_name);
		else
		{
			if($row == $file_name)
				return $folder . "/" .$row;
		}
	}
	return false;
}


function calc_date_distance($date_db)
{
	if(!is_string($date_db))
		return "";

	$dateParams = explode(" ", $date_db);
	$date = explode("-", $dateParams[0]);
	$hour = explode(":", $dateParams[1]);

 	$mkdata_question = mktime($hour[0], $hour[1], $hour[2], $date[1], $date[2], $date[0]);
    $mkdata_atual = mktime();


    $hour_mileseconds = (60 * 60);
    $day_mileseconds = (60 * 60) * 24;
    $week_mileseconds = $day_mileseconds * 7;

    $mileCalc =  $mkdata_atual - $mkdata_question;
    $mileCalc = Math::Abs($mileCalc);

    $message = "";
    if($mileCalc <= $hour_mileseconds)
    {
    	if($mileCalc < 60)
    	{
    		$message = "Há alguns segundos atrás";
    	}else{
    		$minutes = ceil($mileCalc / 60);
    		$message = "Há ".$minutes." minuto".(($minutes>1)?"s":"")." atrás";
    	}
    }else if($mileCalc > $hour_mileseconds && $mileCalc <= $day_mileseconds)
    {
    	$hours = ceil($mileCalc / 60 / 60);
    	$message = "Há ".$hours." hora".(($hours>1)?"s":"")." atrás";
    }else if($mileCalc > $day_mileseconds && $mileCalc <= $week_mileseconds)
    {
    	$days = ceil((($mileCalc / 60) / 60) / 24);
    	$message = "Há ".$days." dia".(($days>1)?"s":"")." atrás";
    }else{
    	$message = (strlen($date[2])<2)?"0".$date[2]:$date[2] . "/" . $date[1] . "/" . $date[0] ." ".$hour[0].":".$hour[1];
    }

    return $message;
}


function is_location($module="home", $action="index")
{
	if(siteurl() . the_module() . "/" . the_action() == siteurl() . $module . "/" . $action)
		return true;
	return false;
}

function is_real_location($module="home")
{
	global $Ssx;
}

/**
 * Gera uma senha aleatória de acordo com o tamanho informado
 * @param int $length
 * @return string
 */
function generate_pass($length=6)
{
	if($length<0)
		return false;

	$alphabeto = "abcdefghi1j2k3l4m5n6o7p8q9rstuvwxyzABC2D3E4F5G6HIJKLMNOPQRSTUVWXYZ1234567890";
	$new_pass = "";

	for($i = 0; $i < $length; $i++)
	{
		$rand = rand(0,strlen($alphabeto)-1);
		$pos = substr($alphabeto,$rand,1);
		$new_pass .= $pos;
	}
	return $new_pass;
}
/**
 *
 */

function makedir($absolute_path)
{
	if(PHP_OS == "Linux")
    {
    	mkdir($absolute_path, 0777, true);
    	chmod($absolute_path, 0777);
    }
}


/**
 * SsxModels
 */

function ssx_get_table_logs($result)
{
	if(!$result)
		return $result;

	global $Ssx;

	$SsxUsers = new SsxUsers();

	if(isset($result[0]) && is_array($result[0]))
	{
		foreach($result as $key => $row)
		{
			if(isset($row['created_by']))
			{
				$creator = $SsxUsers->fill($row['created_by']);
				$result[$key]['created_by'] = $creator['name'];
			}

			if(isset($row['modified_by']))
			{
				$creator = $SsxUsers->fill($row['modified_by']);
				$result[$key]['modified_by'] = $creator['name'];
			}

			if(isset($row['date_created']))
			{
				$result[$key]['date_created'] = $Ssx->utils->formatDate($row['date_created'],'d/m/Y H:i:s');
			}

			if(isset($row['date_modified']))
			{
				$result[$key]['date_modified'] = $Ssx->utils->formatDate($row['date_modified'],'d/m/Y H:i:s');
			}
		}
	}else{
			if(isset($result['created_by']))
			{
				$creator = $SsxUsers->fill($result['created_by']);
				$result['created_by'] = $creator['name'];
			}

			if(isset($result['modified_by']))
			{
				$creator = $SsxUsers->fill($result['modified_by']);
				$result['modified_by'] = $creator['name'];
			}

			if(isset($result['date_created']))
			{
				$result['date_created'] = $Ssx->utils->formatDate($result['date_created'],'d/m/Y H:i:s');
			}

			if(isset($result['date_modified']))
			{
				$result['date_modified'] = $Ssx->utils->formatDate($result['date_modified'],'d/m/Y H:i:s');
			}
	}

	return $result;
}

function getPages(){
	$dir_url = "../modules/";
	if(!file_exists($dir_url))
		return false;

	$modules_data = array();

	$dir = scandir($dir_url);

	if($dir)
	{
		foreach($dir as $row)
		{
			if($row == ".." || $row == ".")
				continue;

			if(is_dir($dir_url . $row))
			{
				if(file_exists($dir_url . $row . "/" . $row . ".php" ))
				{
					$mod_aval = scandir($dir_url . $row);

					if($mod_aval)
					{
						foreach($mod_aval as $list)
						{
							if($list == ".." || $list == "." || $list == $row . ".php" )
								continue;

							$action = str_replace(".php", "", $list);

							if(!is_dir($dir_url . $row . "/" . $action) && file_exists($dir_url . $row . "/templates/" . $action . ".tpl"))
							{
								$modules_data['modules'][$row]['actions'][] = $action;
							}
						}
					}
				}
			}
		}
		return $modules_data;
	}
}

function clearCache(){
	$_path = COREPATH . "cache/templates_c";

	$arrFiles = array();

	$dir = scandir($_path);

	$error = 0;

	if($dir)
	{
		foreach($dir as $row)
		{
			if($row == ".." || $row == ".")
				continue;

			if(!unlink($_path . "/" . $row))
				$error++;
		}
	}

	if($error == 0)
		return true;
	else
		return false;
}
function create_guid(){
	//Cria uma nova chave para ser gravada no banco de dados
    $microTime = microtime();
    list($a_dec, $a_sec) = explode(" ", $microTime);

    $dec_hex = sprintf("%x", $a_dec* 1000000);
    $sec_hex = sprintf("%x", $a_sec);

    ensure_length($dec_hex, 5);
    ensure_length($sec_hex, 6);

    $guid = "";
    $guid .= $dec_hex;
    $guid .= create_guid_section(3);
    $guid .= '-';
    $guid .= create_guid_section(4);
    $guid .= '-';
    $guid .= create_guid_section(4);
    $guid .= '-';
    $guid .= create_guid_section(4);
    $guid .= '-';
    $guid .= $sec_hex;
    $guid .= create_guid_section(6);

    return $guid;
}

function create_guid_section($characters){
	$return = "";
    for($i=0; $i<$characters; $i++)
      $return .= sprintf("%x", mt_rand(0,15));
    return $return;
}

function ensure_length(&$string, $length){
	$strlen = strlen($string);
    if($strlen < $length)
          $string = str_pad($string,$length,"0");
    else if($strlen > $length)
          $string = substr($string, 0, $length);
}

function str_lreplace($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);

    if($pos !== false)
    {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
}

function validaCpf($cpf){	
	// Verifica se o número digitado contém todos os digitos
	$cpf = str_pad(preg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
	// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
	if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
	{
		return false;
	}
	else
	{   // Calcula os números para verificar se o CPF é verdadeiro
    	for ($t = 9; $t < 11; $t++) {
        	for ($d = 0, $c = 0; $c < $t; $c++) {
           		$d += $cpf{$c} * (($t + 1) - $c);
        	}
        	$d = ((10 * $d) % 11) % 10;
	            if ($cpf{$c} != $d){
            	return false;
 
        	}
    	}
    	return true;
	}
}

function validaEmail($email){
	return filter_var($email, FILTER_VALIDATE_EMAIL);	
}


function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y' ) {

    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);
    while( $current <= $last ) {

        $dates[] = date($output_format, $current);
        $current = strtotime($step, $current);
    }

    return $dates;
}


function validaCnpj($cnpj = null) {

	// Verifica se um número foi informado
	if(empty($cnpj)) {
		return false;
	}

	// Elimina possivel mascara
	$cnpj = preg_replace("/[^0-9]/", "", $cnpj);
	$cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);
	
	// Verifica se o numero de digitos informados é igual a 11 
	if (strlen($cnpj) != 14) {
		return false;
	}
	
	// Verifica se nenhuma das sequências invalidas abaixo 
	// foi digitada. Caso afirmativo, retorna falso
	else if ($cnpj == '00000000000000' || 
		$cnpj == '11111111111111' || 
		$cnpj == '22222222222222' || 
		$cnpj == '33333333333333' || 
		$cnpj == '44444444444444' || 
		$cnpj == '55555555555555' || 
		$cnpj == '66666666666666' || 
		$cnpj == '77777777777777' || 
		$cnpj == '88888888888888' || 
		$cnpj == '99999999999999') {
		return false;
		
	 // Calcula os digitos verificadores para verificar se o
	 // CPF é válido
	 } else {   
	 
		$j = 5;
		$k = 6;
		$soma1 = "";
		$soma2 = "";

		for ($i = 0; $i < 13; $i++) {

			$j = $j == 1 ? 9 : $j;
			$k = $k == 1 ? 9 : $k;

			$soma2 += ($cnpj{$i} * $k);

			if ($i < 12) {
				$soma1 += ($cnpj{$i} * $j);
			}

			$k--;
			$j--;

		}

		$digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
		$digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

		return (($cnpj{12} == $digito1) and ($cnpj{13} == $digito2));
	 
	}
}


function geraIdade($data_nascimento){
    list($dia, $mes, $ano) = explode('/', $data_nascimento);
	$hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	$nascimento = mktime( 0, 0, 0, $mes, $dia, $ano); 
	$idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
	return $idade;
}


if(!function_exists('hash_equals'))
{
    function hash_equals($str1, $str2)
    {
        if(strlen($str1) != strlen($str2))
        {
            return false;
        }
        else
        {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--)
            {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
    }
}


