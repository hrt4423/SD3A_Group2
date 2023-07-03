<?php
  class Good{
    private function dbConnect(){
      //データベースに接続
      $pdo = new PDO('mysql:host=localhost; dbname=asoda; charset=utf8',
                      'root', '');
      return $pdo;
    }

    public function goodCount($postId){
      $pdo = $this -> dbConnect();
      //SQLの生成
      $sql = "SELECT count(post_id) FROM goods WHERE post_id=?";

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
        return $result[0]['count(post_id)'];
      } 
    }

    public function insertgood($user_id,$post_id){
      $pdo = $this->dbConnect();
      $sql = "INSERT INTO goods (user_id,post_id) VALUES (?, ?)";
      $ps = $pdo->prepare($sql);
      $ps->bindValue(1, $user_id, PDO::PARAM_INT);
      $ps->bindValue(2, $post_id, PDO::PARAM_INT);
      if ($ps->execute()) {
        return  "データが正常に挿入されました";
      } else {
        return  "データの挿入中にエラーが発生しました: " . $ps->errorInfo()[2];
      }
    }
    
  }
?>