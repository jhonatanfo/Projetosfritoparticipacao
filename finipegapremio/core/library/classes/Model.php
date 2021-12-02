<?php

class Model{		

	private static $connection;
    private        $data;
	public         $idField              = NULL;
	public         $table                = NULL;
	protected      $fillableFields       = NULL;
    protected      $logTimestampOnInsert = NULL;
	protected      $logTimestampOnUpdate = NULL;    


	public function __construct(){

        if(!is_bool($this->logTimestampOnInsert)){
            $this->logTimestampOnInsert = false;
        }

        if(!is_bool($this->logTimestampOnUpdate)){
            $this->logTimestampOnUpdate = false;
        }

		if($this->table == null){
			$this->table = strtolower(get_class($this));
		}

		if($this->idField == null){
			$this->idField = "id";
		}
	}

	public function __set($key,$value){		
		if(is_null($this->fillableFields)){
			$this->data[$key] = $value;
		}else if(in_array($key, $this->fillableFields)){
			$this->data[$key] = $value;	
		}		
	}

	public function __get($key){
		if(isset($key) && !empty($key)){
			return $this->data[$key];
		}
		return false;
	}		

	public function __unset($key){
        if (isset($key)) {
            unset($this->data[$key]);
            return true;
        }
        return false;
    }

	public function getArrayData(){
		return $this->data;
	}

	public function getJsonData(){
		return json_encode($this->data);
	}

	public function save(){

        date_default_timezone_set('America/Recife');

        $newContent = $this->getArrayData();
        $saveType = null;

        if(isset($this->data[$this->idField])) {
            $saveType = 'update';
            $sets = array();
            foreach ($newContent as $key => $value) {
                if ($key === $this->idField || $key == 'data_criacao' || $key == 'data_alteracao'){
                    continue;
                }
                $sets[] = sprintf("%s = '%s'",$key,$value);
            }            
            if ($this->logTimestampOnUpdate == true) {
                $sets[] = sprintf("data_alteracao = '%s'",date('Y-m-d H:i:s'));
            }            
            $sql = sprintf("UPDATE %s SET %s WHERE %s = %s",
                                                            $this->table,
                                                            implode(', ', $sets),
                                                            $this->idField,
                                                            $this->data[$this->idField]
                          );

        }else{
            $saveType = 'insert';
            if ($this->logTimestampOnInsert == true) {
                $newContent['data_criacao'] = sprintf("%s",date('Y-m-d H:i:s'));
                $newContent['data_alteracao'] = sprintf("%s",date('Y-m-d H:i:s'));
            }
            $sql = sprintf("INSERT INTO %s (%s) VALUES (%s);",
                                                            $this->table,
                                                            implode(', ', array_keys($newContent)),
                                                            self::createValuesFromArray(array_values($newContent))
                           );
        }
        
        self::setConnection(DatabaseConnection::getInstance());
        if(self::$connection) {
            if($saveType == 'update'){
                $rowsAffected = self::$connection->exec($sql);
                return ($rowsAffected == 0 || $rowsAffected == 1) ? true : false;
            }else{
                self::$connection->exec($sql);    
                $lastInsertId = self::$connection->lastInsertId();    
                return $lastInsertId;
            }                      
        }else{
            throw new Exception("Não há conexão com Banco de dados!");
        }
    }

    public function createValuesFromArray($values=array()){
		if(is_array($values) && !empty($values)){
			$valuesStringPieces = [];
			foreach ($values as $value) {
				if(gettype($value) == 'string'){
					$valuesStringPieces[] = "'{$value}'";
				}elseif(gettype($value) == 'integer'){
					$valuesStringPieces[] ="{$value}";	
				}
			}
			if($valuesStringPieces){
				$valuesStringPieces = implode(',', $valuesStringPieces);
			}
			return $valuesStringPieces;
		}
		return false;
	}

	public static function find($parameter) {
       
        $class = get_called_class();
        $idField = (new $class())->idField;
        $table = (new $class())->table;
        
        $tableExplodeNamespace = explode('\\', $table);
        $table = $tableExplodeNamespace[count($tableExplodeNamespace) - 1];

        $sql =  sprintf("SELECT * FROM %s WHERE %s = %s ;", 
        										(is_null($table) ? strtolower($class) : $table), 
        										(is_null($idField) ? 'id' : $idField),
        										$parameter
        	    );

        self::setConnection(DatabaseConnection::getInstance());

        if (self::$connection) {
            $result = self::$connection->query($sql);
            if ($result) {
                $newObject = $result->fetchObject(get_called_class());
            }
            return $newObject;
        } else {
            throw new Exception("Não há conexão com Banco de dados!");
        }

    }

