<?php

class SsxDB{

	protected $table;
	protected $primaryKeyColumn;
	protected $whereField;
	protected $whereOperator;
	protected $whereValue;
	protected $whereConcat;
	protected $whereFull;
	protected $whereArray;
	protected $orderByField;
	protected $orderBySide;
	protected $orderByFull;
	protected $joinTable;
	protected $groupBy;
	protected $debugSql;
	protected $hasNext;
	protected $isNext;
	protected $page;
	protected $rowCount;
	protected $errorMessages;

	public function __construct($table=null,$primaryKeyColumn=null){

		$this->dbn = new PDO(
				"mysql:host=".SSX_DB_HOST.";dbname=".SSX_DB_DATABASE,
				SSX_DB_USER,
				SSX_DB_PASS,
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
		);

		if($table){
			self::setTable($table);
		}
		if($primaryKeyColumn){
			self::setPrimaryKeyColumn($primaryKeyColumn);
		}

	}

	public function setDbn($dbn){
		$this->dbn = $dbn;
	}
	
	public function getDbn(){
		return $this->dbn;
	}

	public function addWhereArray($value){
		$this->whereArray[] = $value;
	}

	public function setWhereArray($where_array){
		$this->whereArray = $where_array;
	}

	public function getWhereArray(){
		return $this->whereArray;
	}

	public function setWhereFull($where_full){
		$this->whereFull = $where_full;
	}

	public function getWhereFull(){
		return $this->whereFull;
	}

	public function setWhereConcat($where_concat){
		self::addWhereArray($where_concat);
		$this->whereConcat = $where_concat;
	}

	public function getWhereConcat(){
		return $this->whereConcat;
	}

	public function setOrderByField($order_by_field){
		$this->orderByField = $order_by_field;
	}

	public function getOrderByField(){
		return $this->orderByField;
	}

	public function setOrderBySide($order_by_side){
		$this->orderBySide = $order_by_side;
	}

	public function getOrderBySide(){
		return $this->orderBySide;
	}

	public function setOrderByFull($orderby_full){
		$this->orderByFull = $orderby_full;
	}

	public function getOrderByFull(){
		return $this->orderByFull;
	}

	public function setGroupBy($group_by){
		$this->groupBy = $group_by;
	}

	public function getGroupBy(){
		return $this->groupBy;
	}

	public function setIsNext($is_next){
		$this->is_next = $is_next;
	}

	public function getIsNext(){
		return $this->is_next;
	}

	public function setPage($page){
		$this->page = $page;
	}

	public function getPage(){
		return $this->page;
	}

	public function setHasNext($has_next){
		$this->hasNext = $has_next;
	}

	public function getHasNext(){
		return $this->hasNext;
	}

	public function setDebugSql($debug_sql){
		$this->debugSql = $debug_sql;
	}

	public function getDebugSql(){
		return $this->debugSql;
	}

	public function setJoinTable($join_table){
		$this->joinTable = $join_table;
	}

	public function getJoinTable(){
		return $this->joinTable;
	}

	public function setWhereOperator($where_operator){
		self::addWhereArray($where_operator);
		$this->whereOperator = $where_operator;
	}

	public function getWhereOperator(){
		return $this->whereOperator;
	}

	public function setWhereField($where_field){
		self::addWhereArray($where_field);
		$this->whereField = $where_field;
	}

	public function getWhereField(){
		return $this->whereField;
	}

	public function setWhereValue($where_value){
		self::addWhereArray($where_value);
		$this->whereValue = $where_value;
	}

	public function getWhereValue(){
		return $this->whereValue;
	}

	public function setTable($table){
		$this->table = $table;
	}

	public function getTable(){
		return $this->table;
	}

	public function setPrimaryKeyColumn($column){
		$this->primaryKeyColumn = $column;
	}

	public function getPrimaryKeyColumn(){
		return $this->primaryKeyColumn;
	}

	public function setRowCount($row){
		if($row){
			$this->rowCount = $row;
		}
		return false;
	}

	public function getRowCount(){
		return $this->rowCount;
	}

	public function setErrorMessages($error_messages){
		$this->errorMessages = $error_messages;
	}

	public function getErrorMessages(){
		return $this->errorMessages;
	}

	public function whereBuilder(){
		
		if(!empty($this->whereArray)){
			$whereString = '';
			foreach ($this->whereArray as &$value) {
				$whereString.= " ".$value." ";
			}			
			if($whereString){
				$whereString = " WHERE ".$whereString;
				self::setWhereFull($whereString);
			}
		}
		
	}

	public function insert($data=array(),$lastid=null){
		$campos = implode(", ", array_keys($data));
		$valores = "";
		$flag= true;
		foreach($data as $key => $value){
			if($flag){
				$valores .= '"'.$value.'"';
			}else{
				$valores .= ',"'.$value.'"';
			}
			$flag = false;
		}
		$sql="INSERT INTO ".self::getTable().
				"($campos)
			   VALUES
			   ($valores)";
		if(self::getDebugSql() == 1){
 			var_dump($sql);
 			die();
 		}
		$q = $this->dbn->prepare($sql);
		if(!$q->execute()){
				self::setErrorMessages($this->dbn->errorInfo());
       	return false;
		}else{
			if($lastid != null){
				$lastid = $this->dbn->lastInsertId();
				return $lastid;
			}
			return true;
		}

	}

