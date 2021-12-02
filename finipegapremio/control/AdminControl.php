<?php


class AdminControl extends SsxDB{

	protected $dbn = NULL;


	public function __construct($table=null,$primaryKeyColumn=null)
	{
    
    parent::__construct();
    $this->setDbn(parent::getDbn());

    if($table){
			parent::setTable($table);
		}
		if($primaryKeyColumn){
			parent::setPrimaryKeyColumn($primaryKeyColumn);
		}

	}

  public function setDbn($dbn=null){
    if($dbn){
      $this->dbn = $dbn;
    }
  }
  

  public function getDbn(){
    return $this->dbn;
  }
  	
  
}