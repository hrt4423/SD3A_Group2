<?php
  session_start();
  header("refresh:1.5;url=questiontimeline.php");
?>
<!DOCTYPE html>
<html lang="ja"> 
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    logout
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

$output = '';
if (isset($_SESSION["user_id"])) {
  $output = 'ログアウトしました。';
} else {
  $output = 'SessionがTimeoutしました。';
}
// //セッション変数のクリア 
// $_SESSION = array();
// //セッションクッキーも削除
// if (ini_get("session.use_cookies")) {
//   $params = session_get_cookie_params();
//   setcookie(session_name(), '', time() - 42000,
//       $params["path"], $params["domain"],
//       $params["secure"], $params["httponly"]
//   );
// }
//セッションクリア
@session_destroy();

//echo "<br><a href='login.php'>ログインはこちら。</a>";
// 1秒後にquestiontimeline.phpへリダイレクト
echo $output;
?>