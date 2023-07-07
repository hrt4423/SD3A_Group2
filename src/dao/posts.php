<?php

  class DAO_post{

    private function dbConnect(){
      $pdo = new PDO('mysql:host=localhost;dbname=asoda;charset=utf8','root','');
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

    public function prof_post () {
      $id=$_SESSION['user_id'];
      $pdo=$this->dbConnect();
      $sql = "SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
      FROM posts 
      JOIN users ON posts.user_id = users.user_id
      LEFT JOIN goods ON posts.post_id = goods.post_id
      WHERE posts.post_category_id=1 AND users.user_id=?
      GROUP BY posts.post_id";
      $ps = $pdo->prepare($sql);
      $ps->execute([$id]);
      $search = $ps->fetchAll();
      //$count = count($search);
      return $search;

    }
    public function prof_kizi_post () {
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
    public function prof_coment_post () {
      $id=$_SESSION['user_id'];
      $pdo=$this->dbConnect();
      $sql = "SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
      FROM posts 
      JOIN users ON posts.user_id = users.user_id
      LEFT JOIN goods ON posts.post_id = goods.post_id
      WHERE posts.post_category_id=3 AND users.user_id=?
      GROUP BY posts.post_id";
      $ps = $pdo->prepare($sql);
      $ps->execute([$id]);
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
         // Retrieve all user information
         $userSql = "SELECT * FROM users WHERE user_id = :userId";
         $userPs = $pdo->prepare($userSql);
         $userPs->bindValue(':userId', $userId, PDO::PARAM_INT);
         $userPs->execute();
         $userSearch = $userPs->fetchAll();
    
        if (!empty($userSearch)) {
          $search[0]['user_info'] = $userSearch;

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

      return $coment;
    }

    public function pos_return($id){
      $pdo=$this->dbConnect();
      $sql ="SELECT * FROM posts WHERE destination_post_id = $id";
      $ps = $pdo->prepare($sql);
      $ps->execute();
      $coment = $ps->fetchAll();
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

    //記事、質問のみを返す, 該当するレコードがない場合は例外を返す
    public function searchPostsByKeyword($keyword){
      $pdo = $this -> dbConnect();
      //SQLの生成
      $sql = "SELECT P.* FROM posts as P 
              LEFT OUTER JOIN attached_tags as AT ON P.post_id = AT.post_id
              LEFT OUTER JOIN tags as T ON AT.tag_id = T.tag_id
              WHERE (P.post_title LIKE ? OR
              P.post_detail LIKE ? OR
              T.tag_name LIKE ?)
              AND post_category_id != 3;
              ";
      //prepare:準備　戻り値を変数に保持
      $ps = $pdo -> prepare($sql);

      //”？”に値を設定する。
      $ps->bindValue(1, "%$keyword%", PDO::PARAM_STR); 
      $ps->bindValue(2, "%$keyword%", PDO::PARAM_STR); 
      $ps->bindValue(3, "%$keyword%", PDO::PARAM_STR); 

      //SQLの実行
      $ps->execute();
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      if(empty($result)){
        throw new Exception('キーワードに該当する投稿はありませんでした');
      }else{
        return $result;

      }
    }
  }



?>