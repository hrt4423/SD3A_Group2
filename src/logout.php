<link href="css/logout.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
<?php
session_start();
$output = '';
if (isset($_SESSION["EMAIL"])) {
  $output = 'Logoutしました。';
} else {
  $output = 'SessionがTimeoutしました。';
}
//セッション変数のクリア
$_SESSION = array();
//セッションクッキーも削除
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
//セッションクリア
@session_destroy();

//echo "<br><a href='login.php'>ログインはこちら。</a>";
// 1秒後にquestiontimeline.phpへリダイレクト
echo $output;
header("refresh:1;url=questiontimeline.php");
?>