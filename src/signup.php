<link href="css/signup.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
<?php
require_once('config.php');
try {
  require_once('./dao/connection.php');
  $connection = new Connection;
  $pdo = $connection->getPdo();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
//POSTのValidate。
if (!$mail = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
  echo '入力された値が不正です。';
  return false;
}
//パスワードの正規表現
if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
  $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
} else {
  echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
  return false;
} 
$name=$_POST['name'];
$prof=$_POST['purof'];
//登録処理
try {
  $stmt = $pdo->prepare("insert into users(user_id,user_name,user_mail,user_pass,user_profile) value(null,?,?,?,?)");
  $stmt->execute([$name,$mail,$password,$prof]);
  header('Refresh: 3; URL=login.php');
  echo '登録完了しました。ログイン画面に戻ります。';
} catch (\Exception $e) {
  echo '登録済みのメールアドレスです。';
}