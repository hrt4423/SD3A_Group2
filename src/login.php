<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php

$error_message = "";

if(isset($_POST["login"])) {

	if($_POST["user_name"] == "webtan" && $_POST["password"] == "webtan_pass") {
		$_SESSION["user_name"] = $_POST["user_name"];
		$login_success_url = "login_success.php";
		header("Location: {$login_success_url}");
		exit;
	}
$error_message = "※ID、もしくはパスワードが間違っています。<br>　もう一度入力して下さい。";
}
?>
<body>
    <?php
        if($error_message) {
            echo $error_message;
        }
    ?>

    <form action="index.php" method="POST">
        <p>ログインID：<input type="text" name="user_name"></p>
        <p>パスワード：<input type="password" name="password"></p>
        <input type="submit" name="login" value="ログイン">
        <a harf="">新規登録</a>
    </form>
</body>
<style>
    body{
        text-align:center
        background:#B164FF
    }
    p{
        font-size:40px;
    }
    input{
        font-size:30px;
    }
    a{
        font-size:30px;
    }
</style>
</html>