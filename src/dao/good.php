<?php
  class Good{
    private $pdo;

    public function __construct() {
      require_once('connection.php');
      $connection = new Connection;
      $this->pdo = $connection->getPdo();
    }

    // //非推奨
    // private function dbConnect(){
    //   $pdo = new PDO('mysql:host=localhost; dbname=asoda; charset=utf8',
    //                   'root', 'root');
    //   return $pdo;
    // }

    // //DB接続にはこちらの関数を推奨
    // private function connect(){
    //   require_once('connection.php');
    //   $connection = new Connection;
    //   return $connection->dbConnect();
    // }

    public function goodCount($postId){
      $pdo = $this -> pdo;
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

    public function insertgood($user_id,$post_id,$user_point_id){
      $pdo = $this->pdo;
      $sql = "INSERT INTO goods (user_id,post_id) VALUES (?, ?)";
      $sqlUpdatePoints = "UPDATE users SET user_point = user_point + 20, point_sum = point_sum + 20 WHERE user_id = ?";

      $ps = $pdo->prepare($sql);
      $ps->bindValue(1, $user_id, PDO::PARAM_INT);
      $ps->bindValue(2, $post_id, PDO::PARAM_INT);

      $psUpdatePoints = $pdo->prepare($sqlUpdatePoints);
      $psUpdatePoints->bindValue(1, $user_point_id, PDO::PARAM_INT);
      try{
      if ($ps->execute()) {
        
        // 重複エラーが発生した場合にエラーコードが返る可能性があるため、ここで明示的に例外をスローする
        if ($ps->rowCount() == 0) {
          throw new Exception("データの挿入中に重複エラーが発生しました");
        }else{
          $psUpdatePoints->execute();
        }
        $url = 'question-detail.php?post_id=' . urlencode($post_id);
        header('Location: ' . $url);
        exit; // リダイレクト後にスクリプトの実行を終了する
      } else {
        throw new Exception("データの挿入中に重複エラーが発生しました");
      }
    } catch (Exception $e) {

      $url = 'question-detail.php?post_id=' . urlencode($post_id);
      header('Location: ' . $url);
      exit; // リダイレクト後にスクリプトの実行を終了する
  }
    }
    
  }
?>