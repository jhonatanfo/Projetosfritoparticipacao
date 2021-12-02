<?php
/**
 * Classe de contrução de forms para o admin usando um modelo padrão de construção por table
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * @copyright Ideia original Welson Tavares
 * 
 */
ini_set("memory_limit",-1);
defined("SSX") or die;

class SsxEditConstructV2
{
	private $args;
	
	private $fields;

	private $data;
	
	private $method = "post";
	
	private $action = "";
	
	private $editor = false;

	protected $dbn = NULL;

	private $table;
	
	
	/**
	 * Objeto do plugin ckeditor
	 * @var SsxEditor
	 */
	private $editor_plugin;
	
	public function __construct($data=array(),$args,$labels_exceptions=array(),$table='')
	{

		if(is_array($data) && !empty($data)){
			$this->data = $data;
		}

		if($table){
			$this->dbn = new PDO(
				"mysql:host=".SSX_DB_HOST.";dbname=".SSX_DB_DATABASE,
				SSX_DB_USER,
				SSX_DB_PASS,
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
		    );
		    $this->dbn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->table = $table;
			self::getArgsByTable($args,$labels_exceptions);
		}		

		$this->msg = null;
		/*Mandar messagem de erro ou sucesso*/
		if(isset($_SESSION['message'])){
			$this->msg = $_SESSION['message'];
			unset($_SESSION['message']);
		}

		if(!is_array($args) && !is_array($this->args)){
			die(SSX_EDIT_CONSTRUCT_ERROR_00);
		}

		$this->args = $this->table == '' ?  $args : $this->args;
		$this->constructArrayArgsByDados($data,$args,$labels_exceptions);
		$this->prepare();

	}
	
	private function prepare()
	{
		global $Ssx;

		if($this->args)
		{
			if(isset($this->args['fields']) && $this->args['fields'])
			{
				$kReserv = 1;
				foreach($this->args['fields'] as $fields)
				{
					if(isset($fields['field']) && $fields['field'])
					{
						$this->fields[$fields['field']] = array(
							'label'=>isset($fields['label']) && $fields['label']?$fields['label']:"Campo ".$kReserv.":",
							'link'=>isset($fields['link']) && $fields['link']?$fields['link']:"",
							'error'=>isset($fields['error']) && $fields['error']?$fields['error']:"Preencha o campo corretamente",
							'type'=>isset($fields['type']) && $fields['type']?$fields['type']:"text",
							'required'=>isset($fields['required']) && $fields['required']?$fields['required']:false,
							'compare'=>isset($fields['compare']) && $fields['compare']?$fields['compare']:false,
							'value'=>isset($fields['value']) && $fields['value']?$fields['value']:"",
							'classes'=>isset($fields['classes']) && $fields['classes']?$fields['classes']:"",
							'options'=>isset($fields['options']) && $fields['options']?$fields['options']:false
						);

						
						if($this->fields[$fields['field']]['type'] == "email")
						{
							$this->fields[$fields['field']]['email_error'] = isset($fields['email_error']) && $fields['email_error']?$fields['email_error']:"Email inv&aacute;lido";
						}
					}
					$kReserv++;
				}
			}
			
			if(isset($this->args['editor']) && $this->args['editor'])
			{
				$this->editor = true;
				$this->editor_plugin = new SsxEditor();
			} 
		}
	}
	
	public function save()
	{
		return get_request('saveValues', 'POST');
	}
	
	public function setFieldsValue($args)
	{
		if(!is_array($args) || !$this->fields)
			return;
			
		if($args)
		{
			foreach($args as $fieldKey => $fieldValue)
			{
				if(isset($this->fields[$fieldKey]) && $this->fields[$fieldKey])
				{
					$this->fields[$fieldKey]['value'] = $fieldValue;
				}
			}
		}
	}
	
	public function ocultFields($args)
	{
		if(!$this->fields)
			return;
			
		if($args)
		{
			foreach($args as $fieldKey)
			{
				if(isset($this->fields[$fieldKey]) && $this->fields[$fieldKey])
				{
					$this->fields[$fieldKey]['hidden'] = true;
				}
			}
		}
	}
	
