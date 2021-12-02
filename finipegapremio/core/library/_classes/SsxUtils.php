<?php
/**
 * Classe contendo utilitarios para o uso no projeto
 * 
 * @author Jasiel Macedo
 * @version 1.0
 */

defined("SSX") or die;

class SsxUtils
{
	public function SsxUtils(){}
	
	/**
	 * Transforma o valor informado em um valor int
	 * @param $void mixed
	 * @return int
	 */
	public function setInt($void){ return (int)$void; }
	
	/**
	 * Transforma o valor informado em um valor string
	 * @param $void mixed
	 * @return string
	 */
	public function setString($void){ return (string)$void; }
	
	/**
	 * Transforma o valor informado em um valor float
	 * @param $void mixed
	 * @return float
	 */
	public function setFloat($void){ return floatval($void); }
	
	/**
	 * Transforma o valor informado em um valor float
	 * Invocando a função setFloat()
	 * @param $void mixed
	 * @return float
	 */
	public function setNumber($void){ return $this->setFloat($void); }
	
	/**
	 * Converte um texto titulo em um texto de slug para URL
	 * 
	 * @param $phrase string
	 * @param $maxLength int
	 * @return string
	 */
	public function generateSlug($phrase, $maxLength=255)
	{
		if(!$phrase)
			return;
		
		$result = strtolower($phrase);
		$result = $this->removeAccents($result);
		$result = strip_tags($result);
		$result = preg_replace("/[^a-z0-9\s-]/", "", $result);
		$result = trim(preg_replace("/[\s-]+/", " ", $result));
		$result = trim(substr($result, 0, $maxLength));
		$result = preg_replace("/\s/", "-", $result);
		
		return $result;
	}
	
