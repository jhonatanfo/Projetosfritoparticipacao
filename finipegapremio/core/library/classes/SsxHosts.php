<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

defined("SSX") or die;

class SsxHosts
{
	public $user;
	public $pass;
	public $host;
	public $database;
	public $type;
	
	public function __construct($_user, $_pass, $_host, $_database, $_type)
	{
		$this->user = $_user; 
		$this->pass = $_pass; 
		$this->host = $_host; 
		$this->database = $_database;
		$this->type = $_type;
	}
}