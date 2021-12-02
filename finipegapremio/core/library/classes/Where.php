<?php

class Where {

	private $whereArray = Array();
	private $wherefield;
	private $whereoperator='=';
	private $wherevalue;

	public function __construct($field=null,$value=null,$extra=null){

		if($field && $value){
			$this->addClause($field,$value,$extra);
		}	
	}

	public function initialize(){
		return new Where();
	}

	public function addClause($field=null,$value=null,$extra=null){
		$i = count($this->whereArray);
		$i++;
		$this->whereArray[$i]['field'] = $field;
		if($extra){
			$this->whereArray[$i]['operator'] = $value; // "CHECAR SE VALUE FAZER PARTE DOS OPERATOR"
			$this->whereArray[$i]['value'] = $extra;
		}else{
			$this->whereArray[$i]['operator'] = $this->whereoperator;
			$this->whereArray[$i]['value'] = $value;
		}	
		return $this;
	}

	public function whereConcat($concat=null){
		$i = count($this->whereArray);
		$i++;
		$this->whereArray[$i]['concat'] = $concat;
		return $this;
	}

	public function whereField($where_field){
		$this->wherefield = $where_field;
		return $this;
	}

	public function whereOperator($where_operator){
		$this->whereoperator = $where_operator;
		return $this;
	}

	public function whereValue($where_value){
		$this->wherevalue = $where_value;
		return $this;
	}

	public function setWhereArray($where_array= Array()){
		if(is_array($where_array)){
			$this->whereArray = $where_array;
			return $this;
		}else{
			throw new Exception('Where array variable needs be array type!');
		}
	}

	public function get(){
		if(!empty($this->whereArray)){
			$whereString = '';
			foreach ($this->whereArray as $where) {
				if(!isset($where['concat'])){
					if(strtolower($where['operator']) == 'like'){
						$where['value']  = "%".$where['value']."%";
					}
					$where['value'] = gettype($where['value']) == 'integer' ? $where['value'] : sprintf("'%s'",$where['value']);
					$whereString .= sprintf(' %s %s %s',$where['field'],$where['operator'],$where['value']);
				}else{
					$whereString .= sprintf(' %s ',$where['concat']);
				}
			}
			return sprintf('%s',$whereString);
		}
		return '';		
	}

}