    public static function where($column,$value){
        
        $class = get_called_class(); 
        $table = (new $class())->table;
        
        $tableExplodeNamespace = explode('\\', $table);
        $table = $tableExplodeNamespace[count($tableExplodeNamespace) - 1];

         $sql =  sprintf("SELECT * FROM %s WHERE %s = '%s' ;", 
                                                (is_null($table) ? strtolower($class) : $table), 
                                                (is_null($column) ? 'id' : $column),
                                                (is_null($column) ? 'John' : $value)
                );

        self::setConnection(DatabaseConnection::getInstance());

        if (self::$connection) {
            $result = self::$connection->query($sql);
            if ($result) {
                $newObject = $result->fetchAll(PDO::FETCH_CLASS, get_called_class());
            }
            return $newObject;
        } else {
            throw new Exception("Não há conexão com Banco de dados!");
        }
    }

    public function delete() {

        if (isset($this->data[$this->idField])) {

            $sql = sprintf("DELETE FROM %s WHERE %s = %s;",
            											$this->table,
            											$this->idField,
            											$this->data[$this->idField]
            			   );

            self::setConnection(DatabaseConnection::getInstance());
            if (self::$connection) {
                return self::$connection->exec($sql);
            } else {
                throw new Exception("Não há conexão com Banco de dados!");
            }
        }
    }   

	public static function all( $output_type="object", $filter = '',$limit = 0, $offset = 0){

        $class = get_called_class();
        $table = (new $class())->table;

        $tableExplodeNamespace = explode('\\', $table);
        $table = $tableExplodeNamespace[count($tableExplodeNamespace) - 1];

        $sql = sprintf("SELECT * FROM %s %s %s %s ;", 
        									(is_null($table) ? strtolower($class) : $table), 
        									($filter !== '') ? sprintf(" WHERE %s",$filter) : "",
        									($limit > 0) ? sprintf(" LIMIT %s", $limit) : "",
        									($offset > 0) ? sprintf(" OFFSET %s",$offset) : ""
    		   );

        self::setConnection(DatabaseConnection::getInstance());

        if (self::$connection) {
            $result = self::$connection->query($sql);
            switch ($output_type) {
                case 'object':
                    return $result->fetchAll(PDO::FETCH_CLASS, get_called_class());
                    break;
                case 'array':
                    return $result->fetchAll(PDO::FETCH_ASSOC);
                    break;
                case 'json':
                    return json_encode($result->fetchAll(PDO::FETCH_ASSOC),true);
                    break;
                default:
                    return $result->fetchAll(PDO::FETCH_CLASS, get_called_class());
                    break;
            }            
        } else {
            throw new Exception("Não há conexão com Banco de dados!");
        }
    }

    public static function count($fieldName = '*',$filter = ''){
        
        $class = get_called_class();
        $table = (new $class())->table;
        
        $tableExplodeNamespace = explode('\\', $table);
        $table = $tableExplodeNamespace[count($tableExplodeNamespace) - 1];

        $sql =  sprintf("SELECT count(%s) as t FROM %s %s;",
        									$fieldName,
        									(is_null($table) ? strtolower($class) : $table),
        									($filter !== '') ? sprintf(" WHERE %s",$filter) : ""
    			);

         self::setConnection(DatabaseConnection::getInstance());

        if (self::$connection) {
            $q = self::$connection->prepare($sql);
            $q->execute();
            $a = $q->fetch(\PDO::FETCH_ASSOC);
            return (int) $a['t'];
        } else {
            throw new Exception("Não há conexão com Banco de dados!");
        }
        
    }

    public static function findFirst($filter = '',$output_type="object"){
        $first = self::all($output_type,$filter,$limit=1);
        return $first ? $first[0] : false;
    }
    
    public static function setConnection(PDO $connection){
    	self::$connection = $connection;
    }

    public function hasOne($model){
        
    }

    public function hasMany($model){
        
    }

    public function belongTo($model){
        
    }

}