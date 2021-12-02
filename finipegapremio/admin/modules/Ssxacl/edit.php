<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

global $Ssx;

$SsxAcl = new SsxAcl();
$SsxGroups = new SsxGroups();

$groups = $SsxGroups->getAll('name','ASC',0,0,array('AND'=>array(array('field'=>'deleted','compare'=>'=','value'=>'0'))));



$Ssx->themes->assign('groups', $groups);

$group_id = get_request('group_id', 'REQUEST', 36);

if(get_request('save', 'POST'))
{
	$me = $SsxAcl->getByGroup($group_id);
	$data = get_request('data','POST');
	if(is_array($data))
	{
		$data_content = serialize($data);
	}
	
	$saveData = array();
	
	if($me)
	{
		if($me['permissions'] != "all_access")
		{
			$saveData = array(
				'id'=>$me['id'],
				'permissions'=>$data_content
			);
		}
	}else{
		$saveData = array(
			'group_id'=>$group_id,
			'permissions'=>$data_content
		);
	}
	
	if($saveData)
	{
		$SsxAcl->save($saveData);
		header_redirect(get_url(the_module(), the_action(), array('group_id'=>$group_id)));
	}
}

if(isset($group_id) && $group_id)
{
	$SsxAcl->addFilterListener('ssx_filterdata', 'ssx_get_table_logs');
	
	$permissions = $SsxAcl->getByGroup($group_id);
	if($permissions)
	{
		$Ssx->themes->assign('p_details', $permissions);
		
		$permissions = $permissions['permissions'];
		if($permissions != "all_access")
		{
			try
			{
				$permissions = unserialize($permissions);
				if(!$permissions)
					throw new Exception("dado invalido para deserializar");
			}catch(Exception $e)
			{
				$permissions = $SsxAcl->defaultPermission();
			}
			$permissions = $SsxAcl->setPermission($permissions);
		}
	}else{
		$permissions = $SsxAcl->defaultPermission();
	}
	
	$Ssx->themes->assign('group_id', $group_id);
	$Ssx->themes->assign('group_permissions', $permissions);
}


