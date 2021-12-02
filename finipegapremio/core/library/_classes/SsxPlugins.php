<?php
/**
 * 
 * @author jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

defined("SSX") or die;

/**
 * Classe de gerenciamento de plugins, sera iniciada junto a Ssx
 *
 */
class SsxPlugins extends SsxModels
{
	public $link;
	
	public $table_name = "ssx_plugins";
	
	public $fields = array(
		'id',
		'date_created',
		'created_by',
		'date_modified',
		'modified_by',
		'reference_name',
		'real_name',
		'description',
		'file_reference',
		'active'
	); 
	
	public function SsxPlugins($link)
	{ 
		// necessário, pois essa classe inicia junto com a classe main do Ssx
		parent::checkLink($link);
	}
	
	public function startPlugins()
	{
		global $Ssx;
		
		$plugins = parent::filterData(array('active'=>'1'),false);
		if($plugins)
		{
			foreach($plugins as $row)
			{
				$path_plugin = PROJECTPATH . "plugins/" . $row['file_reference'];
				if(file_exists($path_plugin))
				{
					require_once($path_plugin);
					
					if(function_exists($row['reference_name'] . "_init"))
						call_user_func($row['reference_name'] . "_init");
				}else{
					$this->save(array('id'=>$row['id'], 'active'=>'0'));
				}
			}
		}
	}
	
	public function save($data)
	{
		return parent::saveValues($data);
	}
	
	public function install($file)
	{
		global $Ssx;
		
		if(!is_array($file))
			return "SsxPlugins: ".SSX_ERROR_PLUGIN_INSTALL_01;
		
		$path = PLUGINPATH;
		$zip_path = $path . $file['name'];
		
		$fileOnlyName = explode(".", $file['name']);
		unset($fileOnlyName[count($fileOnlyName)-1]);
		$fileOnlyName = implode(".", $fileOnlyName);
		$fileOnlyName = strtolower($fileOnlyName);
		$fileOnlyName = $Ssx->utils->generateSlug($fileOnlyName);
		
		if($this->getPluginByReferenceName($fileOnlyName))
			return "SsxPlugins: ".SSX_ERROR_PLUGIN_INSTALL_02;
		
		
		if(!@move_uploaded_file($file['tmp_name'],$path . $file['name']))
			return "SsxPlugins: ".SSX_ERROR_PLUGIN_INSTALL_03;
			
			
		
		$zip = new ZipArchive();
		if($zip->open($zip_path))
		{
			if($zip->locateName('manifest.xml') !== false)
			{
				$hPath = false;
				if(!file_exists($path . $fileOnlyName))
				    if(PHP_OS == "Linux")
				    {
				    	makedir($path . $fileOnlyName);
				    	$hPath = true;
				    }
				else
					$hPath = true;
						
				if($hPath)
				{
					$descompact = $zip->extractTo($path . $fileOnlyName);
					$zip->close();
					
					if($descompact)
						exec("chmod -R 777 ".$path . $fileOnlyName);
				}
			}else{
				unlink($zip_path);
				return "SsxPlugins: ".SSX_ERROR_PLUGIN_INSTALL_04;
			}
		}
		unlink($zip_path);	
		
		$data_plugin = array(
			'reference_name'=>$fileOnlyName,	
			'active'=>0
		);
		
		$xmlHandle = @simplexml_load_file($path . $fileOnlyName . "/manifest.xml");
		if($xmlHandle)
		{
			if(isset($xmlHandle->name) && $xmlHandle->name)
				$data_plugin['real_name'] = (string)$xmlHandle->name;
				
			if(isset($xmlHandle->description) && $xmlHandle->description)
				$data_plugin['description'] = (string)$xmlHandle->description;
				
			if(isset($xmlHandle->settings) && isset($xmlHandle->settings->main))
			{
				$file = $xmlHandle->settings->main['src'];
				if(file_exists($path . $fileOnlyName ."/". $file . ".php"))
					$data_plugin['file_reference'] = $fileOnlyName ."/". $file . ".php";
			}
		}else{
			if(file_exists($path . $fileOnlyName . "/" . $fileOnlyName . ".php"))
					$data_plugin['file_reference'] = $fileOnlyName . "/" . $fileOnlyName . ".php";
		}
		
		$plugin_id = $this->save($data_plugin);
		
		
		
		if(isset($data_plugin['file_reference']))
		{
			require_once($path . $data_plugin['file_reference']);
			
			// chama a função de instalação do plugin
			// só será inicializado quando for feita outra requisição ao framework
			if(function_exists($fileOnlyName .  "_install"))
			{
				call_user_func($fileOnlyName .  "_install");
			}

			$data_update = array(
				'id'=>$plugin_id,
				'active'=>1
			);
			
			$this->save($data_update);
		}else{
			return "SsxPlugins: ".SSX_ERROR_PLUGIN_INSTALL_05;
		}
		
		return true;
	}
	
