<?php
class DBConfig {

    var $host;
    var $user;
    var $pass;
    var $db;
    var $db_link;
    var $conn = false;
    var $persistant = false;
   
    public $error = false;

    public function config(){ // class config
        $this->error = true;
        $this->persistant = false;
    }
   
    function conn($host='localhost',$user='root',$pass='vertrigo',$db='smarty'){ // 
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;
       
        // Establish the connection.
        if ($this->persistant)
            $this->db_link = mysql_pconnect($this->host, $this->user, $this->pass, true);
        else
            $this->db_link = mysql_connect($this->host, $this->user, $this->pass, true);

        if (!$this->db_link) {
            if ($this->error) {
                $this->error($type=1);
            }
            return false;
        }
        else {
        if (empty($db)) {
            if ($this->error) {
                $this->error($type=2);
            }
        }
        else {
            $db = mysql_select_db($this->db, $this->db_link); // select db
            if (!$db) {
                if ($this->error) {
                    $this->error($type=2);
                }
            return false;
            }
            $this -> conn = true;
        }
            return $this->db_link;
        }
    }

    function close() { // close connection
        if ($this -> conn){ // check connection
            if ($this->persistant) {
                $this -> conn = false;
            }
            else {
                mysql_close($this->db_link);
                $this -> conn = false;
            }
        }
        else {
            if ($this->error) {
                return $this->error($type=4);
            }
        }
    }
   
    public function error($type=''){ //Choose error type
        if (empty($type)) {
            return false;
        }
        else {
            if ($type==1)
                echo "<strong>Banco de dados n??o encontrado</strong> ";
            else if ($type==2)
                echo "<strong>Erro: </strong> " . mysql_error();
            else if ($type==3)
                echo "<strong>erro</strong>";
            else
                echo "<strong>erro</strong>, sem conex??o !!!";
        }
    }
}