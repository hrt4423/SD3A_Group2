<?php
  class DAO_post{

    private function dbConnect(){
      $pdo = new PDO('mysql:host=localhost;dbname=asoda;charset=utf8','root','root');
      return $pdo;
    }

    public function getAllQuestion () {
      $pdo=$this->dbConnect();
      $sql = "SELECT * FROM posts WHERE post_category_id = 1;";
      $ps = $pdo->prepare($sql);
      $ps->execute();
      $result = $ps->fetchAll();
      //$count = count($search);
      return $result;
    }
  }

?>