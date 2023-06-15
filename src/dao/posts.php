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
      WHERE posts.post_category_id=1
      GROUP BY posts.post_id";
      $ps = $pdo->prepare($sql);
      $ps->execute();
      $search = $ps->fetchAll();
      //$count = count($search);
      return $search;
    }

    public function post_detail ($id) {
      $pdo=$this->dbConnect();
      $sql ="SELECT * FROM posts WHERE post_id = $id";
      $ps = $pdo->prepare($sql);
      $ps->execute();
      $search = $ps->fetchAll();

      if (!empty($search)) {
        $userId = $search[0]['user_id'];
    
        // ユーザー名を取得するクエリを追加
        $userSql = "SELECT user_name FROM users WHERE user_id = :userId";
        $userPs = $pdo->prepare($userSql);
        $userPs->bindValue(':userId', $userId, PDO::PARAM_INT);
        $userPs->execute();
        $userSearch = $userPs->fetch();
    
        if (!empty($userSearch)) {
          $search[0]['user_name'] = $userSearch['user_name'];

          // goodテーブルのレコード数を取得するクエリを追加
            $goodSql = "SELECT COUNT(*) AS count FROM goods WHERE post_id = $id";
            $goodPs = $pdo->prepare($goodSql);
            $goodPs->execute();
            $goodSearch = $goodPs->fetch();

              if (!empty($goodSearch)) {
                $search[0]['good_count'] = $goodSearch['count'];
              }
        }
      }

      
      return $search;
    }

    public function post_return ($id){
      $pdo=$this->dbConnect();
      $sql ="SELECT * FROM posts WHERE destination_post_id = $id";
      $ps = $pdo->prepare($sql);
      $ps->execute();
      $coment = $ps->fetchAll();

      if (!empty($coment)) {
        $userId = $coment[0]['user_id'];
    
        // ユーザー名を取得するクエリを追加
        $userSql = "SELECT user_name FROM users WHERE user_id = :userId";
        $userPs = $pdo->prepare($userSql);
        $userPs->bindValue(':userId', $userId, PDO::PARAM_INT);
        $userPs->execute();
        $userSearch = $userPs->fetch();
    
        if (!empty($userSearch)) {
          $coment[0]['user_name'] = $userSearch['user_name'];
        }
      }

      // goodテーブルのレコード数を取得するクエリを追加
      $goodSql = "SELECT COUNT(*) AS count FROM goods WHERE post_id = $id";
      $goodPs = $pdo->prepare($goodSql);
      $goodPs->execute();
      $goodSearch = $goodPs->fetch();

      if (!empty($goodSearch)) {
        $coment[0]['good_count'] = $goodSearch['count'];
      }

      return $coment;
    }

    public function insertpost($id,$coment){
      $pdo = $this->dbConnect();
      $sql = "INSERT INTO posts (destination_post_id, post_detail) VALUES (:destination_post_id, :post_detail)";
      $ps = $pdo->prepare($sql);
      $ps->bindValue(':destination_post_id', $id, PDO::PARAM_INT);
      $ps->bindValue(':post_detail', $coment, PDO::PARAM_STR);
      if ($ps->execute()) {
        echo "データが正常に挿入されました";
      } else {
        echo "データの挿入中にエラーが発生しました: " . $ps->errorInfo()[2];
      }
    }
  }


?>