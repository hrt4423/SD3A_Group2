<?php

session_start();
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
  echo "<br><a href='login.php'>戻る</a>";
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
  echo "<br><a href='login.php'>戻る</a>";
  return false;
}