	public function desactive($plugin_id)
	{
		if(!$plugin_id)
			return false;
			
		$plugin = $this->fill($plugin_id);
		if($plugin)
		{
			if($plugin['active'] == "1")
			{
				// chama a função de desinstalação
				// as vezes necessária, para não deixar nenhum lixo no sistema
				if(function_exists($plugin['reference_name'] . "_uninstall"))
				{		
					call_user_func($plugin['reference_name'] . "_uninstall");
				}
				
				$this->save(array('id'=>$plugin_id,'active'=>'0'));
			}
		}
	}
	
	public function reactive($plugin_id)
	{
		if(!$plugin_id)
			return "ID do plugin não informado";
			
		$plugin = $this->fill($plugin_id);
		if($plugin)
		{
			if($plugin['active'] == "0")
			{
				$data_plugin = array
				(
					'id'=>$plugin_id,
					'active'=>'1'
				);
				$xmlHandle = @simplexml_load_file(PLUGINPATH . $plugin['reference_name'] . "/manifest.xml");
				if($xmlHandle)
				{
					if(isset($xmlHandle->name) && $xmlHandle->name)
						$data_plugin['real_name'] = (string)$xmlHandle->name;
						
					if(isset($xmlHandle->description) && $xmlHandle->description)
						$data_plugin['description'] = (string)$xmlHandle->description;
						
					if(isset($xmlHandle->settings) && isset($xmlHandle->settings->main))
					{
						$file = $xmlHandle->settings->main['src'];
						
						if(!file_exists(PLUGINPATH . $plugin['reference_name'] ."/". $file . ".php"))
							return "Arquivos de inicialização do plugin n&atilde;o encontrado";
							
						$data_plugin['file_reference'] = $plugin['reference_name'] ."/". $file . ".php";
					}
					
					if(isset($data_plugin['file_reference']))
					{
						require_once(PLUGINPATH . $data_plugin['file_reference']);
			
						if(function_exists($plugin['reference_name'] .  "_install"))
						{
							call_user_func($plugin['reference_name'] .  "_install");
						}
		
						
						$this->save($data_plugin);
					}
				}else{
					return SSX_ERROR_PLUGIN_INSTALL_04;
				}
			}
			return true;
		}
		return "Plugin não encontrado";
	}
	
	public function getPluginByReferenceName($name)
	{
		return parent::filterData(array('reference_name'=>$name), true);
	}
	
	public function &load($plugin_name)
	{
		if(!$plugin_name)
		{
			print SSX_ERROR_PLUGIN_01; return;
		}
		
		if(isset($this->$plugin_name) && $this->$plugin_name)
			return $this->$plugin_name;
		
		$file_address = "";
		
		if(file_exists(LOCALPATH . "plugins/" .$plugin_name . ".php"))
		{
			$file_address = LOCALPATH . "plugins/" .$plugin_name . ".php";
			
		}else if(file_exists(LOCALPATH . "plugins/" .$plugin_name ."/" .$plugin_name . ".php"))
		{
			$file_address = LOCALPATH . "plugins/" .$plugin_name ."/" .$plugin_name . ".php";
		}else{
			print SSX_ERROR_PLUGIN_02;return;
			
		}
		try
		{
			require($file_address);
			
			if(!class_exists($plugin_name))
			{
				print SSX_ERROR_PLUGIN_04;return;
			}
		
			$obj = new $plugin_name();
		
			$this->$plugin_name = $obj;
			
			return $this->$plugin_name;
			
		}catch(Exception $e)
		{
			print SSX_ERROR_PLUGIN_03;return;
		}
	}
}