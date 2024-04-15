<?php session_start();
  header('Refresh: 1.5; ./profile_question.php');
?>
<!DOCTYPE html>
<html lang="ja"> 
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    submit_profile
  </title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="./css/header.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
  <link href="css/logout.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
</head>
<body>
</body>
</html>
<?php
  //プロフィールのアップデート処理
  require_once('./dao/users.php');
  $users = new Users;
   
  $id = $_SESSION['user_id'];

  try{
    $users->updateProfile($id, $_POST);
  }catch(PDOException $pdoE) {
    header('Refresh: 2; ./profile_edit.php');
    echo 'メールアドレスが重複しています。編集画面へ戻ります。';
    exit;
  }
  
  $users->updateProfile($id, $_POST);
  echo '更新しました。プロフィール画面に戻ります';
?>


