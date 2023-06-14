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