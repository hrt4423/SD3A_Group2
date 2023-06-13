<?php
  class Users{
    private function dbConnect(){
      //データベースに接続
      $pdo = new PDO('mysql:host=localhost; dbname=asoda; charset=utf8',
                      'root', 'root');
      return $pdo;
    }

    public function getUserDataById($id){
      $pdo = $this -> dbConnect();
      //SQLの生成
      $sql = "SELECT * FROM users WHERE user_id=?";

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
          $userData=$row;
        }
      } 
      return $userData;
    }

    public function getUserIconPathById($id){
      $pdo = $this -> dbConnect();
      $sql = "SELECT user_icon FROM users WHERE user_id=?";
      $ps = $pdo -> prepare($sql);
      $ps->bindValue(1, $id, PDO::PARAM_INT); 
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
      $sql = "UPDATE users SET user_icon=? WHERE user_id=?";
      $ps = $pdo -> prepare($sql);
      $ps->bindValue(1, $imagePath, PDO::PARAM_STR);
      $ps->bindValue(2, $id, PDO::PARAM_INT); 

      $ps->execute();
    }

    public function updateProfile($id, $userData){
      $pdo = $this -> dbConnect();
      $sql = "UPDATE users SET user_name=?, user_mail=?, user_pass=?, user_profile=?, thema_color_id=? WHERE user_id=?";
      $ps = $pdo -> prepare($sql);
      $ps->bindValue(1, $userData['user_name'], PDO::PARAM_STR);
      $ps->bindValue(2, $userData['user_mail'], PDO::PARAM_STR);
      $ps->bindValue(3, $userData['user_pass'], PDO::PARAM_STR);
      $ps->bindValue(4, $userData['user_profile'], PDO::PARAM_STR);
      $ps->bindValue(5, $userData['thema_color_id'], PDO::PARAM_INT);
      $ps->bindValue(6, $id, PDO::PARAM_INT); 

      $ps->execute();
    }

    public function getUserNameById($id){
      $pdo = $this -> dbConnect();
      $sql = "SELECT user_name FROM users WHERE user_id=?";
      $ps = $pdo -> prepare($sql);
      $ps->bindValue(1, $id, PDO::PARAM_INT); 
      $ps->execute();
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      if(empty($result)){
        return '指定したIDに該当するデータはありません。';
      }else{
        foreach($result as $row){
          $userName=$row['user_name'];
        }
      } 
      return $userName;
    }
  }
?>