<?php
  class Users{
    private function dbConnect(){
      //データベースに接続
      $pdo = new PDO('mysql:host=localhost; dbname=asoda; charset=utf8',
                      'hirata', 'password');
      return $pdo;
    }

    public function getUserIconPathById($id){
      $pdo = $this -> dbConnect();
      //SQLの生成
      $sql = "SELECT user_icon FROM users WHERE user_id=?";

      //prepare:準備　戻り値を変数に保持
      $ps = $pdo -> prepare($sql);

      //”？”に値を設定する。
      $ps->bindValue(1, $id, PDO::PARAM_INT); 

      //SQLの実行
      $ps->execute();
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      if(empty($result)){
        echo '指定したIDに該当するデータはありません。';
      }else{
        foreach($result as $row){
          $imagePath=$row['user_icon'];
        }
      } 
      return $imagePath;
    }

    public function updateUserIconPath($id, $imagePath){
      $pdo = $this -> dbConnect();
      //SQLの生成
      $sql = "UPDATE users SET user_icon=? WHERE user_id=?";

      //prepare:準備　戻り値を変数に保持
      $ps = $pdo -> prepare($sql);

      //”？”に値を設定する。
      $ps->bindValue(1, $imagePath, PDO::PARAM_STR);
      $ps->bindValue(2, $id, PDO::PARAM_INT); 

      //SQLの実行
      $ps->execute();
    }
  }
?>