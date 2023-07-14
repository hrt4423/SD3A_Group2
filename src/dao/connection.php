<?php
  class Connection {
    private $pdo;
    private $dsn = 'mysql:dbname=asoda;host=localhost';
    private $username = 'root';
    private $password = 'root';
    private $dbname = 'asoda';
    private $hostname = "localhost";


    public function __construct() {
      try{
        $this->pdo = new PDO($this->dsn, $this->username, $this->password);
      }catch (PDOException $e){
        print('Error:'.$e->getMessage());
        die();
      }
    }

    public function getPdo(){
      return $this->pdo;
    }

    public function getDsn(){
      return $this->dsn;
    }

    public function getUsername(){
      return $this->username;
    }

    public function getPassword(){
      return $this->password;
    }

    public function getDbname(){
      return $this->dbname;
    }

    public function getHostname(){
      return $this->hostname;
    }
    
    //こちらは古い仕様です。getPdo()を使ってください。※安全のため残しています。
    public function dbConnect(){
      // DB接続情報
      $dsn = 'mysql:dbname=asoda;host=localhost';
      $user = 'root';
      $password = 'root';

      try{
        $dbh = new PDO($dsn, $user, $password);
      }catch (PDOException $e){
        print('Error:'.$e->getMessage());
        die();
      }

      return $dbh;
    }
  }

?>