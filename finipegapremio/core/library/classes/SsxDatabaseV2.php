<?php

use PDO;

class SsxDatabaseV2{

	public  $dbn = NULL;
	private $dbhost = SSX_DB_HOST;
	private $dbuser = SSX_DB_USER;
	private $dbpass = SSX_DB_PASS;
	private $dbname = SSX_DB_DATABASE;

	public function __construct(){

	}

	public function connect(){
		$this->dbn = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname;",$this->dbuser,$this->dbpass);
		$this->dbn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}

	public function getDbn(){
		return $this->dbn;
	}

}
