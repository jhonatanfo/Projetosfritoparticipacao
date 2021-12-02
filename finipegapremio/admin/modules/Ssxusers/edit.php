<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */
 global $Ssx;
 
 $id = get_request('id', "REQUEST", 36);

 $SsxUsers = new SsxUsers();
 $SsxGroups = new SsxGroups();
 $SsxUserGroups = new SsxUserGroups();
 
 $groups = $SsxGroups->getAll('name', 'ASC', 0,0,array('AND'=>array(array('field'=>'level', 'compare'=>'!=', 'value'=>'2'),array('field'=>'deleted', 'compare'=>'=', 'value'=>'0'))));
 if($groups)
 {
 	$groups_select = array();
 	foreach($groups as $row)
 	{
 		$groups_select[$row['id']] = $row['name'];
 	}
 }
 
 
 
 $args = array(
 	'fields'=>array(
 		array('field'=>'group_id','label'=>'Grupo','type'=>'select', 'required'=>true,'options'=>$groups_select, 'error'=>'informe o usu&aacute;rio'),
	 	array('field'=>'name','label'=>'Nome', 'type'=>'text', 'required'=>true, 'error'=>'informe o nome do usu&aacute;rio'),
	 	array('field'=>'email','label'=>'Email','type'=>'email', 'required'=>true, 'error'=>'informe o email do usu&aacute;rio'),
	 	array('field'=>'user','label'=>'Usu&aacute;rio','type'=>'text', 'required'=>true, 'error'=>'informe o usu&aacute;rio'),
	 	array('field'=>'password', 'label'=>'Senha', 'type'=>'password', 'required'=>true, 'error'=>'informe a senha'),
	 	array('field'=>'password_confirm','label'=>'Confirmar senha', 'type'=>'password', 'required'=>true, 'compare'=>'password',  'error'=>'confirme a senha'),
	 	array('field'=>'id', 'type'=>'hidden'),
	)
 );
 
 $SsxEditConstruct = new SsxEditConstruct($args);
 
 
 
 if(isset($id) && $id)
 {
 	$fill = $SsxUsers->fill($id);
 	if($fill)
 	{
 		$group_saved = $SsxUserGroups->getGroupByUser($fill['id']);
 		if($group_saved)
 		{
 			$SsxEditConstruct->setFieldsValue(array('group_id'=>$group_saved['id']));
 		}
 		$SsxEditConstruct->setFieldsValue($fill);
 		$SsxEditConstruct->ocultFields(array('password','password_confirm'));
 	}else{
 		$id = false;
 	}
 	$Ssx->themes->assign('edit','ok');
 }
 
 
 
 if(get_request('saveValues', 'POST'))
 {
 	 $data = $SsxEditConstruct->getDataRequest();
 	 
 	 if($SsxUsers->getByEmail($data['email']) && !$id)
 	 {
 	 	$Ssx->themes->assign('data_error', 'Email já cadastrado');
 	 }elseif($SsxUsers->getByUser($data['user']) && !$id)
 	 {
 	 	$Ssx->themes->assign('data_error', 'Usuário já cadastrado');
 	 }else{
 	 	$id = $SsxUsers->save($data);
 	 		
 	 	header_redirect(get_url(the_module(), 'view', array('id'=>$id)));
 	 }
 }
 
 if(isset($user_data) && $user_data)
 {
 	$SsxEditConstruct->setFieldsValue($user_data);

 }
 
 $Ssx->themes->assign('fields', $SsxEditConstruct->constructTable());
 $Ssx->themes->assign('js_content', $SsxEditConstruct->constructValidator());