<?php

require_once('config.php');

session_start();
//POSTのvalidate
if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
  echo '入力された値が不正です。';
  return false;
}
//DB内でPOSTされたメールアドレスを検索
try {
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $stmt = $pdo->prepare('select * from users where user_mail = ?');
  $stmt->execute([$_POST['mail']]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
//emailがDB内に存在しているか確認
if (!isset($row['user_mail'])) {
  echo 'メールアドレスが間違っています。';
  return false;
}
//パスワード確認後sessionにメールアドレスを渡す
if (password_verify($_POST['password'],$row['user_pass'])) {
  session_regenerate_id(true); //session_idを新しく生成し、置き換える
  $_SESSION['user_id'] = $row['user_id'];
  echo 'ログインしました。ホーム画面へ移動します';
  header('Refresh: 5; URL=questiontimeline.php');
} else {
  echo 'メールアドレス又はパスワードが間違っています。';
  return false;
}