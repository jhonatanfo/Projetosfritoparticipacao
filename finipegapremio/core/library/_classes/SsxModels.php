<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.5.0
 */

defined("SSX") or die;

class SsxModels extends SsxFilterDispatcher implements SsxModelsInterface
{
	/**
	 * Link de banco de dados
	 * @var SsxDatabase
	 */
	public $link;
	
	/**
	 * Todos os fields da tabela em questão
	 * @var array
	 */
	public $fields;
	
	public $table_name;
	
	public $prefix;
	
	// em contrução
	protected $primary_key = "id";
	
	/**
	 * Construtores
	 */
	public function __construct(){ SsxModels::super(); }
    public function SsxModels(){ SsxModels::super(); }
	
	protected function super()
	{
		global $Ssx;
		
		$link = $Ssx->link;
		if(!$link)
		{
			die("SSX MODEL: LINK NAO DEFINIDO");
		}
		$this->link = $link;
		
		if(!$this->table_name)
			die("SSX MODEL: TABELA NÃO DEFINIDA");
	}
	
	public function checkLink($link)
	{
		if(!$link)
		{
			die("SSX MODEL: LINK NAO DEFINIDO");
		}
		$this->link = $link;
	}
	
	public function saveValues($values,$generate_guid=true)
	{
		global $Ssx;
		if(!is_array($values))
		{
 			die("SSX: Dados inconsistentes a serem salvos");
 		}   
 		
 		if(isset($values['id']) && $values['id'])
 		{
 			if(!SsxModels::fillModule_d($values['id']))
 				unset($values['id']);
 		}

 		SsxModels::prepare($values);
 		
 		if(SsxModels::checkFieldExists('date_modified'))
 		{
 		   $values['date_modified'] = "now()";
        }
        
 		if(SsxModels::checkFieldExists('deleted'))
          $values['deleted']=isset($values['deleted']) && $values['deleted']?$values['deleted']:'0';    	
                
 		if(isset($values['id']) && $values['id'])
 		{
 		  $sql = "UPDATE ";
 		  $where = " WHERE id = '{$values['id']}'";	 		  
          $sql .= $this->table_name." SET ";
 		
 		  //Campos e seus respectivos valores
          $update = "";
         
   		  foreach($values as $field => $value)
   		  {
   		  	// so continua se o campo estiver listado no array fields
   		  	if(SsxModels::checkFieldExists($field))
   		  	{
	 			if($value != "now()")
	 			{ 			 
	 			  $update .= ", `$field` = '$value'";
	 			}else{
	 			  $update .= ", `$field` = $value ";	
	 			}
   		  	}	
   		  }        
          $update = substr($update,1); 
          $sql .= $update;
                 
 		}else
 		{ 		  
 		  
 		  $where = "";
 		  //Campos básicos: não precisam ser passados, uma vez que serão substituídos
 		  if(SsxModels::checkFieldExists('id'))
 		  { 
	 		  if($generate_guid)
	 		     $values['id'] = isset($values['id']) && $values['id']?$values['id']:SsxModels::create_guid();
	 		  else
	 		     $values['id'] = isset($values['id']) && $values['id']?$values['id']:"";
 		  }
 		  
 		  if(SsxModels::checkFieldExists('date_created'))
 		  {
 		     $values['date_created'] = "now()";
 		  }
 		  
 		  if(SsxModels::checkFieldExists('deleted'))
 		     $values['deleted'] = '0';	
          
          $fields="";
          foreach($values as $field => $value)
          {
	          	if(SsxModels::checkFieldExists($field))
	   		  	{            
			    	$fields .= ",$field";
	   		  	}
          } 
          
          $fields = substr($fields,1,strlen($fields)-1);
          $fields = "(".$fields;     
          $fields .= ")";

          $sql = "INSERT INTO {$this->table_name} ".$fields." VALUES("; 		  
         
          $insert = "";        
		  foreach($values as $field => $value){                           
              if(SsxModels::checkFieldExists($field))
              {  
              	  if(is_string($value))
				  	$value = trim($value);
					
	              if($value != "now()")
	              {
	                $insert .= " , '$value' ";                    
	              }else
	              {
	                $insert .= " , $value ";  
	              }
              	  
              }
          }
          $insert = substr($insert,2,strlen($insert)-2);
          $sql .= $insert;       
          $sql .= ");";
 		}    
 		
 		//Insere cláusula where
 		$sql .= $where; 		
 		$this->link->cmd($sql);
 		
 		
 		
 		if(empty($values['id']) && SsxModels::checkFieldExists('id'))
 		{
 			$GUID 		  = "SELECT LAST_INSERT_ID( `id` ) AS `last_id` FROM {$this->table_name} ORDER BY LAST_INSERT_ID( `id` ) DESC";
			$result 	  = $this->link->getone($GUID);
			
			$values["id"] = $result['last_id'];
 		}	
 		
 		if(isset($values['id']) && $values['id'])
 			return parent::dispatchFilter('ssx_saveValues', $values['id']);//Retorno ID do registro inserido ou alterado	
 		return true;
	}
	
