<?= session_start() ?>
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
  <div class="body">
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
  header('Refresh: 2; ./profile_question.php');

?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</div>
</body>
</html>