	public function constructForm()
	{
		$content = "";

		if(is_array($this->msg) && !empty($this->msg)){
			$content .='<div>';
			// $content .='  <h1>Fini <small>fale conosco</small></h1>';
			$content .='	<div class="alert alert-'.$this->msg['status'].' alert-dismissible" role="alert">';
			$content .='	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">';
			$content .='	  	<span aria-hidden="true">&times;</span>';
			$content .='	  </button>';
			$content .='	  '.$this->msg["text"];
			$content .='	</div>';
			$content .='</div>';
		}
		
		if(!is_array($this->fields)){
			return false;
		}

		$content .="<form autocomplete='off' class=\"form-horizontal col-md-4\" action='".$this->action."' method='".$this->method."' onsubmit='return validForm()' enctype=\"multipart/form-data\">\n";
		//$content .= "<table>\n";
		if($this->fields)
		{

			$hidden = "";
			foreach($this->fields as $fieldName => $fieldArgs)
			{

				if(isset($fieldArgs['hidden']) && $fieldArgs['hidden'])
					continue;
				// var_dump($this->fields[$fieldName],$fieldName);
				if($fieldArgs['type'] != "hidden")
				{
					//$content .= "<tr>\n";
					if($fieldArgs['type'] != "label"){
						$content .= "<div class=\"form-group\">\n";
						$content .= "<label class=\"control-label\">".$fieldArgs['label']."</label>\n<div class=\"controls\">";
					}
					switch($fieldArgs['type'])
					{

						case "label":
							$content .= "<div class=\"form-group\">\n";
							$content .= "<h3>".$fieldArgs['label']."</h3>\n";
						break;
						case "file":
							// $content .= "";
							// if($fieldArgs['value']){
								// $content .= '<a href="#" class="hide" id="field_'.$fieldName.'_link" target="_blank">Imagem atual</a>';
							// }
							$content .= "<input type='file'  data-type='file' class='form-control' name='".$fieldName."' id='field_".$fieldName."' /></div>\n";	
							$content .= '<a href="#" data-path="'.$fieldArgs['options']['path'].'" class="hide link-external" id="field_'.$fieldName.'_link" target="_blank">Imagem atual</a>';
						break;
						case "password":
							$content .= "<input class='form-control' data-type='password' type='password' name='".$fieldName."' id='field_".$fieldName."' value='".$fieldArgs['value']."' /></div>\n";
						break;
						case "button":
							$content .= "<input class='form-control ".$fieldArgs['classes']."' type='button' data-type='button' name='".$fieldName."' id='field_'".$fieldName."' value='".$fieldArgs['value']."' /></div>";
						break;
						case "link":
							$content .="<a href='".$fieldArgs['link']."' id='field_".$fieldName."' class='form-control data-type='link' ".$fieldArgs['classes']."'>".$fieldArgs['value']."</a></div>";
						break;
						case "textarea":
							$content .= "<textarea class='form-control' id='field_".$fieldName."' cols='40' data-type='textarea' rows='5' name='".$fieldName."'>".$fieldArgs['value']."</textarea></div>";
						break;

						case "editor":
							if($this->editor)
							{
								//$content .= "</tr><tr><td colspan='3'>";
								$content .= $this->editor_plugin->drawEditor($fieldName,$fieldArgs['value']);
								//$content .= "</td>";
							}
						break;
						case "select":
							if(isset($fieldArgs['options']) && $fieldArgs['options'] && is_array($fieldArgs['options']))
							{
								$content .= "<select data-type='select' name='".$fieldName."' id='field_".$fieldName."' class='form-control'>";
								$content .= "<option value=''>-- Selecione</option>";
								foreach($fieldArgs['options'] as $selectValue => $selectLabel)
								{
									$content .= "<option value='".$selectValue."' ";
									if($selectValue == $fieldArgs['value'])
									{
										$content .= " selected='selected' ";
									}
									$content .= ">".$selectLabel."</option>";
								}
								$content .= "</select></div>";
							}
						break;
						case "check":
							if(isset($fieldArgs['options']) && $fieldArgs['options'] && is_array($fieldArgs['options']))
							{
								$content .= "";
								foreach($fieldArgs['options'] as $selectValue => $selectLabel)
								{
									
									$content .= " <input type='checkbox' data-type='check' value='".$selectValue."' id='field_".$fieldName."' name='".$fieldName."' ";
									if($selectValue == $fieldArgs['value'])
									{
										$content .= " checked='checked' ";
									}
									$content .= " /> ".$selectLabel." ";
								}
								$content .= "</div>";
							}
						break;
						case "text":
						case "email":
						default:
							$content .= "<input class='form-control' data-type='default' type='text' name='".$fieldName."' id='field_".$fieldName."' value='".$fieldArgs['value']."' /></div>\n";	
						break;
					}	
					if($fieldArgs['type'] != "ckeditor")
						$content .= "<span class='error_field' id='field_".$fieldName."_error'></span>\n";
						
					$content .= "</div>\n";
				}else{
					$hidden .= "<input type='hidden' data-type='hidden' id='field_".$fieldName."' name='".$fieldName."' value='".$fieldArgs['value']."' />";
				}
			}
		}		
		$content .= "<div class='form-group no-padding'>
							<button type='submit' class='btn btn-success btn-sm' name='saveValues' value='Salvar'/>
						  		<span class='glyphicon glyphicon-file'></span>
						  		Salvar
							</button>
							<button type='button' class=' hide btn btn-info btn-sm new-form' name='' value='Novo'/>
						  		<span class='glyphicon glyphicon-file'></span>
						  		Novo Formulário
							</button>".$hidden."
					</div>";		
		$content .= "\n</form>";
		
		return array('titulo'=>$this->args['titulo'],'content'=>$content);	
	}
	
