<?php
/**
 * Token unico gerado para o usuário em casos especiais
 * O usuário só pode ter um token
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

class SsxUserToken extends SsxModels
{
	public $link;
	
	public $table_name = "ssx_user_token";
	
	public $fields = array(
		'id',
		'date_created',
		'created_by',
		'date_modified',
		'modified_by',
		'user_id',
		'token',
		'used'
	);
	
	public function SsxUserToken()
	{
		parent::super();
	}
	
	public function save($data)
	{
		return parent::saveValues($data);
	}
	
	/**
	 * Gera um novo token para o usuário,
	 * caso já exista algum para o mesmo, será deletado
	 * @param $user_id
	 * @return string Token
	 */
	public function generateToken($user_id)
	{
		parent::delete(array('user_id'=>$user_id));
		
		$token = parent::create_guid();
		
		$data = array(
		    'created_by'=>$user_id,
			'modified_by'=>$user_id,
			'user_id'=>$user_id,
			'token'=>$token
		);
		
		$this->save($data);
		
		SsxActivity::dispatchActivity('ssx_user_new_token');
		
		return $token;
	}
	
	public function markUsedToken($id)
	{
		return $this->save(array('id'=>$id,'used'=>'1'));
	}
	/* get section */
	public function getTokenByUser($user_id){ return parent::filterData(array('user_id'=>$user_id, true)); }
	public function getUserByToken($token){ return parent::filterData(array('token'=>$token, true)); }
	
	/* delete section */
	public function deleteByToken($token){ return parent::delete(array('token'=>$token)); }
	public function deleteByUser($user_id){ return parent::delete(array('user_id'=>$user_id)); }
}