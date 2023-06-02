<?php
  class DAO_post{

    private function dbConnect(){
      $pdo = new PDO('mysql:host=localhost;dbname=asoda;charset=utf8','root','root');
      return $pdo;
    }

    public function post () {
      $pdo=$this->dbConnect();
      $sql = "SELECT * FROM posts";
      $ps = $pdo->prepare($sql);
      $ps->execute();
      $search = $ps->fetchAll();
      //$count = count($search);
      return $search;
    }
  }

?>