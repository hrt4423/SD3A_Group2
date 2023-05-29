<!DOCTYPE html>
<html lang="ja">
<?php

  require_once "db_connect.php";
  require_once "functions.php";
  session_start();

  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

$datas = [
  'mail'  => '',
  'password'  => '',
  'confirm_password'  => ''
];

$login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
  ////CSRF対策
  checkToken();

  // POSTされてきたデータを変数に格納
  foreach($datas as $key => $value) {
      if($value = filter_input(INPUT_POST, $key, FILTER_DEFAULT)) {
          $datas[$key] = $value;
      }
  }

  // バリデーション
  $errors = validation($datas,false);
  if(empty($errors)){
      //ユーザーネームから該当するユーザー情報を取得
      $sql = "SELECT user_id,user_name,user_mail,user_pass FROM users WHERE user_mail = :mail";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('mail',$datas['mail'],PDO::PARAM_INT);
      $stmt->execute();

      //ユーザー情報があれば変数に格納
      if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          //パスワードがあっているか確認
          if (password_verify($datas['password'],$row['user_pass'])) {
              //セッションIDをふりなおす
              session_regenerate_id(true);
              //セッション変数にログイン情報を格納
              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $row['user_id'];
              $_SESSION["name"] =  $row['user_name'];
              //ウェルカムページへリダイレクト
              header("location:home.php");
              exit();
          } else {
              $login_err = 'メールアドレスまたはパスワードが間違っています';
          }
      }else {
          $login_err = 'メールアドレスまたはパスワードが間違っています';
      }
  }
}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>login</title>
</head>
<body>
  <img src="images/logo.png">

  <?php 
    if(!empty($login_err)){
    echo '<div class="alert alert-danger">' . $login_err . '</div>';
    }        
  ?>
    <form action="index.php" method="POST">
      <p>メールアドレス：<input type="text" name="user_mail"></p>
      <p>パスワード：<input type="password" name="password"></p>
      <button type="submit" name="login">
        ログイン
      </button>
    </form>
    <a href="sinnki">新規登録<a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<style>
  body{
    background-color:#B164FF;
    text-align:center
  }
  p{
    width: 550px;
    margin-left: auto;
    margin-right: auto;
    border-bottom:2px solid #660099;
    color:white;
    font-size:40px;
    text-align:center
  }
  input{
    background-color:#B164FF;
    border: none;
    outline: none;
    font-size:30px;
  }
  button{
    margin-top:50px;
    width:200px;
    height:50px;
    border-radius:10px;
    font-size: 30px;
    background-color:#660099;
    color:white;
  }
  a{
    text-decoration: none;
    margin-top:50px;
    font-size:30px;
    color:white;
  }
</style>
</html>