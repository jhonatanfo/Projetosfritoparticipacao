<?php
/**
 * Classe de controle de grupos de usuários do sistema
 * Grupos de usuários serão utilizados para controle de ACL
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

defined("SSX") or die;

class SsxGroups extends SsxModels
{
	public $link;
	
	public $table_name = "ssx_groups";
	
	public $fields = array(
		'id',
		'created_by',
		'date_created',
		'modified_by',
		'date_modified',
		'deleted',
		'name',
		'description',
		'level',
		'status'
	);
	
	const LEVEL_GUEST = "2";
	const LEVEL_USER  = "1";
	const LEVEL_ADMIN = "0";
	
	public function __construct()
	{
		parent::super();
	}
	
	/**
	 * Salva os dados acrescentando um hash de char(36)
	 * @param array $data
	 */
	public function save($data)
	{
		return parent::saveValues($data);
	}
	
	/**
	 * Não deleta definitivamente o grupo, apenas manda para uma lixeira, não aparecendo mais em nenhuma busca
	 * @param string $id
	 */
	public function delete($id)
	{
		return parent::deleteFlag($id);
	}
	
	/**
	 * Retorna os dados de um grupo em expecífico
	 * @param string $id
	 */
	public function fill($id)
	{
		return parent::filterData(
			array(
				'id'=>$id,
				'deleted'=>'0'
			),
		true);
	}
	
	/**
	 * Verifica se já existe algum grupo com esse mesmo nome
	 * @param string $name
	 */
	public function check_name($name)
	{
		return parent::filterData(
			array(
				'name'=>$name
			),
		true);
	}
	
	public function getGuestGroup()
	{
		return parent::filterData(array('level'=>'2'), true);
	}
}