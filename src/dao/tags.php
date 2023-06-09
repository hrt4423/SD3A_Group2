<?php
  class DAO_tag{

    private function dbConnect(){
      $pdo = new PDO('mysql:host=localhost;dbname=asoda;charset=utf8','root','root');
      return $pdo;
    }

    public function tags () {
      $pdo=$this->dbConnect();
      $sql = "SELECT * FROM tags ";
      $ps = $pdo->prepare($sql);
      $ps->execute();
      $search = $ps->fetchAll();
      return $search;
    }
  }

?>