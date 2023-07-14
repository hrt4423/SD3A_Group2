<?php
  class Users{

    private $pdo;
    public function __construct() {
      require_once('connection.php');
      $connection = new Connection();
      $this->pdo = $connection->getPdo();
    }

    public function getUserDataById($id){
      $sql = "SELECT * FROM users WHERE user_id=?";

      //prepare:準備　戻り値を変数に保持
      $ps = $this->pdo->prepare($sql);

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
      $sql = "SELECT user_icon FROM users WHERE user_id=?";
      $ps = $this->pdo->prepare($sql);
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
      $sql = "UPDATE users SET user_icon=? WHERE user_id=?";
      $ps = $this->pdo->prepare($sql);
      $ps->bindValue(1, $imagePath, PDO::PARAM_STR);
      $ps->bindValue(2, $id, PDO::PARAM_INT); 

      $ps->execute();
    }
    
    public function updateProfile($id, $userData){
      $sql = "UPDATE users SET user_name=?, user_mail=?, user_pass=?, user_profile=?, thema_color_id=? WHERE user_id=?";
      $ps = $this->pdo->prepare($sql);
      $ps->bindValue(1, $userData['user_name'], PDO::PARAM_STR);
      $ps->bindValue(2, $userData['user_mail'], PDO::PARAM_STR);
      $ps->bindValue(3, password_hash($userData['user_pass'],PASSWORD_DEFAULT), PDO::PARAM_STR);
      $ps->bindValue(4, $userData['user_profile'], PDO::PARAM_STR);
      $ps->bindValue(5, $userData['thema_color_id'], PDO::PARAM_INT);
      $ps->bindValue(6, $id, PDO::PARAM_INT); 
      
      $ps->execute();
    }
    

    public function isEmailInDatabase(){
      $sql = "SELECT user_mail FROM users WHERE user_mail=?";
      $ps = $this->pdo->prepare($sql);
      $ps->bindValue(1, $_POST['user_mail'], PDO::PARAM_STR); 
      $ps->execute();
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      if(empty($result)){
        return false;
      }else{
        return true;
      } 
    }

    public function getUserNameById($id){
      $sql = "SELECT user_name FROM users WHERE user_id=?";
      $ps = $this->pdo->prepare($sql);
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
    
    //TODO: いつも黒が帰ってくる。検索がうまくいってない？
    public function getUsercolor_code($id){
      $sql = "SELECT theme_color_code, sub_color_code FROM theme_colors WHERE theme_color_id = (
          SELECT theme_color_id FROM users WHERE user_id = ?
      )";
      $ps = $this->pdo->prepare($sql);
      $ps->bindValue(1, $id, PDO::PARAM_INT); 
      $ps->execute();
      $result = $ps->fetchAll();
  
      if(empty($result)){
          echo '指定したIDに該当するデータはありません。';
      }else{
        foreach($result as $row){
          $themeColorCode =  $row['theme_color_code'];
        }
      }
      
      return $themeColorCode;
    }

    //ユーザの設定色を取得
    public function getThemeColorId($userId){
      $sql = "SELECT thema_color_id FROM users WHERE user_id=?";
      $ps = $this->pdo->prepare($sql);
      $ps->bindValue(1, $userId, PDO::PARAM_INT); 
      $ps->execute();
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      if(empty($result)){
        echo '指定したIDに該当するデータはありません。';
      }else{
        foreach($result as $row){
          $themeColorId = $row['thema_color_id'];
        }
      } 
      return $themeColorId;
    }
  }
?>