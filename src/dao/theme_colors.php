<?php
  class DAO_post{

    private function dbConnect(){
      $pdo = new PDO('mysql:host=localhost;dbname=asoda;charset=utf8','root','root');
      return $pdo;
    }

    public function color_code ($color_name) {
      $pdo=$this->dbConnect();
      $sql = "SELECT * FROM thema_colors WHERE thema_color_name = $color_name";
      $ps = $pdo->prepare($sql);
      $ps->execute();
      $search = $ps->fetchAll();
      return $search;
    }
  }

  class themeColors{
    
  }
?>