	public function update($id,Array $data,$rowAffected=null){
		$campos = array();

		foreach ($data as $index => $values) {
			$array_special_char = array('CURRENT_TIMESTAMP','datetime(CURRENT_TIMESTAMP, "localtime")');
			if(is_int(array_search($values,$array_special_char))){
					$campos[] = "$index = $values";
			}else{
				  $campos[] = "$index = '$values'";
			}
		}

		$campos = implode(", ", $campos);
		$sql = " UPDATE ".self::getTable().
			   " SET
				 $campos
				 WHERE ".self::getPrimaryKeyColumn()." = ".$id."";

		if(self::getDebugSql()){
 			var_dump($sql);
 			die();
 		}

 		self::setWhereOperator(NULL);
		self::setWhereField(NULL);
		self::setWhereValue(NULL);
		self::setWhereArray(array());
		self::setWhereFull(NULL);

		$q = $this->dbn->prepare($sql);
		if(!$q->execute()){
			self::setErrorMessages($this->dbn->errorInfo());
			return false;
		} else {
			if($rowAffected != null){
				$rowAffected = $q->rowCount();
				return $rowAffected;
			}else{
				return true;
			}
		}

	}

	public function delete($id=null,$rowAffected=null){

		self::whereBuilder();

		$sql =" DELETE
			    FROM ".self::getTable()." ";

		// if(self::getJoinTable()){
		// 	$sql.= self::getJoinTable();
		// }

		// self::setJoinTable(NULL);

		$where_field = '';
		if(self::getWhereField()){
			$where_field = self::getWhereField();
		}

		$where_value = '';
		if(self::getWhereValue()){
			$where_value = self::getWhereValue();
		}

		$where_operator = '';
		if(self::getWhereOperator()){
			$where_operator = self::getWhereOperator();
		}

		$where_full = '';

		if(self::getWhereFull()){
			$where_full = self::getWhereFull();
		}

		if($where_full){
			$sql .= $where_full;
		}else if($where_field && $where_value){
			if($where_operator == 'LIKE'){
				$sql.= " WHERE ".$where_field." LIKE '%".$where_value."%' ";
			}else{
				$sql.= " WHERE ".$where_field." ".$where_operator."  '".$where_value."' ";
			}
		}else{
			if(self::getPrimaryKeyColumn()){
				$sql .= " WHERE ".self::getPrimaryKeyColumn()." = :id";	
			}			
		}

	    if(self::getDebugSql() == 1 || self::getDebugSql() == 2){
			var_dump($sql);
			die();
		}
		
		
		$q = $this->dbn->prepare($sql);
		if($where_field && $where_value){

		}else{
			if(self::getPrimaryKeyColumn()){
				$q->bindValue(':id',$id, PDO::PARAM_STR);	
			}
		}

		self::setWhereOperator(NULL);
		self::setWhereField(NULL);
		self::setWhereValue(NULL);
		self::setWhereArray(array());
		self::setWhereFull(NULL);

		if(!$q->execute()){
			self::setErrorMessages($this->dbn->errorInfo());
			return false;
		} else {
			if($rowAffected != null){
				$rowAffected = $q->rowCount();
				return $rowAffected;
			}else{
				return true;
			}
		}

	}

	public function find($id=null,$campos = array(),$where_field=false,$where_value=false,$where_operator='LIKE',$orderby=null,$orderbyside='ASC'){

		self::whereBuilder();
		
		$campos = ($campos != array() ? implode(", ",$campos) : "*");

		$sql = " SELECT
				 $campos
				 FROM ".self::getTable()." ";

		if(self::getJoinTable()){
			$sql.= self::getJoinTable();
		}

		self::setJoinTable(NULL);

		if(self::getWhereField()){
			$where_field = self::getWhereField();
		}

		if(self::getWhereValue()){
			$where_value = self::getWhereValue();
		}

		if(self::getWhereOperator()){
			$where_operator = self::getWhereOperator();
		}

		$where_full = '';

		if(self::getWhereFull()){
			$where_full = self::getWhereFull();
		}

		if($where_full){
			$sql .= $where_full;
		}else if($where_field && $where_value){
			if($where_operator == 'LIKE'){
				$sql.= " WHERE ".$where_field." LIKE '%".$where_value."%' ";
			}else{
				$sql.= " WHERE ".$where_field." ".$where_operator."  '".$where_value."' ";
			}
		}else{
			if(self::getPrimaryKeyColumn()){
				$sql .= " WHERE ".self::getPrimaryKeyColumn()." = :id";	
			}			
		}

		$orderby_full = '';
		if(self::getOrderByFull()){
			$orderby_full = self::getOrderByFull();
		}

		if(self::getOrderByField()){
			$orderby = self::getOrderByField();
		}

		if(self::getOrderBySide()){
			$orderbyside = self::getOrderBySide();
		}

		if($orderby_full){
			$sql .= " ORDER  BY {$orderby_full}";
		}else if($orderby){
			$sql .=" ORDER BY $orderby $orderbyside ";
		}

		self::setOrderByFull(NULL);
		self::setOrderByField(NULL);
		self::setOrderBySide(NULL);
		self::setWhereOperator(NULL);
		self::setWhereField(NULL);
		self::setWhereValue(NULL);
		self::setWhereArray(array());
		self::setWhereFull(NULL);
		
		$q = $this->dbn->prepare($sql);

		if($where_field && $where_value){

		}else{
			if(self::getPrimaryKeyColumn()){
				$q->bindValue(':id',$id, PDO::PARAM_INT);	
			}
		}

		if(self::getDebugSql() == 1 || self::getDebugSql() == 2){
			var_dump($sql);
			die();
		}

		$q = $this->dbn->prepare($sql);

		if($where_field && $where_value){

		}else{
			$q->bindValue(':id',$id, PDO::PARAM_INT);
		}

	  	$q->execute();
	  	$data = $q->fetch(PDO::FETCH_ASSOC);

		return $data ? $data : false;
	}

