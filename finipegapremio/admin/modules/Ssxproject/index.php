<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

 $SsxGroups = new SsxGroups();
 
 $msg = get_request("report", "REQUEST");
 
 if($msg){
 	$Ssx->themes->assign("msg_display", SsxMessages::getMessage($msg)); 	
 }
 	
 
 $args = array(
 	'fields'=>array(
 		array('field'=>'project_use_smtp','label'=>'Usar SMTP para enviar email', 'type'=>'check','options'=>array('1'=>'Ativar')),
 		array('field'=>'project_smtp_prefix','label'=>'SMTP Connection Prefix', 'type'=>'select', 'options'=>array('ssl'=>'SSL','tls'=>'TLS'), 'value'=>'tls'),
 		array('field'=>'project_smtp_host','label'=>'SMTP Server Host', 'type'=>'text'),
 		array('field'=>'project_smtp_user','label'=>'SMTP Server User', 'type'=>'text'),
 		array('field'=>'project_smtp_pass','label'=>'SMTP Server Pass', 'type'=>'password'),
 		array('field'=>'project_smtp_port','label'=>'SMTP Server Port', 'type'=>'text'),
 		array('field'=>'label','type'=>'label','label'=>'SEO do Projeto'),
 		array('field'=>'project_seo_title','label'=>'T&iacute;tulo do projeto', 'type'=>'text'),
 		array('field'=>'project_seo_keywords','label'=>'Keywords', 'type'=>'text'),
 		array('field'=>'project_seo_description','label'=>'Descri&ccedil;&atilde;o', 'type'=>'textarea'),
 	)
 );
 
  $query = array(
  	'AND'=>array(
  		array('field'=>'level','compare'=>'!=','value'=>"0"),
  		array('field'=>'level','compare'=>'!=','value'=>2),
  		array('field'=>'deleted','compare'=>'=','value'=>"0"),
  	)
  );
  $groups = $SsxGroups->getAll('name', 'ASC',0,0,$query);
  if($groups)
  {
  	 $group_select = array();
  	 foreach($groups as $g)
  	 {
  	 	$group_select[$g['id']] = $g['name'];
  	 }
  	 $args['fields'][] = array('field'=>'label2','type'=>'label','label'=>'Configurações gerais');
  	 $args['fields'][] = array('field'=>'project_group_default','label'=>'Grupo padrão para novos usuários', 'type'=>'select', 'options'=>$group_select);
  }
  
  $args['fields'][] = array('field'=>'project_pages_allow','label'=>'Permitir exibição de páginas estáticas', 'type'=>'check','options'=>array('1'=>'Ativar'));
  $link = siteurl().strtolower($Ssx->themes->ssx_module).'/cacheclear?clear=true';
 $args['fields'][] = array('field'=>'clear_cache','label'=>' ','type'=>'link','classes'=>'btn btn-danger','value'=>'Limpar Cache' ,'link'=>$link);
  
  
 $SsxEditConstruct = new SsxEditConstruct($args);
 
 // recuperando dados //
 $fields_value = array(
 	'project_use_smtp'=>SsxConfig::get(SsxConfig::SSX_USE_STMP),
 	'project_group_default'=>SsxConfig::get(SsxConfig::SSX_DEFAULT_USER_GROUP),
 	'project_seo_title'=>SsxConfig::get(SsxConfig::SSX_SEO_TITLE),
 	'project_seo_keywords'=>SsxConfig::get(SsxConfig::SSX_SEO_KEYWORDS),
 	'project_seo_description'=>SsxConfig::get(SsxConfig::SSX_SEO_DESCRIPTION),
 	'project_pages_allow'=>SsxConfig::get(SsxConfig::SSX_PAGES_ALLOW),
 );
 
 $smtp_view = SsxConfig::get(SsxConfig::SSX_SMTP_DATA,'json');
 if($smtp_view)
 {
 	 	$fields_value['project_smtp_host'] = $smtp_view['host'];
 	 	$fields_value['project_smtp_user'] = $smtp_view['user'];
 	 	$fields_value['project_smtp_pass'] = $smtp_view['pass'];
 	 	$fields_value['project_smtp_port'] = $smtp_view['port'];
 	 	$fields_value['project_smtp_prefix'] = $smtp_view['prefix'];
 }
 
 $SsxEditConstruct->setFieldsValue($fields_value);
 
 if($SsxEditConstruct->save())
 {
 	 $data_request = $SsxEditConstruct->getDataRequest();
 	 
 	 $smtp_data = array(
 	 	'host'=>$data_request['project_smtp_host'],
 	 	'user'=>$data_request['project_smtp_user'],
 	 	'pass'=>$data_request['project_smtp_pass'],
 	 	'port'=>$data_request['project_smtp_port'],
 	 	'prefix'=>$data_request['project_smtp_prefix'],
 	 );
 	 
 	 SsxConfig::set(SsxConfig::SSX_USE_STMP,$data_request['project_use_smtp']);
 	 
 	 SsxConfig::set(SsxConfig::SSX_SEO_TITLE,$data_request['project_seo_title']);
 	 SsxConfig::set(SsxConfig::SSX_SEO_KEYWORDS,$data_request['project_seo_keywords']);
 	 SsxConfig::set(SsxConfig::SSX_SEO_DESCRIPTION,$data_request['project_seo_description']);
 	 
 	 SsxConfig::set(SsxConfig::SSX_SMTP_DATA,json_encode($smtp_data));
 	 
 	 if(isset($data_request['project_group_default']))
 	 	SsxConfig::set(SsxConfig::SSX_DEFAULT_USER_GROUP,$data_request['project_group_default']);
 	 	
 	 SsxConfig::set(SsxConfig::SSX_PAGES_ALLOW,$data_request['project_pages_allow']);
 	 	
 	 header_redirect(get_url(the_module(), the_action(), array('saved'=>'true')));
 }
 
 if(get_request('saved', 'GET'))
 {
 	$Ssx->themes->assign('saved', 'true');
 }
 
 $Ssx->themes->assign('fields', $SsxEditConstruct->constructTable());
 $Ssx->themes->assign('js_content', $SsxEditConstruct->constructValidator());