	protected function prepare(&$data)
	{
		$user_id = SsxUsers::getUser(true);
		if(!$user_id)
			return;
		
		
		if(!isset($data['id']) || !$data['id'])
		{
			if(SsxModels::checkFieldExists('created_by'))
			{
				$data['created_by'] = $user_id;
			}
		}
		
		if(SsxModels::checkFieldExists('modified_by'))
		{
			$data['modified_by'] = $user_id;
		}

	}
	
	public function fill($id) {
		$sql = SsxModels::strFilterData(array(
										'AND'=>array(
		 										 array( 
		 											'field'=>'id',
		 										 	'compare'=>'=',
												 	'value'=>$id
		 										 )
											  )
									));
		return parent::dispatchFilter('ssx_fill',$this->link->getone($sql));
	}
	
	public function field_string($prefix_table="")
	{
		if(!$this->fields || !is_array($this->fields))
			return "*";
		
		if(!empty($prefix_table))
			$prefix_table = $prefix_table . ".";	
			
		$str = implode("`,".$prefix_table."`", $this->fields);
		return parent::dispatchFilter('ssx_field_string', $prefix_table."`".$str."`");
	}
	
	public function count($query=null)
	{
		$where = SsxModels::translateWhere($query);
		
		$inner = SsxModels::translateJoin($query);
		
		$prefix = "";
		if($this->prefix)
		{
			$prefix = " AS ". $this->prefix;
		}
		
		if($where)
		{
			$where = "WHERE ".$where;
		}
		
		$sql = "SELECT count( `id` ) AS `total` FROM {$this->table_name} ".$prefix." ".$inner." ".$where;
		return parent::dispatchFilter('ssx_count', $this->link->getone($sql));
	}
	
	protected function simpleWhere($args)
	{
		if(!$args || !is_array($args))
			return "";
			
		$where = "";
		
		if($args)
		{
			$kCount = 0;
			foreach($args as $queryField => $queryValue)
			{
				if($kCount == 0)	
					$where .= sprintf(" `%s` = '%s' ", $queryField, $queryValue);
				else
					$where .= sprintf(" AND `%s` = '%s' ", $queryField, $queryValue);
				$kCount=1;
			}
		}
		return parent::dispatchFilter('ssx_simplewhere', $where);
	}
	
