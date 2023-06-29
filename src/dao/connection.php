<?php
  class connection {
    public function dbConnect(){
      // DB接続情報
      $dsn = 'mysql:dbname=asoda;host=localhost';
      $user = 'root';
      $password = '';

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