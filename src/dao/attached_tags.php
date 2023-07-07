<?php
  class AttachedTags{
    private function dbConnect(){
      //データベースに接続
      $pdo = new PDO('mysql:host=localhost; dbname=asoda; charset=utf8',
                      'root', '');
      return $pdo;
    }

    public function getAttachedTagsByPostId($postId){
      $pdo = $this -> dbConnect();
      //SQLの生成
      $sql = "SELECT T.tag_name
              FROM attached_tags as AT
              INNER JOIN tags as T 
              ON AT.tag_id = T.tag_id
              WHERE post_id=?";
      //prepare:準備　戻り値を変数に保持
      $ps = $pdo -> prepare($sql);

      //”？”に値を設定する。
      $ps->bindValue(1, $postId, PDO::PARAM_INT); 

      //SQLの実行
      $ps->execute();
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      if(empty($result)){
        return '指定したIDに該当するデータはありません。';
      }else{
        return $result;
      } 
    }
  }
?>