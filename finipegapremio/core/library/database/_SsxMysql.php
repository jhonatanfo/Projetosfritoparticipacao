<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.5
 */


defined("SSX") or die;

class SsxMysql
{
	private $error_show_warnings = true;
	private $error_die_application = true;
	
  	public $con;
  	private $bd;
  	private $host;
  
  public function SsxMysql($user,$pass,$bd,$host)
  {
    
  	register_shutdown_function( array( &$this, 'off' ) );
  	
  	if(defined('DB_ERROR_SHOW_WARNINGS'))
    	$this->error_show_warnings = (constant('DB_ERROR_SHOW_WARNINGS'))?true:false;
    	
    if(defined('DB_ERROR_DROP_APPLICATION'))
    	$this->error_die_application = (constant('DB_ERROR_DROP_APPLICATION'))?true:false;
  	
  	try
  	{
	  	$this->bd=$bd;
	    $this->host=$host;
	    $this->con=@mysql_connect($this->host,$user,$pass);
	    
	    if(!$this->con)
	    	throw new Exception(SSX_ERROR_DB_02);
	    
	    if(!mysql_select_db($this->bd,$this->con)){
	       throw new Exception(SSX_ERROR_DB_03);    
	   	}
	    
	    $encoding = constant('SSX_ENCODING');
	    $encoding = str_replace("-", "", $encoding);
	    $encoding = strtolower($encoding);
	    
	    mysql_set_charset($encoding, $this->con);
	    
	  	if(mysql_error()){
	      throw new Exception(mysql_error());
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
 			print "SsxMysql: " . $error;
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
      $query = mysql_query($select,$this->con);
      
      if(isset($query) && $rows=@mysql_num_rows($query))
      {
        return mysql_fetch_assoc($query);
      }
      else 
      {
        if(mysql_error())
        {
          $msg = SSX_ERROR_DB_05."<br />".mysql_error();
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
      $query = mysql_query($select,$this->con);
      if(isset($query) && $rows=@mysql_num_rows($query))
      {
        for($i=0;$i<$rows;$i++)
         $get[] = mysql_fetch_assoc($query);
        return $get; 
      }
      else
      {
        if(mysql_error())
        {
          $msg = SSX_ERROR_DB_05."<br />".mysql_error();
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
      if(mysql_query($sql,$this->con))
        return true;
      else
      {
        $this->error(SSX_ERROR_DB_05."<br />".$sql."<br />".mysql_error($this->con));
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
    if(@mysql_close($this->con) )
      return true;
    else
      return false;
  }
  
  static final function antiInjection($sql){
		if (get_magic_quotes_gpc()) {
			$clean = mysql_real_escape_string(stripslashes($sql));
		}else{
			$clean = mysql_real_escape_string($sql);
		}
		return $clean;
  }
}
