<?php session_start() ?>
<!DOCTYPE html>
<html lang="ja"> 
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    logincheck
  </title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="./css/header.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
  <link href="css/logincheck.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
</head>
<body>
  <div class="body">
<?php 

require_once('config.php');

//POSTのvalidate
if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
  echo '入力された値が不正です。';
  return false;
}
//DB内でPOSTされたメールアドレスを検索
try { 
  require_once('./dao/connection.php');
  $connection = new Connection;
  $pdo = $connection->getPdo();
  $stmt = $pdo->prepare('select * from users where user_mail = ?');
  $stmt->execute([$_POST['mail']]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
//emailがDB内に存在しているか確認
if (!isset($row['user_mail'])) {
  echo 'メールアドレスが間違っています。';
  echo "<div class=return_button>";
  echo "<br><a href='login.php'>戻る</a>";
  echo "</div>";
  return false;
}
//パスワード確認後sessionにメールアドレスを渡す
if (password_verify($_POST['password'],$row['user_pass'])) {
  session_regenerate_id(true); //session_idを新しく生成し、置き換える
  $_SESSION['user_id'] = $row['user_id'];
  header('Refresh: 3; URL=questiontimeline.php');
  echo 'ログインしました。ホーム画面へ移動します';
} else {
  echo 'メールアドレス又はパスワードが間違っています。';
  echo "<div class=return_button>";
  echo "<br><a href='login.php'>戻る</a>";
  echo "</div>";
  return false;
}
?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</div>
</body>
</html>