	/**
	 * Retorna uma simples consulta de comparação de = apenas
	 * @param array $args
	 * @param boolean $one
	 * @example 
	 * $args = array(
	 * 	'name'=>'example',
	 * 	'email'=>'example@teste.com'
	 * );
	 */
	public function filterData($args="", $one=false)
	{
		$where = SsxModels::simpleWhere($args);
		
		if($where)
		{
			$where = "WHERE " . $where;
		}
		
		$fields_string = SsxModels::field_string();
		
		$sql = "SELECT {$fields_string} FROM {$this->table_name} ".$where;
		
		$sql = parent::dispatchFilter('ssx_filterdata_sql',$sql);
		
		if($one)
			$return = $this->link->getone($sql);
		else
			$return = $this->link->get($sql);
			
		return parent::dispatchFilter('ssx_filterdata',$return);
	}
	
	public function delete($params) 
	{
		if(!is_array($params))
			return;
			
		$sql = "DELETE FROM `". $this->table_name . "` ";
		
		if($params)
		{
			$sql .= "WHERE ";
			$kCount = 0;
			foreach($params as $key => $value)
			{
				if(SsxModels::checkFieldExists($key))
				{
					if($kCount == 0)
						$sql .= sprintf(" `%s` = '%s' ",$key,$value);
					else
						$sql .= sprintf(" AND `%s` = '%s' ",$key,$value);
						
					$kCount++;
				}
			}
		}
		return parent::dispatchFilter('ssx_delete',$this->link->cmd($sql));
	}
	
	public function deleteFlag($id)
	{
		return parent::dispatchFilter('ssx_deleteflag', SsxModels::saveValues(array('id'=>$id,'deleted'=>'1')));
	}
	
	public function definityDelete($id){
		return parent::dispatchFilter('ssx_definitydelete',SsxModels::delete(array('id'=>$id)));
	}
	
	/**
	 * Verifica se o campo existe na lista de fields
	 * @param string $field
	 */
	public function checkFieldExists($field)
	{
		$check = true;
		$aFields = array();
		
		if(is_string($field))
			$aFields = explode(',',$field);
			
		if(is_array($field))
			$aFields = $field;
		
		if($aFields && is_array($aFields) && count($aFields)>0)
		{
			foreach($aFields as $row)
			{
				if(array_search($row,$this->fields) === false)
					$check = false;
			}
			
			return parent::dispatchFilter('ssx_checkfieldexists',$check);
		}
		return false;
		
	}
	
	/**
	 * Monta uma paginação apartir de uma consulta ou parametros
	 * 
	 * @param array $params[opcional]
	 * @param int $limit
	 * @return array
	 */
	public function mountPagination($params=null, $limit)
	{
		$count = SsxModels::count($params);
		
		if($count && $count['total'] && $count['total']>$limit)
		{
			$pages = Math::Ceil($count['total'] / $limit); 
			
			$pg_arr = array();
			
			for($i = 0; $i < $pages; $i++)
			{
				$pg_arr[$i] = $i+1;
			}
			return parent::dispatchFilter('ssx_mountpagination',$pg_arr);
		}
		return false;
	}
	
	/**
	 * Monta paginação de paginação, sempre centralizando o 
	 * item da pagina em questão
	 * 
	 * @param array $pagination
	 * @param int $corner[opcional]
	 * @return array
	 */
	public function pg2pg($pagination, $corner=4, $page)
	{
		$page++;
		
		if(!is_array($pagination))
			return $pagination;
			
		$total = count($pagination);
		
		$view = ($corner * 2) + 1;
		if($view > $total)
			$view = $total;
		
		
		$max = $total - $page;
		
		if($max < 0)
			$max = 0;
		$min = $page-1;

		if($page > $corner && $page < $total-$corner)
		{
			if($max > $corner)
				$max = $corner;
				
			if($min > $corner)
				$min = $corner;
		}else{
			if($max > $min)
				$max = ($view-1)-$min;
			else
				$min = ($view-1)-$max;
		}
			
		$new_pg = array();

		
		$key = 0;
		for($i = $min; $i > 0; $i--)
		{
			$new_pg[$key] =  $pagination[(($page+1)-($i+1))-1];
			$key++;
		}
		
		$new_pg[$key] = $page;
		$key++;
		
		for($i = 0; $i < $max; $i++)
		{
			$new_pg[$key] = $pagination[($page+($i+1))-1];
			$key++;
		}
		
		
		return parent::dispatchFilter('ssx_pg2pg',$new_pg);
	}
	
