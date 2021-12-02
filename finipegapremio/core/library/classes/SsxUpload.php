<?php
/**
 *
 * Classe de upload simples do Ssx
 *
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

defined("SSX") or die;

class SsxUpload extends SsxModels
{
	private $dir_upload = "";

	/**
	 * Ao contruir indicar o diretório na qual será salvo o arquivo
	 * O caminho sempre será incluído depois de LOCALPATH se o $autocomplete for igual a true
	 * @param string $dir
	 * @param bool $autocomplete
	 */
	public function __construct($dir, $autocomplete=true)
	{


		if($autocomplete)
		{
			if(substr($dir,0,1) == "/")
			$dir = substr($dir, 1,strlen($dir)-1);

			$this->dir_upload = LOCALPATH . $dir;
		}else
			$this->dir_upload = $dir;

		if(substr($this->dir_upload, strlen($this->dir_upload)-1,1) == "/")
			$this->dir_upload = substr($this->dir_upload, 0,strlen($this->dir_upload)-1);

		if(!file_exists($this->dir_upload))
			die('SsxUpload: Dir not found ');
	}

	/**
	 * Upload simples de imagem
	 * suporte a png/jpeg e gif apenas
	 * @param $_FILES $file
	 */
	public function uploadImage($file)
	{
		if(!is_array($file))
			return false;

		$newname = parent::create_guid();

		$fileExtension = "";

		switch($file['type'])
		{
			case "image/png": $fileExtension = ".png"; break;
			case "image/jpeg": $fileExtension = ".jpg"; break;
			case "image/gif": $fileExtension = ".gif"; break;
			case "image/pjpeg": $fileExtension = ".jpg"; break;
			default: return false; break;
		}

		$new_file_name = $newname . $fileExtension;
		try
		{
			if(!@move_uploaded_file($file['tmp_name'],$this->dir_upload . "/" . $new_file_name))
			{
				@copy($file['tmp_name'],$this->dir_upload . "/" . $new_file_name);
			}

			if(!file_exists($this->dir_upload . "/" . $new_file_name))
				throw new Exception("Erro ao subir arquivo");

			return $new_file_name;
		}catch(Exception $e)
		{
			return false;
		}
		return false;
	}

	/**
	 * Upload simples de arquivos
	 *
	 * @param array $file
	 * @param extAllow define quais extensões de arquivos serão permitidas
	 * @return string|bool
	 */
	public function uploadFile($file, $extAllow=array())
	{
		if(!is_array($file))
			return false;

		$newname = parent::create_guid();

		if(!$extAllow)
		{
			/*
			 * Extensões:
			 * doc,docx,xls,xlsx,ppt,pptx,rtf - Microsoft Office
			 * pdf - Adobe
			 * txt - default
			 * odt,ods,odp - BrOffice
			 */
			$extAllow = array('doc','pdf','txt', 'xls','xlsx','docx','rtf','odt','ods','odp','ppt','pptx','zip','ogg','mp4','wav','mp3');
		}
		$fileExtension = explode(".", $file['name']);
		$fileExtension = end($fileExtension);
		if(array_search($fileExtension,$extAllow)===false){
			return false;
		}
		$new_file_name = $newname .".". $fileExtension;
		try
		{
			if(!@move_uploaded_file($file['tmp_name'],$this->dir_upload . "/" . $new_file_name))
			{
				@copy($file['tmp_name'],$this->dir_upload . "/" . $new_file_name);
			}
			if(!file_exists($this->dir_upload . "/" . $new_file_name)){
					throw new Exception("Erro ao subir arquivo. Verifique se a pasta indicada possui permissão de escrita.");
			}
			return $new_file_name;

		}catch(Exception $e)
		{
			return false;
		}
		return false;
	}
}
