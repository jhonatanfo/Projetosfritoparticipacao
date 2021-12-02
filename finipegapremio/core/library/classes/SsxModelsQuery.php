<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

defined("SSX") or die;

/**
 * Classe utilizada para montar dinamicamente uma query
 * Utilizando alguns campos padrões
 *
 */
class SsxModelsQuery
{
	private $_fields;
	
	private $_table;
	
	private $_command;
	
	private $_inner;
	
	private $_where;
	
	private $_and;
	
	private $_or;
	
	private $_order;
	
	private $_limit;
	
	public function __construct(){
		print "SsxModelsQuery::Em Contrução";
		unset($this);
	}
	

	public function &table($table_name, $prefix="")
	{
		$this->_table = $table_name;
		if($prefix)
			$this->_table .= " AS `".$prefix."`";
		return $this->saveChanges();
	}
	
	public function &select()
	{
		$this->_command = "SELECT";
		return $this->saveChanges();
	}
	
	public function &update()
	{
		$this->_command = "UPDATE";
		return $this->saveChanges();
	}
	
	public function &where($params)
	{
		$this->_where = "WHERE ";
		return $this->saveChanges();
	}
	
	
	private function &saveChanges(){return $this;}
	
	public function deploy()
	{
		
	}
}