<?php
/**
 * 
 * Config do sistema, que serão usadas para armazenas configs especiais
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */


class SsxConfig extends SsxModels
{
	/* default configs*/
	const SSX_USE_STMP = "_ssx_use_smtp";
	const SSX_SMTP_DATA = "_ssx_smpt_data";
	const SSX_DEFAULT_USER_GROUP = "_ssx_default_user_group";
	
	const SSX_SEO_TITLE = "_ssx_seo_title";
	const SSX_SEO_KEYWORDS = "_ssx_seo_keywords";
	const SSX_SEO_DESCRIPTION = "_ssx_seo_description";
	
	const SSX_PAGES_ALLOW = "_ssx_pages_allow";
	/* end default configs */
	
	public $link;
	
	public $table_name = "ssx_config";
	
	public $fields = array(
		'id',
		'created_by',
		'date_created',
		'modified_by',
		'date_modified',
		'object_name',
		'object_value'
	);
	
	public function save($data)
	{
		return parent::saveValues($data);
	}
	
	public function getConfig($name)
	{
		$result = parent::filterData(array('object_name'=>$name),true);
		return $result;			
	}
	
	/**
	 * Retorna a config salva no banco de dados
	 * retornará apenas o que está no campo VALUE
	 * @param string $name
	 * @param string $type JSON | SERIALIZED | STRING | INT
	 * @return mixed
	 */
	public static function get($name, $type='string')
	{
		$SsxConfig = new SsxConfig();
		$config = $SsxConfig->getConfig($name);
		if($config)
		{
			switch($type)
			{
				case 'string':
					return (string)$config['object_value'];
				break;
				case 'int':
					return (int)$config['object_value'];
				break;
				case 'serialized':
					return @unserialize($config['object_value']);
				break;
				case 'json':
					return @json_decode($config['object_value'], true);
				break;
			}
		}
		return false;
	}
	
	/**
	 * Cria ou atualiza uma config no banco de dados
	 * 
	 * @param string $name nome da config
	 * @param string $value	valor da config
	 * @param boolean $replace se deve substituir uma já existe caso exista
	 * 
	 * @return string id da config criada
	 */
	public static function set($name, $value, $replace=true)
	{
		$SsxConfig = new SsxConfig();
		
		$config = $SsxConfig->getConfig($name);
		
		$data = array(
			'object_name'=>$name,
			'object_value'=>$value
		);
		
		if($config)
		{
			if($replace)
			{
				$data['id'] = $config['id'];
				return $SsxConfig->save($data);
			}
			return $config['id'];
		}else{
			return $SsxConfig->save($data);
		}
		
	}
}