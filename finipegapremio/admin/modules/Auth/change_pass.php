<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

 global $Ssx;
 
 $Ssx->themes->set_theme_title('| Trocar senha', false);
 
 $SsxUsers = new SsxUsers($Ssx->link);
 
 $user_id = get_request('id', 'REQUEST', 36);
 $user_data = SsxUsers::getDataSession();
 
 if(isset($user_id) && $user_id)
 {
	 $userFill = $SsxUsers->fill($user_id);
 }else{
 	 if($user_data)
	 {
	 	$userFill = $SsxUsers->fill($user_data['user_id']);
	 }
 }
 

 
 $Ssx->themes->assign('user', $userFill);
 
 
 if(get_request('saveChange', 'POST') && $userFill)
 {
 	  $new_pass = get_request('new_pass', 'POST');
 	  
 	  $data = array(
 	  	 'id'=>$userFill['id'],
 	  	 'password'=>$new_pass
 	  );
 	  if(!$SsxUsers->getDatabyField(array(
 	  	'AND'=>array(
 	  		array(
 	  			'field'=>'password',
 	  			'compare'=>'=',
 	  			'value'=>$SsxUsers->encryptPassword(get_request('old_pass', 'POST'))
 	  		),
 	  		array(
 	  			'field'=>'id',
 	  			'compare'=>'=',
 	  			'value'=>$data['id']
 	  		)
 	  	)
 	  ),true))
 	  {
 	  	 $Ssx->themes->assign('pass_error', 'Senha atual informada é inválida');
 	  }else{
 	  	 $SsxUsers->save($data);
 	  	 
 	  	 if($user_id)
 	  	 	 header_redirect(get_url('ssxusers', 'view',array('id'=>$user_id)));
 	  	 else
 	  		 SsxUsers::logout();
 	  }
 }