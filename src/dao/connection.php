<?php
  class Connection {
    private $pdo;
    private $dsn = 'mysql:dbname=LAA1417809-asoda;host=mysql215.phy.lolipop.lan';
    private $username = 'LAA1417809';
    private $password = '2023AsodaDB';
    private $dbname = 'LAA1417809-asoda';
    private $hostname = "mysql215.phy.lolipop.lan";


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