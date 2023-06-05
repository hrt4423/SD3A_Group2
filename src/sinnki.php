<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<img src="images/logo.png">
    <form action="signup.php" method="post">
        <p>名前：<input type="text" name="name"></p>
        <p>メールアドレス：<input type="email" name="mail"></p>
        <p>パスワード：<input type="password" name="password"></p>
        <p>プロフィール：<input type="text" name="purof"></p>
        <button type="submit" name="singup">
        新規登録
        </button>
    </from>
</body>
<style>
  body{
    background-color:#B164FF;
    text-align:center
  }
  p{
    width: 650px;
    margin-left: auto;
    margin-right: auto;
    border-bottom:2px solid #660099;
    color:white;
    font-size:40px;
    text-align:center
  }
  input{
    background-color:#B164FF;
    border: none;
    outline: none;
    font-size:30px;
  }
  button{
    margin-top:50px;
    width:200px;
    height:50px;
    border-radius:10px;
    font-size: 30px;
    background-color:#660099;
    color:white;
  }
  a{
    text-decoration: none;
    margin-top:50px;
    font-size:30px;
    color:white;
  }
</style>
</html>