<?php
 
//セッションを使う
session_start();
 
// 変数の初期化
$email = '';
$password = '';
$err_msg = array();
 
// POST送信があるかないか判定
if (!empty($_POST)) {
  // 各データを変数に格納
  $email = $_POST['email'];
  $password = $_POST['password'];
 
  // eメールアドレスバリデーションチェック
  // 空白チェック
  if ($email === '') {
    $err_msg['email'] = '入力必須です';
  }
  // 文字数チェック
  if (strlen($email) > 255) {
    $err_msg['email'] = '255文字で入力してください';
  }
  // パスワードバリデーションチェック
  // 空白チェック
  if ($password === '') {
    $err_msg['password'] = '入力してください';
  }
  // 文字数チェック
  if (strlen($password) > 255 || strlen($password) < 5) {
    $err_msg['password'] = '６文字以上２５５文字以内で入力してください';
  }
  // 形式チェック
  if (!preg_match("/^[a-zA-Z0-9]+$/", $password)) {
    $err_msg['password'] = '半角英数字で入力してください';
  }
}
 
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>login</title>
</head>
<body>
        <form action="" method="post">
        <div class="err_msg"><?php echo $err_msg['email']; ?></div>
        <label for=""><span>メールアドレス</span>
          <input type="email" name="email" id=""><br>
        </label>
        <div class="err_msg"><?php echo $err_msg['password']; ?></div>
        <label for=""><span>パスワード</span>
          <input type="text" name="password" id=""><br>
        </label>
        <input type="submit" value="ログイン">
        </form>
        <a href="新規登録画面">新規登録<a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>