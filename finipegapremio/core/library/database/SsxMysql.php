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
  
  public function __construct($user,$pass,$bd,$host)
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
//      $this->con=@mysql_connect($this->host,$user,$pass);
      
      $this->dbn = new PDO(
          "mysql:host=".SSX_DB_HOST.";port=3306;charset=utf8;dbname=".SSX_DB_DATABASE,
          SSX_DB_USER,
          SSX_DB_PASS      
      );
      $this->dbn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


      if(/*!$this->con*/!$this->dbn)
        throw new Exception(SSX_ERROR_DB_02);
      
      // if(!mysql_select_db($this->bd,$this->con)){
      //    throw new Exception(SSX_ERROR_DB_03);    
      // }
      
      $encoding = constant('SSX_ENCODING');
      $encoding = str_replace("-", "", $encoding);
      $encoding = strtolower($encoding);
      
      //mysql_set_charset($encoding, $this->con);
      
      // if(mysql_error()){
      //   throw new Exception(mysql_error());
      // }
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
    
    if(!$select){
      
      $this->error(SSX_ERROR_DB_04);

    }else if(!preg_match("/(select)/i",$select))   {
      
      $this->error(SSX_ERROR_DB_04);

    } else {
      $erro = "";
      
      $select .= " limit 0,1";//Limita a busca a apenas 1 resultado       
      $query = $this->dbn->prepare($select);
      
      if(!$query){
        $errors = $this->dbn->errorInfo();
        $erro_str  = '';
        for($i=0;$i <count($errors);$i++){
          $error_str[$i] .= $errors[$i];
        }
        return $error_str;
      }

      $query->execute();
      if(isset($query) && $rows=$query->rowCount())  {
        return $query->fetch(PDO::FETCH_ASSOC);
      }      
      return false;

    }
   }
  public function get($select){
    //Retorna todas as linhas de um select
    //$select = comando sql
    //$select = self::antiInjection($select);
    
    if(!$select){
    
      $this->error(SSX_ERROR_DB_04);    
    
    }else{      

      $query = $this->dbn->prepare($select);
      if(!$query){
        $errors = $this->dbn->errorInfo();
        $erro_str  = '';
        for($i=0;$i <count($errors);$i++){
          $error_str[$i] .= $errors[$i];
        }
        return $error_str;
      }

      $query->execute();
      
      if(isset($query) && $rows=$query->rowCount()){
        
        for($i=0;$i<$rows;$i++){
          $get[] = $query->fetch(PDO::FETCH_ASSOC);
        }
        return $get; 

      }
      return false;
    }

  }

  public function cmd($sql){
    if(!$sql){
      $this->error(SSX_ERROR_DB_04);
    }else{      
      $query = $this->dbn->prepare($sql);
      if($query->execute()){
        return true;
      }else{
        $this->error(SSX_ERROR_DB_05."<br />".$sql."<br />");
      }
    }

  }

  public function transaction(){
    /*Inicia uma transação*/
    $this->cmd("set autocommit=0");
    if($this->cmd("start transaction")){
      return true;
    }else{
      return SSX_ERROR_DB_05;
    }
  }

  public function commit(){
    if(!$this->cmd("commit"))
     return true;
    else
     return SSX_ERROR_DB_05."<br />";
  }

  public function rollback(){
    if(!$this->cmd("rollback"))
     return true;
    else
     return false;
  }

  public function off(){
    // if(@mysql_close($this->con) )
    //   return true;
    // else
    //   return false;
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
