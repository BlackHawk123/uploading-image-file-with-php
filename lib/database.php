<?php
  //Database class

  class Database{

    public $host   = DB_HOST;
    public $name   = DB_USER;
    public $pass   = DB_PASS;
    public $dbname = DB_NAME;

    public $link;
    public $error;


    public function __construct(){
      $this->connectDB();
    }

    private function connectDB(){
      $this->link = new mysqli($this->host,$this->name,$this->pass,$this->dbname);
      if (!$this->link) {
        $this->error = "Connection Failed.".$this->link->connect_error;
      }
    }

    //insert data
    public function insert($data){
      $insert_row = $this->link->query($data) or die($this->link->error.__LINE__);
      if ($insert_row) {
        return $insert_row;
      }else{
        return false;
      }
    }

    //select data
    public function select($data){
      $select = $this->link->query($data) or die($this->link->error.__LINE__);
      if ($select->num_rows > 0) {
        return $select;
      }else{
        return false;
      }
    }

    //Delete Data
    public function delete($data){
      $delete_row = $this->link->query($data) or die($this->link->error.__LINE__);
      if ($delete_row) {
        return $delete_row;
      }else{
        return false;
      }
    }

  }







 ?>
