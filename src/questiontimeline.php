<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    質問一覧画面
  </title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="css/questiontimeline.css" rel="stylesheet">
  <script src="js/questiontimeline.js"></script>
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
    }

    .search {
      width: 200px;
      height: 37px;
      margin-right: 20px;
    }

    .right {
      margin-left: auto;
      display: flex;
      margin-top: 15px;
    }

    .text {
      color: white;
      font-size: 30px;
      font-weight: bold;
      flex-grow: 1;
      margin-top: 35px;
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
      width: 100%;
    }

    .underline.active {
      text-decoration: underline; 
      border-bottom: 10px solid #653A91;
      text-decoration: none;
    }

    a:hover {
      color: white;
      border-bottom: none;
      text-decoration: none;
    }

  </style>
</head>
<?php

try{
  require_once './DAO/posts.php';
  $DAO_post = new DAO_post();
  $allQuestions = $DAO_post->getAllQuestion();//データ取得
  $count = count($allQuestions);
}catch(Exception $ex){
  echo $ex->getMessage();
}catch(Error $err){
  echo $err->getMessage();
}
?>
<body>
  <?php
    print_r($allQuestions);
  ?>
  <div class="header_size">
    <div class="horizontal">
        <img class="logo" src="./images/logo.png" height="60" alt="ロゴ">
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
          <button class="btn btn-purple dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            投稿する
          </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#">質問</a>
              <a class="dropdown-item" href="#">記事</a>
             </div>
            </div>
  
      </div>
    </div>
  
    <div class="horizontal">
      <a href="#" class="underline text">質問</a>
      <a href="#" class="underline text">記事</a>
      <a href="#" class="underline text">教室</a>
      <a href="#" class="underline text">ランキング</a>
    </div>
  
  </div>

  <fieldset class="frameborder">
    <!--タグ検索ボタン-->
    <div class="btn-wrap">
        <a href="" class="btn btn-switch"><span>タグ検索</span></a>
      </div>
      <!--タグ検索ボタン終了-->
<!--並び替えセレクトボックス-->
      <div class="mamListBox">
        <a href="javascript:void(0)">
          <div>↓並び替え</div>
        </a>
        <select size="2" data-role="none">
          <option value="1">最新投稿</option>
          <option value="2">古い投稿</option>
        </select>
      </div>
      <!--並び替えセレクトボックス終了-->
 <!--質問画面遷移ボタン-->
 <div class="question_area">
  <?php
    foreach($allQuestions as $row){
      echo "$row[post_title]";
    }
  ?>

    <?php foreach ($allQuestions as $row) : ?>
      <li><?php echo "$row[post_title]"; ?></li>
    <?php endforeach; ?>

 <?php foreach ($allQuestions as $row): ?>
  <div class="question1">
    <button>
      <p id="user-name">
        😊👑 @user
      </p>
      <p id="posted-date">
        <?php $post['post_time']; ?>に投稿
      </p>
      <p id="title">
        <?= $post['post_title']; ?>
      </p>
      <p id="tag">
        📌
      </p>
      <p id="number-of-responses">
        回答件数：
      </p>
      <p id="good">
        👍
      </p>
      <p id="good-number">
 
      </p>
    </button>   
  </div>
  </div>
<?php endforeach; ?>
   <!--質問画面遷移ボタン終了-->
  </form>
  </fieldset>
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
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>