<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

global $Ssx;

$SsxUsers = new SsxUsers();

$id = get_request('id', 'REQUEST', 36);

$user_logged = $SsxUsers->getDataSession();



if(isset($_POST['save']) && $_POST['save']){
	
	if ($_FILES["image_profile"]['error'] == 0) {
	
		$SsxUpload = new SsxUpload("../files/upload/profile");
	
		$resultFile = $SsxUpload->uploadImage($_FILES["image_profile"]);
		
		if ($resultFile){
			if(isset($userProfile['img_person']) && $userProfile['img_person'])
				unlink(LOCALPATH . "../files/upload/profile/" . $userProfile['img_person']);
			
			$urlimg = $resultFile;
			$profile = array(
					'id'			=>	$userProfile['id'],
					'img_person'	=>	$resultFile
			);
	
			$result = $People->save($profile);
	
			if($result){
				$userProfile['img_person'] = $resultFile;
			}
		}
	}
}

$Ssx->themes->assign('profile', $userProfile);

if(isset($id) && $id)
{
	$SsxUsers->addFilterListener('ssx_fill','ssx_get_table_logs');
	$view = $SsxUsers->fill($id);
	
	if(!$view)
		header_redirect(get_url(the_module(), 'index'));
		
	$Ssx->themes->assign('view',$view );
	
	if($user_logged['user_id'] == $id)
		$Ssx->themes->assign('is_your', true);
	else
		$Ssx->themes->assign('is_your', false);
}

if(get_request('user_alter_status', 'GET'))
{
	if($user_logged['user_id'] == $id)
	{
		$Ssx->themes->assign('view_error', "Voc&ecirc; n&atilde;o pode se desativar.");
	}elseif($id == "1")
	{
		$Ssx->themes->assign('view_error', "Voc&ecirc; n&atilde;o pode desativar o super admin");
	}else{
		if($view['status'] == "1")
		{
			$SsxUsers->desactiveStatus($id);
		}else{
			$SsxUsers->activeStatus($id);
		}
		
		header_redirect(get_url(the_module(), 'view', array('id'=>$id)));
	}	
}

if(get_request('user_delete', 'GET'))
{
	if($user_logged['user_id'] == $id)
	{
		$Ssx->themes->assign('view_error', "Voc&ecirc; n&atilde;o pode se deletar.");
	}elseif($id == "1")
	{
		$Ssx->themes->assign('view_error', "Voc&ecirc; n&atilde;o pode deletar o super admin");
	}else{
		$SsxUsers->deleteFlag($id);
				
		header_redirect(get_url(the_module(), 'index', array('user_deleted'=>true)));
	}	
}
