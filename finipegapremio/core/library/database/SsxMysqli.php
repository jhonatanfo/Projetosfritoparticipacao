<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @since 18/06/2012
 * @version 1.0
 */


defined("SSX") or die;

class SsxMysqli
{
	private $error_show_warnings = true;
	private $error_die_application = true;
	
    private $host;
    /**
     * 
     * @var mysqli
     */
    private $connection;
    
    public function SsxMysqli($user , $pass, $db, $host)
    {
    	register_shutdown_function( array( &$this, 'off' ) );
    	
    	if(defined('MYSQL_ERROR_SHOW_WARNINGS'))
    		$this->error_show_warnings = (constant('MYSQL_ERROR_SHOW_WARNINGS'))?true:false;
    		
    	if(defined('MYSQL_ERROR_DROP_APPLICATION'))
    		$this->error_die_application = (constant('MYSQL_ERROR_DROP_APPLICATION'))?true:false;
    	
    	
    	try
    	{
    		$this->connection = @new mysqli($host, $user, $pass);
    	
    		if($this->connection->connect_errno)
	    	{
	    		throw new Exception(SSX_ERROR_DB_02);
	    	}
	    	
	    	if(!$this->connection->select_db($db))
	    	{
	    		 throw new Exception(SSX_ERROR_DB_03); 
	    	}
	    	
	    	$encoding = constant('SSX_ENCODING');
	    	$encoding = str_replace("-", "", $encoding);
	    	$encoding = strtolower($encoding);
	    	
	    	$this->connection->set_charset($encoding);
	    	
	    	
    	}catch(Exception $e)
    	{
    		$this->connection = null;
    		$this->error($e->getMessage());
    	}
    }
    
 	private function error($error)
 	{
 		if(!is_string($error))
 		    return;
 		    
 		if($this->error_show_warnings || $this->error_die_application)
 		{
 			print "SsxMysqli: " . $error;
 		}
 		
 		if($this->error_die_application)
 			die;
 	}
 	
 	public function getone($sql)
 	{
 		if(!$this->connection)
 			 $this->error(SSX_ERROR_DB_05);
 			 
 		if(!$sql)
 		{
	         $this->error(SSX_ERROR_DB_04);
	    }else if(!preg_match("/(select)/i",$sql))
	    {
	     	 $this->error(SSX_ERROR_DB_04);
	    } else {
		      $erro="";
		      if(strpos($sql, "LIMIT 0,1") === false && strpos($sql, "LIMIT 1"))
		      	$sql .= " LIMIT 0,1";//Limita a busca a apenas 1 resultado   
	
		      /**
		       * @var mysqli_result
		       */
		      $query = $this->connection->query($sql);
		      
		      if(isset($query) && $query && $query->num_rows)
		      {
		         return $query->fetch_assoc();
		      }else 
		      {
		        if($this->connection->error)
		        {
		          $msg = SSX_ERROR_DB_05."<br />".$this->connection->error;
		          $msg .= "<br />$sql";
		          $this->error($msg);          
		        }
		        return false;
		      }
    	}	 
 	}
 	
 	public function get($sql)
 	{
 		if(!$this->connection)
 			 $this->error(SSX_ERROR_DB_05);
 		
	 	if(!$sql)
	 	{
	      $this->error(SSX_ERROR_DB_04);  
	 	}else
	    {    
	      /**
	       * @var mysqli_result
	       */  
	      $query = $this->connection->query($sql);
	      
	      if(isset($query) && $query && $rows=$query->num_rows)
	      {
	        for($i=0;$i<$rows;$i++)
	         $get[] = $query->fetch_assoc();
	        return $get; 
	      }
	      else{
	        if($this->connection->error){
	          $msg = SSX_ERROR_DB_05."<br />".$this->connection->error;
	          $msg .= "<br />".$sql; 
	          $this->error($msg);         
	        }
	        return false;
	      }
	    }
 	}
 	
  public function cmd($sql)
  {
    if(!$sql)
      $this->error(SSX_ERROR_DB_04);
    else
    {      
      if($this->connection->query($sql))
        return true;
      else
      {
        $this->error(SSX_ERROR_DB_05."<br />".$sql);
      }
    }
  }
  
  public function transaction(){
    /*Inicia uma transação*/
    $this->cmd("set autocommit=0");
    if($this->cmd("start transaction"))
      return true;
    else
      return SSX_ERROR_DB_05;
  }

  public function commit(){
    if(!$this->cmd("commit"))
     return true;
    else
     return SSX_ERROR_DB_05."<br />".mysql_error();
  }

  public function rollback(){
    if(!$this->cmd("rollback"))
     return true;
    else
     return false;
  }
 	
  public function off(){
  	if(!$this->connection)
 		$this->error(SSX_ERROR_DB_05);
  	
    if(@$this->connection->close())
      return true;
    else
      return false;
  }
}