	public function findAll($campos = array(),$limit=30,$offset=0,$orderby=null,$orderbyside="ASC",$where_field=false,$where_value=false,$where_operator='LIKE'){

		self::whereBuilder();

		$campos = ($campos != array() ? implode(", ",$campos) : "*");

		if(!isset($orderby)){
			$orderby = self::getPrimaryKeyColumn();
		}

		if(self::getPage()){
			$offset = $page;
		}
		$this->dbn->query('SET SESSION group_concat_max_len = 100000;');

		$sql = "SELECT
				$campos
				FROM ".self::getTable()." ";
		
		if(self::getJoinTable()){
			$sql.= self::getJoinTable();
		}
		
		$sql_before_group = false;
		if(self::getGroupBy()){
			$sql_before_group = $sql;
			$sql .=" GROUP BY ".self::getGroupBy()." ";
		}

		if(self::getDebugSql() == 1){
			var_dump($sql);
			die();
		}
		
		$q = $this->dbn->prepare($sql);
		

		if(self::getGroupBy()){
			$sql = $sql_before_group;
		}

		if(self::getWhereField()){
			$where_field = self::getWhereField();
		}

		if(self::getWhereOperator()){
			$where_operator = self::getWhereOperator();
		}

		if(self::getWhereValue()){
			$where_value = self::getWhereValue();
		}

		$where_full = '';

		if(self::getWhereFull()){
			$where_full = self::getWhereFull();
		}

		if($where_full){
			$sql .= $where_full;
		}else if($where_field && $where_value){
			if($where_operator == 'LIKE'){
				$sql.= " WHERE ".$where_field." LIKE '%".$where_value."%' ";
			}else{
				$sql.= " WHERE ".$where_field." ".$where_operator."  ".$where_value." ";
			}
		}


		if(self::getGroupBy()){
			$sql .=" GROUP BY ".self::getGroupBy()." ";
		}

		self::setWhereOperator(NULL);
		self::setWhereField(NULL);
		self::setWhereValue(NULL);
		self::setJoinTable(NULL);
		self::setGroupBy(NULL);
		self::setWhereArray(array());
		self::setWhereFull(NULL);

		
		$orderby_full = '';
		if(self::getOrderByFull()){
			$orderby_full = self::getOrderByFull();
		}

		if(self::getOrderByField()){
			$orderby = self::getOrderByField();
		}

		if(self::getOrderBySide()){
			$orderbyside = self::getOrderBySide();
		}

		if($orderby_full){
			$sql .= " ORDER  BY {$orderby_full}";
		}else if($orderby){
			$sql .=" ORDER BY $orderby $orderbyside ";
		}

		self::setOrderByFull(NULL);
		self::setOrderByField(NULL);
		self::setOrderBySide(NULL);

		
		// var_dump($sql);
		// die();

		$q = $this->dbn->prepare($sql);
		$q->execute();
		self::setRowCount($q->rowCount());


		if($limit){
			$sql .=" LIMIT ".$limit." OFFSET ".$offset;
		}

		


		if(self::getDebugSql() == 2){
			var_dump($sql);
			die();
		}

		$q = $this->dbn->prepare($sql);
		$q->execute();
		$data = $q->fetchAll(PDO::FETCH_ASSOC);
		
		self::setHasNext(true);
	    if(($limit+$offset) >= self::getRowCount()){
				self::setHasNext(false);
	    }

		self::setIsNext(false);
		if($offset >= 1){
			self::setIsNext(true);
		}

		return $data ? $data : false;

	}

	public function executeSql($sql,$rowAffected=false){
        $q = $this->dbn->prepare($sql);
        if(!$q->execute()){
			self::setErrorMessages($this->dbn->errorInfo());
			return false;
		} else {
			if($rowAffected != null){
				$rowAffected = $q->rowCount();
				return $rowAffected;
			}else{
				return true;
			}
		}
	}
	
}