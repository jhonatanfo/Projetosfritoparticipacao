<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */


global $Ssx;

$SsxGroups = new SsxGroups();
$SsxUserGroups = new SsxUserGroups();

$id = get_request('id', 'REQUEST', 36);




if(isset($id) && $id)
{
	$SsxGroups->addFilterListener('ssx_filterdata','ssx_get_table_logs');
	
	$view = $SsxGroups->fill($id);
	
	if(!$view)
		header_redirect(get_url(the_module(), 'index'));
		
	$users = $SsxUserGroups->getUserByGroup($view['id']);

	
	$Ssx->themes->assign('view',$view );
	$Ssx->themes->assign('users', $users);
}


$group_alter_status = get_request('group_alter_status', 'REQUEST', 36);
if($group_alter_status)
{
	$data = array(
		'id'=>$id
	);
	if($view['status'] == "1")
	{
		$data['status'] = "0";
	}else{
		$data['status'] = "1";
	}
	$SsxGroups->save($data);
	header_redirect(get_url(the_module(), the_action(), array('id'=>$id)));
}

if(get_request('delete', 'GET'))
{
	$SsxGroups->deleteFlag($id);
	header_redirect(get_url(the_module(),'index'));
}