	public function getDataRequest()
	{
		if(!$this->fields)
			return false;
			
		$data = array();
		
		if($this->fields)
		{
			foreach($this->fields as $fieldKey => $fieldArgs)
			{
				if(isset($fieldArgs['hidden']) && $fieldArgs['hidden'])
					continue;
					
				switch($fieldArgs['type'])
				{
					case "text":
					case "hidden":
					case "password":
					case "textarea":
					case "email":
					case "editor":
					case "select":
						$varTmp = get_request($fieldKey, 'REQUEST');
						$varTmp = str_replace('\r', '', $varTmp);
						$varTmp = str_replace('\n', '', $varTmp);
						$data[$fieldKey] = emptyComplete($varTmp);
					break;	
					case "check":
						$varTmp = get_request($fieldKey, 'REQUEST');
						$data[$fieldKey] = $varTmp;
					case "file":
						if(isset($_FILES[$fieldKey]) && $_FILES[$fieldKey])
						{
							$data[$fieldKey] = $_FILES[$fieldKey];
						}
					break;
				}				
			}
		}
		return $data;
	}

	public function listData(){
		$content = "";	
		$content.='<div class="modal fade bs-example-modal-sm main-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">';
		$content.='  <div class="modal-dialog modal-sm">';
		$content.='    <div class="modal-content">';
		$content.='    	<div class="modal-header">';
		$content.='	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$content.='	        <h4 class="modal-title" id="gridSystemModalLabel">Informação</h4>';
		$content.='        </div>';
		$content.='    	<div class="modal-body">';
					    		
		$content.='    	</div>';
		$content.='    	<div class="modal-footer">';
		$content.='	        <button type="button" class="btn btn-danger first-btn-main-modal" data-dismiss="modal">Sair</button>';
		$content.='	        <button type="button" class="btn btn-primary second-btn-main-modal">Ok</button>';
		$content.='	    </div>';
		$content.='    </div>';
		$content.='  </div>';
		$content.='</div>';


		if(isset($this->data['main_title']) && $this->data['main_title'] != ""){
		
		$this->data['sub_title'] = (isset($this->data['sub_title']) ? $this->data['sub_title'] : '');
		
		$content .='<div class="row">';	
		$content .='	<div class="col-md-12">';
		$content .='		<div class="page-header">';
		$content .='			<h3>'.$this->data['main_title'].'<small>'.$this->data['sub_title'].'</small></h3>';
		$content .='		</div>	';
		$content .='	</div>';
		$content .='</div>';

		}
		
		$content .='	<div class="content-list-data">';
		$content .='		<div class="row">';
		$content .='			<div class="col-md-12">';


		
		if(isset($this->data['exportar']) && $this->data['exportar'] || isset($this->data['buscar']) && $this->data['buscar']){
			if(isset($this->data['exportar']) && $this->data['exportar']){
				load_js("encoding.js");
				load_js("encoding-indexes.js");
				load_js("fileSaver.js");	
			}			
			$content .=' 				<div class="row">';
			$content .='					<div class="col-md-12">';
			if(isset($this->data['exportar']) && $this->data['exportar']){
				$content .='						<button class="pull-right btn btn-sm btn-default btn-export" style="margin-bottom:5px;">';
				$content .='							<i class="glyphicon glyphicon-download-alt"></i> Exportar';
				$content .='						</button>';	
			}			
			if(isset($this->data['buscar']) && $this->data['buscar']){
				$content .='						<div class="col-md-3" style="padding:0;">';
				$content .='					      <input type="text" class="form-control input-sm input-search" style="margin-bottom:5px;" placeholder="Buscar por...">';
				$content .='					    </div>';	
			}			
			$content .='					</div>';
			$content .='				</div>';	
		}
		
		if(isset($this->data['content']) && is_array($this->data) && !empty($this->data)){
		$content .= '				<div class="panel-group panel-group-ssx-editor-construct" id="accordion" role="tablist" aria-multiselectable="true" data-edit-function-name="'.$this->data['ajax_edit_function_name'].'" data-delete-function-name="'.$this->data['ajax_delete_function_name'].'">';
				foreach($this->data['content']['fields'] as $data){
		$settings_content = self::getHeaderDataContentByContentArray($data);
		$content .=' 		<div class="panel panel-'.$settings_content['collapse'].' panel-id-'.$settings_content['id'].'">';
		$content .='	    	<div class="panel-heading" role="tab" id="heading'.$settings_content['id'].'">';
		$content .='	      	<h4 class="panel-title"> ';
								if(isset($settings_content['prefix_icon'])){
		$content .='				<span class="'.$settings_content['prefix_icon'].'"></span> &nbsp;';
								}
		$content .='	        	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$settings_content['id'].'" aria-expanded="true" aria-controls="collapse'.$settings_content['id'].'" style="font-size:13px;">';
		$content .='	         	'.$settings_content['titulo'];
		$content .='	        	</a>';
		$content .='	       	    <div class="pull-right">';
										if($settings_content['show_edit_header']){
		$content .='	        		<button class="btn btn-default edit btn-sm" value="'.$settings_content['id'].'">';
		$content .='						<i class="glyphicon glyphicon-edit"></i>';
		$content .='     			 	</button>';									
										}
										if($settings_content['show_trash_header']){								
		$content .='     			 	<button class="btn btn-default delete btn-sm" value="'.$settings_content['id'].'">';
		$content .='						<i class="glyphicon glyphicon-trash"></i>';
		$content .='					 </button>';
										}
		$content .='	        	</div>';
		$content .='	      	</h4>';
		$content .='	    	</div>';
		$content .='	    	<div id="collapse'.$settings_content['id'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$settings_content['id'].'">';
		$content .='		      <div class="panel-body">';
		$content .='	       			<div class="table-responsive">';
		$content .='	       			 <table class="table table-bordered table-ssx-editor-construct" data-id="'.$settings_content['id'].'">';
		$content .='					 	<tbody>';
										 		foreach($data as $row_table){
										 			
										 			if(isset($row_table['settings']) || isset($row_table['show_in_table']) && $row_table['show_in_table'] == false){

										 			}else if($row_table['tipo'] == 'hidden'){

										 			}else if($row_table['tipo'] == 'link'){
		$content .='								<tr>';
		$content .='									<td>'.$row_table['label'].'</td>';
		$content .='									<td class="fld-column" data-column-label="'.$row_table['label'].'" data-column="fld-'.$row_table['column'].'" data-column-type="'.$row_table['tipo'].'">';
		if(isset($row_table['options']['is_array']) && isset($row_table['options']['explode_delimiter'])){
			$explode_arr = explode($row_table['options']['explode_delimiter'], $row_table['value']);
			for($i=0;$i<count($explode_arr);$i++){
				if($i > 0){
				 	$content .= "<br>";
				}				
				$content .='<a href="'.str_replace(':value',$explode_arr[$i],$row_table['options']['path']).'" target="_blank">'.str_replace(':value',$explode_arr[$i],$row_table['options']['label']).'</a>';	
			}
		}else{
			$content .='<a href="'.str_replace(':value',$row_table['value'],$row_table['options']['path']).'" target="_blank">'.str_replace(':value',$row_table['value'],$row_table['options']['label']).'</a>';
		}			
		$content .='								</td>';
		$content .='								</tr>';
													}else if($row_table['tipo'] == 'imagem'){
		$content .='								<tr>';
		$content .='									<td>'.$row_table['label'].'</td>';
		$content .='									<td class="fld-column" data-column-label="'.$row_table['label'].'" data-column="fld-'.$row_table['column'].'" data-column-type="'.$row_table['tipo'].'"><a href="'.$row_table['options']['path'].$row_table['value'].'" target="_blank"> Imagem</a></td>';
		$content .='								</tr>';								 				
										 			}else if($row_table['tipo'] == 'texto_longo'){
		$content .='								<tr>';
		$content .='									<td colspan="2" align="center">'.$row_table['label'].'</td>';
		$content .='								</tr>';
		$content .='								<tr>';
		$content .='									<td colspan="2" align="left" class="fld-column" data-column-label="'.$row_table['label'].'" data-column="fld-'.$row_table['column'].'" data-column-type="'.$row_table['tipo'].'">'.$row_table['value'].'</td>';
		$content .='								</tr>';
													}else{
		$content .='								<tr>';
		$content .='									<td>'.$row_table['label'].'</td>';
		$content .='									<td class="fld-column" data-column-label="'.$row_table['label'].'" data-column="fld-'.$row_table['column'].'" data-column-type="'.$row_table['tipo'].'">'.$row_table['value'].'</td>';
		$content .='								</tr>';												
													}		
										 		}
										 			if($settings_content['show_edit_header'] != false || $settings_content['show_edit_footer'] != false){
		$content .='						 		<tr>';
		$content .='									<td colspan="2">';
															if($settings_content['show_edit_footer']){
		$content .='										<button class="btn btn-default edit btn-sm" value="'.$settings_content['id'].'">';
		$content .='											<i class="glyphicon glyphicon-edit"></i>';
		$content .='						     			 </button>';														
															}
															if($settings_content['show_trash_footer']){
		$content .='						     			 <button class="btn btn-default delete btn-sm" value="'.$settings_content['id'].'">';
		$content .='											<i class="glyphicon glyphicon-trash"></i>';
		$content .='										 </button>';														
															}		
		$content .='									</td>';
		$content .='								</tr>';
													}
		$content .='						</tbody>';
		$content .='					 </table>';
		$content .='			  	  </div>';
		$content .='			  </div>';
		$content .='	    	</div>';
		$content .='		</div>';   
				}
		$content .='				</div>';
		
		}else{
		
		$content .='				<h4>Não há dados cadastrados!</h4>';			
		
		}
		
		$content .='						</div>';
		$content .='					</div>';
		$content .='				</div>';
		
		load_js('SsxEditConstructV2.js');
		load_js('SsxEditConstructV2ScrollerTemplate.js');

		return $content;
	}

	public function getHeaderDataContentByContentArray($content=array()){
		$settings_content = array(
								"id" =>rand(),
			 					"titulo"=>"",
			 					"show_numbers"=>false,	
				 				"show_edit_header"=>true,
				 				"show_edit_footer"=>true,
				 				"show_trash_header"=>true,
				 				"show_trash_footer"=>true,
				 				"collapse"=>'default',
							);
		if(is_array($content) && !empty($content)){
			foreach ($content as $key => $value) {
				if(gettype($value) == 'array'){
					if($key == 'settings' || isset($value['settings']) && !empty($value['settings'])){
						$value = $value['settings'];
						$settings_content['id'] = (isset($value['id'])  && $value['id'] != ""
													? $value['id'] 
													: $settings_content['id']
													);
						$settings_content['titulo'] = (isset($value['titulo']) ? $value['titulo'] : $settings_content['titulo']);
						$settings_content['show_numbers'] = (isset($value['show_numbers']) ? $value['show_numbers'] : $settings_content['show_numbers']);
						$settings_content['show_edit_header'] = (isset($value['show_edit_header']) ? $value['show_edit_header'] : $settings_content['show_edit_header']);
						$settings_content['show_edit_footer'] = (isset($value['show_edit_footer']) ? $value['show_edit_footer'] : $settings_content['show_edit_footer']);
						$settings_content['show_trash_header'] = (isset($value['show_trash_header']) 
																	? $value['show_trash_header'] 
																	: $settings_content['show_trash_header']
																  );
						$settings_content['show_trash_footer'] = (isset($value['show_trash_footer']) 
																	? $value['show_trash_footer'] 
																	: $settings_content['show_trash_footer']
																 );
						$settings_content["collapse"] = (isset($value['collapse']) 
															? $value['collapse'] 
															: $settings_content['collapse']
														);
						$settings_content["prefix_icon"] = false;
						$settings_content["prefix_icon"] = (isset($value['prefix_icon']) 
															? $value['prefix_icon'] 
															: $settings_content['prefix_icon']
														);

					}
				}					
			}
			return $settings_content;	
		}
		return false;
	}

	public function constructArrayData($id_column_name=false,$titulo_column_name=false,$labels=array(),$tipos=array(),$settings=array()){
		
		$dados['data'] = $this->data;
		
		if(is_array($dados) && !empty($dados)){
			$i=0;
			foreach ($dados['data'] as &$dado) {
				if(is_array($dado) && !empty($dado)){
					$this->data['content']['fields'][$i] = [];
					foreach($dado as $key =>$value){
						switch ($key) {
							case $id_column_name:
								
								if(isset($_SESSION['ssx_edit_construct'])){
									unset($_SESSION['ssx_edit_construct']);
								}
								$_SESSION['ssx_edit_construct'][$this->table]['id_column_name'] = $id_column_name;
								$_SESSION['ssx_edit_construct'][$this->table]['title_column_name']= $titulo_column_name;

								$_settings = array(
							 					"settings"=>array(
									 					"id" =>$dado[$id_column_name],
									 					"titulo"=>$dado[$titulo_column_name],
									 					"show_numbers"=>true,
										 				"collapse"=>'default',
								 				)										 				
							 				);
								$this->data['content']['fields'][$i][] = $_settings;
								// var_dump($settings);
								// die();
								if(isset($settings['settings']) && is_array($settings['settings']) && !isset($settings['settings']['id'])){
									foreach ($settings['settings'] as $setting) {
										if($setting['id'] == 'all'){
											$setting['id'] = $value;
										}else{
											$setting['id'] = $setting['id'][array_search($value, $setting['id'])];	
										}
										if($setting['id'] == $value || $setting['id']){
											$this->data['content']['fields'][$i][] = array('settings'=>$setting);
										}	
									}
								}
								$this->data['content']['fields'][$i][] =  array(
													 			"value"=>$dado[$id_column_name],
													 			"label"=>"Id",
													 			"tipo"=>"id",
													 			"show_in_table"=>false
													 		);
								break;
							default:
								$label = '';
								$value = $dado[$key] != "" ? $dado[$key] : '--' ;
								if(isset($labels[$key]) && is_array($labels[$key]) && !empty($labels[$key])){
									foreach ($labels[$key] as $key2 => $value2) {
										if(isset($labels[$key]['label'])){
											$label[$key2] = $labels[$key]['label'];
										}
									}
								}
								if(isset($labels[$key])){
									$label = $labels[$key];
								}else{
									$label = ucwords($key);
								}
								$options= array();
								if(isset($tipos[$key])){
									$tipo = $tipos[$key];
									if(is_array($tipos[$key]) && isset($tipos[$key]['tipo'])){
										$tipo = $tipos[$key]['tipo'];
										$options = (isset($tipos[$key]['options']) ? $tipos[$key]['options'] : '');
									}
								}else{
									$tipo = 'texto';
								}
								$this->data['content']['fields'][$i][] =  array(
													 			"value"=>$value,
													 			"label"=>(is_array($label) ? $label['label']: $label),
													 			"tipo"=>$tipo,
													 			"column"=>$key,
													 			"options"=>$options,
													 		);
								break;
						}/*switch dado*/
					}/* for dado*/					
				}
				$i++;	
			}/* for dados*/
			return true;

		}
		return false;		
	}

	public function constructArrayArgsByDados($dados=array(),$args=array(),$labels_exceptions=array()){
		if(is_array($args) && !empty($args)){
			foreach ($dados as $dado){
				if(is_array($dado) && !empty($dado)){
					$i=0;
					foreach($dado as $key => $value){
						$this->args['fields'][$i]['field'] = $key;
						if(isset($labels_exceptions[$key]) && is_array($labels_exceptions[$key]) && !empty($labels_exceptions)){
							foreach ($labels_exceptions[$key] as $key2 => $value2) {
								$this->args['fields'][$i][$key2] = $labels_exceptions[$key][$key2];	
							}				
						}else if(isset($labels_exceptions[$key])){
							$this->args['fields'][$i]['label'] = $labels_exceptions[$key];	
						}else{
							$this->args['fields'][$i]['label'] = ucwords($key);
						}					
						$i++;
					}		
				}
			}			
		}
		return false;
	}

	public function redirectWithMessage($msg='',$status='',$redirect_path=''){
		if($msg && $status && $redirect_path){
			$dados['text'] = $msg;
			$dados['status'] = $status;
			$_SESSION['message'] = $dados;
			header("Location: ".$redirect_path);
			exit();
		}
		return false;
	}

	public function getArgsByTable($args,$labels_exceptions){
		if($this->table){
			$sql = "SHOW COLUMNS FROM ".$this->table;
			$q = $this->dbn->prepare($sql);
			$q->execute();
			$r = $q->fetchAll(PDO::FETCH_ASSOC);
			$r = $r ? $r : false;
			if(is_array($r) && !empty($r)){
				$i=0;
				foreach ($r as $field) {
					$key = $field['Field'];
					$this->args['fields'][$i]['field'] = $key;
					if(isset($labels_exceptions[$key]) && is_array($labels_exceptions[$key]) && !empty($labels_exceptions)){
						foreach ($labels_exceptions[$key] as $key2 => $value2) {
							$this->args['fields'][$i][$key2] = $labels_exceptions[$key][$key2];	
						}				
					}else if(isset($labels_exceptions[$key])){
						$this->args['fields'][$i]['label'] = $labels_exceptions[$key];	
					}else{
						$this->args['fields'][$i]['label'] = ucwords($key);
					}
					$i++;
				}
				if($args){
					foreach($args as $key => $value){
						$this->args[$key] = $value;
					}	
				}				
			}
		}		
	}

	public function constructValidator()
	{
		if(!is_array($this->fields))
			return false;
			
		$content = "function validForm()
					{
						 var submit = 1;
					";
		if($this->fields)
		{
			foreach($this->fields as $fieldName => $fieldArgs)
			{
				if(isset($fieldArgs['hidden']) && $fieldArgs['hidden'])
					continue;
				
				if($fieldArgs['required'])
				{
					$content .= "\n
					if(Ssx.isEmpty($('#field_".$fieldName."').val()))
						{
							submit = 0;
							$('#field_".$fieldName."_error').html('".$fieldArgs['error']."');
						}";
					if($fieldArgs['type'] == "email")
					{
						$content .= "else if(!Ssx.isEmail($('#field_".$fieldName."').val()))
						{
							submit = 0;
							$('#field_".$fieldName."_error').html('".$fieldArgs['email_error']."');
						}";
					}else if($fieldArgs['compare'] && isset($this->fields[$fieldArgs['compare']]))
					{
						$content .= "else if(!Ssx.isEquals($('#field_".$fieldName."').val(), $('#field_".$fieldArgs['compare']."').val()))
						{
							submit = 0;
							$('#field_".$fieldName."_error').html('Campo ".strtolower($this->fields[$fieldArgs['compare']]['label'])." e ".strtolower($fieldArgs['label'])." precisam ser iguais');
						}";
					}
					$content .= "else{
							$('#field_".$fieldName."_error').html('');
						}";
				}
			}
		}		
							
		$content .= "
						 if(submit)
						 	return true;
						 return false;
					}";
		return $content;
	}
}