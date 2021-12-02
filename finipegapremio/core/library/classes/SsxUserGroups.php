<?php
/**
 * Classe de relação de usuários e grupos
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

defined("SSX") or die;

class SsxUserGroups extends SsxModels
{
	
	public $link;
	
	public $table_name = "ssx_user_groups";

	public $fields = array(
		'user_id',
		'group_id',
		'created_by',
		'date_created',
		'modified_by',
		'date_modified'
	);
	
	public $prefix = "UG";
	
	public function __construct()
	{
		parent::super();
	}
	
	public function save($data)
	{
		return parent::saveValues($data, false);
	}
	/**
	 * Verifica se esse grupo possui esse usuário
	 * @param string $user_id
	 * @param string $group_id
	 */
	public function getRelations($user_id, $group_id)
	{
		return parent::filterData(
			array(
				'user_id'=>$user_id,
				'group_id'=>$group_id
			)			
		,true);
	}
	/**
	 * Retorna usuários de um grupo em expecífico
	 * @param string $group_id
	 */
	public function getUserByGroup($group_id)
	{
		return parent::getDatabyField(array(
			'JOIN'=>array(
				'conditions'=>array(
					array(
						'prefix'=>'SU',
						'table'=>'ssx_user',
						'field'=>array(
							'id'=>array('UG'=>'user_id'),
							'deleted'=>'0'
						)
					)
				)
			),
			'fields'=>array(
				'SU'=>array('id', 'name', 'user', 'email','status'),
			),
			'AND'=>array(
				array(
					'field'=>'UG.group_id',
					'compare'=>'=',
					'value'=>$group_id
				)
			)
		));
	}
	
	public function getGroupByUser($user_id)
	{
		return parent::getDatabyField(array(
			'JOIN'=>array(
				'conditions'=>array(
					array(
						'prefix'=>'GR',
						'table'=>'ssx_groups',
						'field'=>array(
							'id'=>array('UG'=>'group_id'),
							'deleted'=>'0',
							'status'=>'1'
						)
					)
				)
			),
			'fields'=>array(
				'GR'=>array('id', 'name', 'level'),
			),
			'AND'=>array(
				array(
					'field'=>'UG.user_id',
					'compare'=>'=',
					'value'=>$user_id
				)
			)
		), true);
	}
	
	/**
	 * Deleta relação entre grupo e usuário
	 * @param string $group_id
	 * @param string $user_id
	 */
	public function delete($group_id, $user_id=null)
	{
		return parent::delete(array(
			'user_id'=>$user_id,
			'group_id'=>$group_id
		));
	}
	
	/**
	 * Deleta todas as relações de usuários com esse grupo
	 * @param string $group_id
	 */
	public function removeRelationByGroup($group_id)
	{
		return parent::delete(array(
			'group_id'=>$group_id
		));
	}
	
	/**
	 * Remove todas as permissões de grupos com esse usuário
	 * @param string $user_id
	 */
	public function removeRelationByUser($user_id)
	{
		return parent::delete(array(
			'user_id'=>$user_id
		));
	}

}