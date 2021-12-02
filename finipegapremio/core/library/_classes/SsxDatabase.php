<?php 
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 */

defined("SSX") or die;

class SsxDatabase {
	
	private $db_type;
	private $link;
	private $host;
	private $database;
	private $auto;
	
	/**
	 * Armazena qual foi o ultimo comando sql executado
	 * @var string
	 */
	public $last_query;
	
	public function SsxDatabase(SsxHosts $Hosts,$transation=true){
		
		$host = $Hosts->host;
		$user = $Hosts->user;
		$pass = $Hosts->pass;
		$database = $Hosts->database;
		$type = $Hosts->type;
		
		
		$this->host=$host;  
      	$this->database=$database;
      	$this->db_type=$type;
      	
      	$this->link=$this->createLink($host,$user,$pass,$database, $type);   
		
      	$this->auto = false;  
      	
		if($this->link)
		{
	        if(isset($transation))
	        {
	 	      $this->auto=true;
	  	    }else
	  	    {
		      $this->auto=false;
		    }        
       		return true;
        }else{
        	return false;        
        } 
	}
	
	private function createLink($host,$user="",$pass="",$database, $type)
	{
		$link;
		switch($type){
			case "mysql":
				require_once(LIBPATH . "database/SsxMysql.php");
				$link = new SsxMysql($user,$pass,$database,$host);
		    break;
		    case "mysqli":
				require_once(LIBPATH . "database/SsxMysqli.php");
				$link = new SsxMysqli($user,$pass,$database,$host);
		    break;
		    case "postgres":
				require_once(LIBPATH . "database/SsxPostgres.php");
				$link = new SsxPostgres($user,$pass,$database,$host);
		    break;
		    case "sqlite":
		    	require_once(LIBPATH . "database/SsxSqlite.php");
		    	$link = new SsxSqlite($host);
		    break;
			default:
				die(SSX_ERROR_DB_01);
			break;
		}
		return $link;
	}
	
	public function check_connection()
	{
		if(!$this->link || !$this->link->con)
			return false;
		return true;		
	}
	
	public function get($sql)
	{   
	  if(!is_string($sql))
		die(SSX_ERROR_DB_04);
		
      //Retorna array com todos os resultados         
      $sql = $this->convertData($sql);
      if(!preg_match("/(select|show)/i",$sql))
      {
        die(SSX_ERROR_DB_04);
      } 

      $this->last_query = $sql;
      
      return $this->link->get($sql);
    }
    
	public function getone($sql){
	  if(!is_string($sql))
		die(SSX_ERROR_DB_04);	
		
      //Retorna uma linha de uma consulta
      $sql = $this->convertData($sql);
      
      if(!preg_match("/(select)/i",$sql))
      {
        die(SSX_ERROR_DB_04);
      }
      
      $this->last_query = $sql;
      
      return $this->link->getone($sql);
    }
    
	public function cmd($sql){ 
	  if(!is_string($sql))
		die(SSX_ERROR_DB_04);
		
      $sql = $this->convertData($sql);  

      $this->last_query = $sql;
      
      if($this->auto)
      {
        $this->link->transaction();
        
        $cmd = $this->link->cmd($sql); 
               
	    if($cmd)
	    {	      
	      return $this->link->commit();
	    }else
	    {
	      return $this->link->rollback();
	    } 
      }else
      {        
        return $this->link->cmd($sql);
      }
    }
	
    
	public function commit()
	{
	      return $this->link->commit();
	}

    public function transaction()
    {
      return $this->link->transaction();
    }
    
    public function rollback()
    {
      return $this->link->rollback();
    }

    public function off()
    {
      return $this->link->off();
    }
    
    private function convertData($sql){     	
    	if($this->db_type=="mssql")
    	{
    		    	
    	  // Substitui datetimes 
    	  $sql = str_replace("now()","GETDATE()",$sql);    	        	  
    	  $sql = str_replace("\'GETDATE()\'","GETDATE()",$sql);   	  
    	
        }else if($this->db_type=="sqlite")
        {
        	$sql = str_replace("`","",$sql);    	        	  
        }
    	    	    	    	
    	return $sql;
    }
}