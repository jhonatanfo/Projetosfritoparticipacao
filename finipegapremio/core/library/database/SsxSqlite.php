<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0 Estável
 */


defined("SSX") or die;

class SsxSqlite
{
	private $error_show_warnings = true;
	private $error_die_application = true;
	
  	public $con;
  	private $host;
  
  public function SsxSqlite($path)
  {
    
  	register_shutdown_function( array( &$this, 'off' ) );
  	
  	if(defined('DB_ERROR_SHOW_WARNINGS'))
    	$this->error_show_warnings = (constant('DB_ERROR_SHOW_WARNINGS'))?true:false;
    	
    if(defined('DB_ERROR_DROP_APPLICATION'))
    	$this->error_die_application = (constant('DB_ERROR_DROP_APPLICATION'))?true:false;
  	
  	try
  	{
	    $this->host=$path;
	    
	    if(!file_exists($this->host))
	    	throw new Exception("Arquivo não encontrado");
	    
	    $this->con=@sqlite_open($this->host);
	    

	    if(!$this->con)
	    	throw new Exception(SSX_ERROR_DB_02);
	    
	   	    
	  	if(sqlite_last_error($this->con)){
	      throw new Exception(sqlite_last_error($this->con));
	    }
  	}catch(Exception $e)
  	{
  		$this->error($e->getMessage());
  	}

    
  }
    
    private function error($error)
 	{
 		if(!is_string($error))
 		    return;
 		    
 		if($this->error_show_warnings || $this->error_die_application)
 		{
 			print "SsxSqlite: " . $error;
 		}
 		
 		if($this->error_die_application)
 			die;
 	}

  public function getone($select){
    //Retorna a primeira linha de uma select passada
    //$select = self::antiInjection($select);
    
  	if(!$this->con)
  		return false;
  	
    if(!$select)
    {
      $this->error(SSX_ERROR_DB_04);
    }else if(!preg_match("/(select)/i",$select))
    {
      $this->error(SSX_ERROR_DB_04);
    } else 
    {
      $erro = "";
      
      $select .= " limit 0,1";//Limita a busca a apenas 1 resultado       
      $query = sqlite_query($this->con,$select);
      
      if(isset($query) && $rows=@sqlite_num_rows($query))
      {
        return sqlite_fetch_array($query,SQLITE_ASSOC);
      }
      else 
      {
        if(sqlite_last_error($this->con))
        {
          $msg = SSX_ERROR_DB_05."<br />".sqlite_last_error($this->con);
          $msg .= "<br />$select";
          $this->error($msg);          
        }
        return false;
      }
    }
   }
  public function get($select){
    //Retorna todas as linhas de um select
    //$select = comando sql
    //$select = self::antiInjection($select);
    
  	if(!$this->con)
  		return false;
    
    if(!$select)
      $this->error(SSX_ERROR_DB_04);  
    else
    {      

      $query = sqlite_query($this->con,$select);
      if(isset($query) && $rows=@sqlite_num_rows($query))
      {
        for($i=0;$i<$rows;$i++)
         $get[] = sqlite_fetch_array($query,SQLITE_ASSOC);
        return $get; 
      }
      else
      {
        if(sqlite_last_error($this->con))
        {
          $msg = SSX_ERROR_DB_05."<br />".sqlite_last_error($this->con);
          $msg .= "<br />$select"; 
          $this->error($msg);         
        }
        return false;
      }
    }
   }

  public function cmd($sql){
	if(!$this->con)
  		return false;
  	
    if(!$sql)
      $this->error(SSX_ERROR_DB_04);
    else
    {      
      if(sqlite_query($this->con,$sql))
        return true;
      else
      {
        $this->error(SSX_ERROR_DB_05."<br />".$sql."<br />".sqlite_last_error($this->con));
      }
    }
  }

  public function transaction()
  {
    /*Inicia uma transação*/
    //$this->cmd("set autocommit=0");
    if($this->cmd("start transaction"))
      return true;
    else
      return SSX_ERROR_DB_05;
  }

  public function commit()
  {
    if(!$this->cmd("commit"))
     return true;
    else
     return SSX_ERROR_DB_05."<br />".mysql_error();
  }

  public function rollback()
  {
    if(!$this->cmd("rollback"))
     return true;
    else
     return false;
  }

  public function off()
  {
    if(!$this->con)
    	return true;
    	
  	if(@sqlite_close($this->con) )
      return true;
    else
      return false;
  }
}