	/**
	 * Trata o array para montar a string do banco de dados
	 * 
	 * @param $queryData array|nominal
	 * @return string
	 */
	protected function translateWhere($queryData)
	{
		if(!is_array($queryData))
			return "";
			
		$context = "";
		
		foreach($queryData as $queryKey => $queryItems)
		{
			if($queryKey == "AND" || $queryKey == "OR")
			{
				$kCount = 0;
				foreach($queryItems as $queryTableValues)
				{
					if($kCount == 0)
						$context .= sprintf(" %s %s '%s' ",$queryTableValues['field'],$queryTableValues['compare'],$queryTableValues['value']);
					else
						$context .= sprintf(" %s %s %s '%s' ",$queryKey,$queryTableValues['field'],$queryTableValues['compare'],$queryTableValues['value']);
					$kCount=1;
				}
			}
		}
		return parent::dispatchFilter('ssx_translatewhere',$context);
	}
	
	/**
	 * Trata o array para montar a string de Join da query
	 * @param array $queryData
	 * @return string
	 */
	protected function translateJoin($queryData)
	{
		if(!is_array($queryData))
			return "";
			
		$context = "";
		
		foreach($queryData as $queryKey => $queryItems)
		{
			if($queryKey == "JOIN")
			{
				$type = "INNER JOIN";
				if(isset($queryItems['type']) && $queryItems['type'])
				{
					switch($queryItems['type'])
					{
						case "inner":
							$type = "INNER JOIN";
						break;
						case "left":
							$type = "LEFT JOIN";
						break;
						default:
							$type = "JOIN";
						break;
					}
				}
				if(isset($queryItems['conditions']) && $queryItems['conditions'])
				{
					foreach($queryItems['conditions'] as $queryTableValues)
					{
						$px = $queryTableValues['prefix'];
						if(is_array($queryTableValues['field']))
						{
							$context .= $type . " `" . $queryTableValues['table'] . "` AS `" . $px . "` ON ";
							
							$k = 0;
							foreach($queryTableValues['field'] as $fieldKey => $fieldValue)
							{
								if($k > 0)
									$context .= " AND ";
								$context .= "`" . $px . "`.`" . $fieldKey . "` = ";
								if(is_string($fieldValue))
								{
									$context .= "'".$fieldValue."'";
								}else if(is_array($fieldValue))
								{
									foreach($fieldValue as $other => $other_value)
									{
										$context .= "`" .$other . "`.`".$other_value."`";
										break;
									}
								}
								$k++;
							}	
						}
					}
				}
			}
		}
		return parent::dispatchFilter('ssx_translatejoin',$context);
	}
	
	protected function translateFields($queryData)
	{
		if(!is_array($queryData))
			return SsxModels::field_string($this->prefix);
			
		$context = "";
		
		
		foreach($queryData as $queryKey => $queryItems)
		{
			if($queryKey == "fields")
			{
				$fields = array();
				foreach($queryItems as $queryTablePrefix => $queryTableValues)
				{
					if(is_array($queryTableValues))
					{
						foreach($queryTableValues as $queryFieldValue)
						{
							$fields[] = sprintf(" `%s` . %s ",$queryTablePrefix,$queryFieldValue);
						}
					}else
					{
						$fields[] = sprintf(" `%s` . %s ",$queryTablePrefix,$queryTableValues);
					}
				}
				$context .= implode(",",$fields);
			}
		}
		
		if(!$context)
		{
			$context .= SsxModels::field_string($this->prefix);
		}
		
		return parent::dispatchFilter('ssx_translatefields',$context);
	}
	
	
	public function strFilterData($queryData=null)
	{
		$fields = SsxModels::translateFields($queryData);
		
		$where = SsxModels::translateWhere($queryData);
		
		$inner = SsxModels::translateJoin($queryData);
		
		$prefix = "";
		if($this->prefix)
		{
			$prefix = " AS ". $this->prefix;
		}
		
		if($where)
		{
			$where = "WHERE ".$where;
		}
		
		$sql = "SELECT ".$fields." FROM {$this->table_name} ".$prefix." ".$inner." ".$where;
		
		return parent::dispatchFilter('ssx_strfilterdata',$sql);
	}

