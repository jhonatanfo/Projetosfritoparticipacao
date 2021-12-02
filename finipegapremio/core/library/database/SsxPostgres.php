<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0 Estável
 */


defined("SSX") or die;

class SsxPostgres
{
	private $error_show_warnings = true;
	private $error_die_application = true;
	
  	public $con;
  	private $bd;
  	private $host;
  
  public function SsxPostgres($user,$pass,$bd,$host)
  {
    
  	register_shutdown_function( array( &$this, 'off' ) );
  	
  	if(defined('MYSQL_ERROR_SHOW_WARNINGS'))
    	$this->error_show_warnings = (constant('MYSQL_ERROR_SHOW_WARNINGS'))?true:false;
    	
    if(defined('MYSQL_ERROR_DROP_APPLICATION'))
    	$this->error_die_application = (constant('MYSQL_ERROR_DROP_APPLICATION'))?true:false;
  	
  	try
  	{
	  	$this->bd=$bd;
	    $this->host=$host;
	    
	    $port = 5432;
	    if(defined('SSX_DB_PORT') && SSX_DB_PORT)
	    {
	    	$port = constant('SSX_DB_PORT');
	    }
	    
	    $this->con=@pg_connect("host={$this->host} port=$port dbname={$this->bd} user=$user password=$pass");;
	    
	    if(!$this->con)
	    	throw new Exception(SSX_ERROR_DB_02);
	    
	    
	    
	  	if(pg_last_error($this->con)){
	      throw new Exception(pg_last_error($this->con));
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
 			print "SsxPostgres: " . $error;
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
      $query = pg_query($this->con,$select);
      
      if(isset($query) && $rows=@pg_num_rows($query))
      {
        return pg_fetch_assoc($query);
      }
      else 
      {
        if(pg_last_error($this->con))
        {
          $msg = SSX_ERROR_DB_05."<br />".pg_last_error($this->con);
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
      $query = pg_query($this->con,$select);
      if(isset($query) && $rows=@pg_num_rows($query))
      {
        for($i=0;$i<$rows;$i++)
         $get[] = pg_fetch_assoc($query);
        return $get; 
      }
      else
      {
        if(pg_last_error($this->con))
        {
          $msg = SSX_ERROR_DB_05."<br />".pg_last_error($this->con);
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
      if(pg_query($this->con,$sql))
        return true;
      else
      {
        $this->error(SSX_ERROR_DB_05."<br />".$sql."<br />".pg_last_error($this->con));
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
    	
  	if(@pg_close($this->con) )
      return true;
    else
      return false;
  }
  
  /**
   * Função descontinuada
   * 
   * @return string
   */
  static final function antiInjection($sql){
  		return $sql;
		
  		if (get_magic_quotes_gpc()) {
			$clean = mysql_real_escape_string(stripslashes($sql));
		}else{
			$clean = mysql_real_escape_string($sql);
		}
		return $clean;
  }
}
