<?php 
  session_start();
  ob_start();
?>
<!DOCTYPE html>
<html lang="ja"> 
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    logincheck
  </title>
  <link href="css/logincheck.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
</head>
<body>
  
</body>
</html>
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
  //session_regenerate_id(true); //session_idを新しく生成し、置き換える
  $_SESSION['user_id'] = $row['user_id'];
  echo 'ログインしました。ホーム画面へ移動します';
  ob_end_clean();
  header('Refresh: 3; URL=questiontimeline.php');
  exit;
} else {
  echo 'メールアドレス又はパスワードが間違っています。';
  echo "<div class=return_button>";
  echo "<br><a href='login.php'>戻る</a>";
  echo "</div>";
  return false;
}
?>