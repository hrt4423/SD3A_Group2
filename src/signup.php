<?php
   header('Refresh: 1.5; URL=login.php');
?>
<!DOCTYPE html>
<html lang="ja"> 
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    signup
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
  echo '登録完了しました。ログイン画面に戻ります。';
} catch (\Exception $e) {
  echo '登録済みのメールアドレスです。';
}
?>

