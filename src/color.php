<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile_question</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    .btn-purple {
  background-color: #653A91;
  border-color: #653A91;
  color: #fff;
}
.btn-purple:hover {
  background-color: #4b2661;
  border-color: #4b2661;
  color: #fff;
}
.btn-purple:focus {
  box-shadow: none;
  color: #fff;
}

.header_size {
   height: 150px; 
  background-color: #b164ff;
}

.horizontal {
  display: flex;
  text-align: center;
  height: 4.5vw;
}

.search {
  width: 200px;
  height: 37px;
  margin-right: 20px;
}

.right {
  margin-left: auto;
  display: flex;
  margin-top: 1.5vw;
}

.text {
  color: white;
  font-size: 30px;
  font-weight: bold;
  flex-grow: 1;
}

.circle {
  width: 37px;
  height: 37px;
  border-radius: 50%;
  background-color: #653A91;
  margin-right: 20px;
}

.btn-purple {
  background-color: #653a91;
  color: #fff;
}

.btn {
  margin-right: 20px;
}

.underline {
  text-decoration: none; /* 下線をなくす */
  display: inline-block;
  border-bottom: 10px solid #653A91;
}

a:hover {
  text-decoration: none;
  color: white;
  width: 2vw;
}
.logo{
  margin-top: 0.9vw;
  width: 10vw;
  height: 2.7vw;
}
  </style>
</head>
<body class="body">

    <div class="header_size">
      <div class="horizontal">
          <img class="logo" src="images/logo.png" height="60" alt="ロゴ">
        <div class="right">

          <div class="input-group mb-3 search" >
            <div class="input-group-prepend">
              <span class="input-group-text">
              <i class="fa fa-search"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="検索" aria-label="検索" aria-describedby="basic-addon2">
          </div>

          <div class="circle"></div>
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  投稿する
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">質問</a>
                  <a class="dropdown-item" href="#">記事</a>
                </div>
            </div>
        </div>
      </div>

    </div>
<!-- ↑ヘッダー -->
<?php
try {

  require_once './dao/users.php';
    $postAll = new Users();
    $search = $postAll->getUsercolor_code(1);//データ取得
    echo '<script>';
    echo 'console.log(' . json_encode($search) . ')';
    echo '</script>';

} catch(Exception $ex) {
  echo $ex->getMessage();
} catch(Error $err) {
  echo $err->getMessage();
}
?>

<div>
  <select name="color" id="color" onchange="sendColorCode()">
    <option value="puple">puple</option>
    <option value="green">green</option>
    <option value="red">red</option>
    <option value="yellow">yellow</option>
    <option value="blue">blue</option>
    <option value="pink">pink</option>
    <option value="orange">orange</option>
    <option value="white">white</option>
    <option value="black">black</option>
  </select>
</div>

  <script>
    $(document).ready(function() {
     // リンクをクリックした時の処理
      $(".underline").click(function(e) {
        e.preventDefault(); // デフォルトのリンク遷移を防止

        // すでにアクティブなリンクがある場合、その下線を消す
        $(".underline.active").removeClass("active");
        // クリックされたリンクに下線をつける
        $(this).addClass("active");
      });
    });

    function sendColorCode() {
  var selectedColor = document.getElementById("color").value;
  // AJAXリクエストなどでcolor_codeに値を渡す処理を実装する
  // 以下は例として、fetchを使用した非同期リクエストの例です
  fetch('./dao/thema_colors.php', {
    method: 'POST',
    body: JSON.stringify({ color: selectedColor }),
    headers: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    console.log(data);
    // 必要な処理を行う
  })
  .catch(error => console.error(error));
}
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>