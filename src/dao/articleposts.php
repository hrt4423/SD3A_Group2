<?php
  class DAO_post{

    private function dbConnect(){
      $pdo = new PDO('mysql:host=localhost;dbname=asoda;charset=utf8','root','root');
      return $pdo;
    }

    public function post () {
      $pdo=$this->dbConnect();
      $sql = "SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
      FROM posts 
      JOIN users ON posts.user_id = users.user_id
      LEFT JOIN goods ON posts.post_id = goods.post_id
      WHERE posts.post_category_id=2
      GROUP BY posts.post_id";
      $ps = $pdo->prepare($sql);
      $ps->execute();
      $search = $ps->fetchAll();
      //$count = count($search);
      return $search;
    }

    public function prof_post () {
      $id=$_SESSION['user_id'];
      $pdo=$this->dbConnect();
      $sql = "SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
      FROM posts 
      JOIN users ON posts.user_id = users.user_id
      LEFT JOIN goods ON posts.post_id = goods.post_id
      WHERE posts.post_category_id=2 AND users.user_id=?
      GROUP BY posts.post_id";
      $ps = $pdo->prepare($sql);
      $ps->execute([$id]);
      $search = $ps->fetchAll();
      //$count = count($search);
      return $search;

    }
  }

?>