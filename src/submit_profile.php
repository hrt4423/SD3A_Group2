<?php session_start() ?>
<!DOCTYPE html>
<html lang="ja"> 
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    submit_profile
  </title>
  <link href="css/logout.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
</head>
<body>
  <?php
    //プロフィールのアップデート処理
    require_once('./dao/users.php');
    $users = new Users;
    
    $id = $_SESSION['user_id'];
    try{
      $users->updateProfile($id, $_POST);
    }catch(PDOException $pdoE) {
      echo 'メールアドレスが重複しています。編集画面へ戻ります。';
      header('Refresh: 2; ./profile_edit.php');
      exit;
    }
  ?>
  <p>更新しました。プロフィールへ戻ります。</p>
  
</body>
</html>
