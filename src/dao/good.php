<?php
  class Good{
    //非推奨
    private function dbConnect(){
      $pdo = new PDO('mysql:host=localhost; dbname=asoda; charset=utf8',
                      'root', 'root');
      return $pdo;
    }

    //DB接続にはこちらの関数を推奨
    private function connect(){
      require_once('connection.php');
      $connection = new Connection;
      return $connection->dbConnect();
    }

    public function goodCount($postId){
      $pdo = $this -> connect();
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