	public function getAll($order_by=null, $order_sort='ASC', $limit=0, $offset=0, $queryData=null){
		
		$sql = SsxModels::strFilterData($queryData);
		
		if($order_by)
			$sql .= " ORDER BY ".$order_by. " ".$order_sort;
			
		if(isset($limit) && $limit>0)
		{
			$offset = $limit * $offset;
			$sql .= " LIMIT ".$offset.",".$limit;
		}
		
		$sql = parent::dispatchFilter('ssx_sql_getall',$sql);
		
		return parent::dispatchFilter('ssx_getall',$this->link->get($sql));
	}
	
	public function encryptPassword($password)
	{
		// criptografia md5
		return parent::dispatchFilter('ssx_encryptpassword',md5($password));
	}
	/**
	 * Traz um ou mais resultados de uma consulta em expecífico apartir de uma query de parametros
	 * @param array $queryData
	 * @param boolean $one
	 * @example 
	 * $queryData = array(
	 * 	  'AND'=>array(
	 * 	  	array('field'=>'name', 'compare'=>'LIKE', 'value'=>'%example%'),
	 * 		array('field'=>'email', 'compare'=>'=', 'value'=>'example@teste.com'
	 *    )
	 * );
	 */
	public function getDatabyField($queryData, $one=false){
		
		$sql = SsxModels::strFilterData($queryData);
		
		$result = false;
		
		if($one)
			$result = $this->link->getone($sql);
		else
			$result = $this->link->get($sql);
		return parent::dispatchFilter('ssx_getdatabyfield',$result);
	}

    protected function fillModule_d($module_id){
    	$fields = SsxModels::field_string();
    	
    	$sql = "SELECT
 				 {$fields}
 				FROM 
 				  {$this->table_name}
 				WHERE
 				  id = '".$module_id."'		
 			   "; 			   
 		return parent::dispatchFilter('ssx_fillmodule_d',$this->link->getone($sql));
    }

    protected function create_guid(){
    	//Cria uma nova chave para ser gravada no banco de dados
        $microTime = microtime();
        list($a_dec, $a_sec) = explode(" ", $microTime);
      
        $dec_hex = sprintf("%x", $a_dec* 1000000);
        $sec_hex = sprintf("%x", $a_sec);
      
        SsxModels::ensure_length($dec_hex, 5);
        SsxModels::ensure_length($sec_hex, 6);              
      
        $guid = "";
        $guid .= $dec_hex;
        $guid .= SsxModels::create_guid_section(3);
        $guid .= '-';
        $guid .= SsxModels::create_guid_section(4);
        $guid .= '-';
        $guid .= SsxModels::create_guid_section(4);
        $guid .= '-';
        $guid .= SsxModels::create_guid_section(4);
        $guid .= '-';
        $guid .= $sec_hex;
        $guid .= SsxModels::create_guid_section(6);
      
        return $guid;
    }
    
    private function create_guid_section($characters){
    	$return = "";
        for($i=0; $i<$characters; $i++)   
          $return .= sprintf("%x", mt_rand(0,15));
        return $return;
    }
    
    private function ensure_length(&$string, $length){
    	$strlen = strlen($string);
	    if($strlen < $length)  
	          $string = str_pad($string,$length,"0");  
	    else if($strlen > $length)  
	          $string = substr($string, 0, $length);
    }
}