	/**
	 * Checks to see if a string is utf8 encoded.
	 *
	 * NOTE: This function checks for 5-Byte sequences, UTF8
	 *       has Bytes Sequences with a maximum length of 4.
	 *
	 * @author bmorel at ssi dot fr (modified)
	 * @since 1.3.2
	 *
	 * @param string $str The string to be checked
	 * @return bool True if $str fits a UTF-8 model, false otherwise.
	 */
	public function seems_utf8($str) {
		$length = strlen($str);
		for ($i=0; $i < $length; $i++) {
			$c = ord($str[$i]);
			if ($c < 0x80) $n = 0; # 0bbbbbbb
			elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
			elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
			elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
			elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
			elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
			else return false; # Does not match any model
			for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
				if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
					return false;
			}
		}
		return true;
	}
	
	/**
	 * Converts all accent characters to ASCII characters.
	 *
	 * If there are no accent characters, then the string given is just returned.
	 * 
	 * @author Wordpress
	 * @since 1.3.2
	 *
	 * @param string $string Text that might have accent characters
	 * @return string Filtered string with replaced "nice" characters.
	 */
	public function removeAccents($string)
	{
		
		if ( !preg_match('/[\x80-\xff]/', $string) )
			return $string;
	
		if ($this->seems_utf8($string)) {
			$chars = array(
			// Decompositions for Latin-1 Supplement
			chr(194).chr(170) => 'a', chr(194).chr(186) => 'o',
			chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
			chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
			chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
			chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
			chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
			chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
			chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
			chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
			chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
			chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
			chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
			chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
			chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
			chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
			chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
			chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
			chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
			chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
			chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
			chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
			chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
			chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
			chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
			chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
			chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
			chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
			chr(195).chr(182) => 'o', chr(195).chr(184) => 'o',
			chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
			chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
			chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
			chr(195).chr(191) => 'y', chr(195).chr(152) => 'O',
			// Decompositions for Latin Extended-A
			chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
			chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
			chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
			chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
			chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
			chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
			chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
			chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
			chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
			chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
			chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
			chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
			chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
			chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
			chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
			chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
			chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
			chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
			chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
			chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
			chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
			chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
			chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
			chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
			chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
			chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
			chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
			chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
			chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
			chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
			chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
			chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
			chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
			chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
			chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
			chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
			chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
			chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
			chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
			chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
			chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
			chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
			chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
			chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
			chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
			chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
			chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
			chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
			chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
			chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
			chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
			chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
			chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
			chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
			chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
			chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
			chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
			chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
			chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
			chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
			chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
			chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
			chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
			chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
			// Decompositions for Latin Extended-B
			chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
			chr(200).chr(154) => 'T', chr(200).chr(155) => 't',
			// Euro Sign
			chr(226).chr(130).chr(172) => 'E',
			// GBP (Pound) Sign
			chr(194).chr(163) => '');
	
			$string = strtr($string, $chars);
		} else {
			// Assume ISO-8859-1 if not UTF-8
			$chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
				.chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
				.chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
				.chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
				.chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
				.chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
				.chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
				.chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
				.chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
				.chr(252).chr(253).chr(255);
	
			$chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
	
			$string = strtr($string, $chars['in'], $chars['out']);
			$double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
			$double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
			$string = str_replace($double_chars['in'], $double_chars['out'], $string);
		}
	
		return $string;
	}
	/**
	 * Trasnforma o array informado em uma string JSON
	 * @param $array dados que serão transformados em JSON
	 * @return return string
	 */
	public function jsonReturn($array){ if(function_exists('json_encode')){ return json_encode($array); }  }
	
	/**
	 * Trasnforma uma string informada em um array Nominal
	 * @param $string dados que serão transformados em Array
	 * @return return array
	 */
	public function jsonReceive($string){ if(function_exists('json_decode')){ return json_decode($string); }  }
	
	
	/**
	 * Retorna o valor da chave GET
	 * @param $key chave do array super global _GET
	 * @return mixed
	 */
	function secureSuperGlobalGET($key)
    {
    	if(is_string($_GET[$key]))
    	{
        	$_GET[$key] = $this->secureString($_GET[$key]);
    	}
        return $_GET[$key];
    }
   
    /**
     * Retorna o valor da chave POST
     * @param $key chave do array super global _POST
     * @return mixed
     */
    function secureSuperGlobalPOST($key)
    {
    	if(is_string($_POST[$key]))
    	{
        	$_POST[$key] = $this->secureString($_POST[$key]);
    	}
        return $_POST[$key];
    }
    
	/**
     * Retorna o valor da chave _REQUEST
     * @param $key chave do array super global _REQUEST
     * @return mixed
     */
    function secureSuperGlobalREQUEST($key)
    {
    	if(is_string($_REQUEST[$key]))
    	{
        	$_REQUEST[$key] = $this->secureString($_REQUEST[$key]);
    	}
        return $_REQUEST[$key];
    }
    
    /**
     * Tira as possibilidades de uma string ser um injection
     * @param $str
     * @return string String tratada
     */
    public function secureString($str)
    {
    	if(!is_string($str))
    		return $str;
    	
    	$str = stripslashes($str);
        $str = str_ireplace("script", "blocked", $str);
        // $str = mysql_escape_string($str);
        
        return $str;
    }
    
    /**
     * 
     * @param $value Email a ser verificado
     * @return boolean Retorna true se for um email valido
     */
	public function check_email($value)
    {
		  $re1='([\\w-+]+(?:\\.[\\w-+]+)*@(?:[\\w-]+\\.)+[a-zA-Z]{2,7})';	
		
		  if (preg_match ("/".$re1."/is", $value))
		  {
		      return true;
		  }
		  
		  return false;
    	
    }
    
    /**
     * Função de load de dll adicionais do php
     * 
     * @param $n nome da dll
     * @param $k nome adicional para a dll
     * @return true
     */
    public function load_dll($n, $f = null)
    {
    	return extension_loaded($n) or dl(((PHP_SHLIB_SUFFIX === 'dll') ? 'php_' : '') . ($f ? $f : $n) . '.' . PHP_SHLIB_SUFFIX);
    }
    
    /**
     * Escreve na tela um formato preview do conteúdo
     * @param $obj
     * @return unknown_type
     */
    public function debug($obj, $die=false)
    {
    	echo "<pre>";
    		print_r($obj);
    	echo "</pre>";
    	
    	if($die)
    		exit;
    		
    	return;	
    }
    
    /**
     * Retorna string vazia se a variavel indicada não tiver um valor valido
     * @param $var string
     * @param $opcional_value caso seja indicada, o valor a ser retornado caso não encontre, será o dessa variável
     * @return mixed
     */
    public function emptyComplete($var, $opcional_value="")
    {
    	$return = isset($opcional_value) && $opcional_value?$opcional_value:"";
    	return isset($var) && $var?addslashes($var):$return;
    }
    
    /**
     * @return CKEditor
     */
    public function ckeditor()
    {
    	if(!class_exists('CKEditor'))
    		require(RESOURCEPATH . "ckeditor/ckeditor.php");
    	
    	load_js(coreurl() . "resources/ckeditor/ckeditor.js");
    	
    	$CKEditor = new CKEditor();
    	$CKEditor->basePath = coreurl() . "resources/ckeditor/";
    	
    	return $CKEditor;
    }
    
    /**
     * Verifica se o usuário está acessando a aplicação apartir de um mobile
     */
    public function isMobile()
    {
    	$mobileDetect = new DeviceDetect();
    	return ($mobileDetect->mobile_device_detect())?true:false;
    }
    
    public function formatDate($date, $format="d/m/Y h:i")
    {
    	if(!is_string($date))
    		return;
    		
    	$dateArray = explode(" ", $date);
    	if($dateArray)
    	{
    		$dateDay = explode("-", $dateArray[0]);
    		if(isset($dateArray[1]))
    			$dateHour = explode(":", $dateArray[1]);
    		else
    			$dateHour = array(0,0,0);
    		
    		$mktime = mktime($dateHour[0], $dateHour[1], $dateHour[2], $dateDay[1], $dateDay[2], $dateDay[0]);
    		return date($format, $mktime);
    	}
    	return;
    }
    
    /* memory garbage */
    public static function gc_on()
    {
    	if(function_exists('gc_enable'))
    	    gc_enable();
    	return false;	
    }
}