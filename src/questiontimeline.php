<?php session_start(); ?>
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
  <link href="./css/header.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
  
  <script src="js/questiontimeline.js"></script>
  <style>
    .tag-text{
      color: brack;
    }
    .logo{
      margin-top: 0.9vw;
      width: 10vw;
      height: 2.7vw;
    }
    .test {
      width: 100px;
      height: 100px;
      background-color: #b164ff;
    }
  </style>
</head>
<?php

  try{
    require_once './DAO/posts.php';
    $postAll = new DAO_post();
    $search = $postAll->post();//データ取得
    echo '<script>';
    echo 'console.log(' . json_encode($search) . ')';
    echo '</script>';

    require_once './dao/tags.php';
    $tagAll = new DAO_tag();
    $search2 = $tagAll->tags();
    echo '<script>';
    echo 'console.log(' . json_encode($search2) . ')';
    echo '</script>';
  }catch(Exception $ex){
    echo $ex->getMessage();
  }catch(Error $err){
    echo $err->getMessage();
  }
?>
<body id="body">
  <!-- ここからがヘッダー -->
  <!-- 変更-->
    <div class="header_size">
      <?php
        require_once('./dao/Users.php');
        $users = new Users;
        $USESR_ID = $_SESSION['user_id'];
        $userIconPath = $users->getUserIconPathById($USESR_ID);
      ?>
      <div class="horizontal">
        <img class="logo" src="./images/logo.png" height="60" alt="ロゴ">
        <div class="right">

          <!-- 検索フォーム -->
          <div class="input-group mb-3 search" >

            <form action="./search_result.php" method="GET" id="search-form">
              <div class="input-group-prepend">
                <button type="submit" class="input-group-text" id="search-button">
                  <i class="fa fa-search"></i>
                </button>
              </div>
              <input type="hidden" name="sort_type" value="0">
              <input type="text" name="keyword" class="col-6 form-control" placeholder="検索" aria-label="検索" aria-describedby="basic-addon2">
            </form>

          </div>
          <a href="./profile_question.php" class="circle">
            <img src="./<?= $userIconPath ?>" alt="ユーザアイコン" style="width: 30px;">
          </a>
          
          <div class="dropdown">
            <button class="btn btn-purple dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              投稿する
            </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="./questionCreation.php">質問</a>
                <a class="dropdown-item" href="#">記事</a>
              </div>
          </div>
        </div>
      </div>

      <div class="horizontal">
        <a href="./questiontimeline.php" class="underline text">質問</a>
        <a href="./articlelist.php" class="underline text">記事</a>
        <a href="./Ranking.php" class="underline text">ランキング</a>
        <a href="./classroom.php" class="underline text">空き教室</a>
      </div>
    </div>
  <!-- ここまでがヘッダー -->
  <?php

    try{
      require_once './DAO/posts.php';
      $postAll = new DAO_post();
      $search = $postAll->post();//データ取得
      echo '<script>';
      echo 'console.log(' . json_encode($search) . ')';
      echo '</script>';

      require_once './dao/tags.php';
      $tagAll = new DAO_tag();
      $search2 = $tagAll->tags();
      echo '<script>';
      echo 'console.log(' . json_encode($search2) . ')';
      echo '</script>';
    }catch(Exception $ex){
      echo $ex->getMessage();
    }catch(Error $err){
      echo $err->getMessage();
    }
  ?>

  <!-- <fieldset class="frameborder"> -->
    <!--タグ検索ボタン-->
    <form action="./questiontimeline.php" method="GET" id="tag-form"></form>

    <div class="select_area">
      <div class="sele_area1">
        <select class="select1">
          <option value="" disabled selected>タグ</option>

          <?php foreach($search2 as $tag) : ?>
            <option value="<?=  $tag['tag_id'] ?>"  class="tag-text">
            <?= $tag['tag_name'] ?></option>
          <?php endforeach; ?>

        </select>
      </div>
        <!--タグ検索ボタン終了-->
        <!--並び替えセレクトボックス-->
          <!-- <a href="javascript:void(0)">
            <div>↓並び替え</div>
          </a>
          <select size="2" data-role="none">
            <option value="1">最新投稿</option>
            <option value="2">古い投稿</option>
          </select> -->
      <div class="sele_area2">
        <select class="select2">
          <option value="1">最新投稿</option>
          <option value="2">古い投稿</option>
        </select>
      </div>
    </div>
 <!--質問画面遷移ボタン-->
 <div class="question_area">
    <?php foreach($search as $post){
        echo '<div >
        <form action="question-detail.php" method="GET">
        <input type="hidden" name="post_id" value="'.$post['post_id'].'">
        <button class="question">
          <p class="user2">
           '.$post['user_name'].'
          </p>
          <p class="day">
            ' . $post['post_time'] . 'に投稿
          </p>
          <p class="title">
            ' . $post['post_title'] . '
          </p>
          <div class="tag_area">
                <img src="./images/pin.png" alt="" class="img2">
                <p class="tag">タグ</p>
          </div>
          
          <div class="good_area">
                  <div class="good_img">
                    <img src="./images/good.png" alt="" class="img3">
                  </div>
                </div>
                <p class="good">'.$post['good_count'].'</p>
        </button>   
        </form>
      </div>';
    }
    ?>
 </div>

   <!--質問画面遷移ボタン終了-->
  <!-- </form>
  </fieldset> -->
  <!-- <script>
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
</script> -->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>