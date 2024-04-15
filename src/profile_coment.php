<?php
session_start();

function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

$id=$_SESSION['user_id'];
require_once('config.php');
  // $pdo = new PDO(DSN, DB_USER, DB_PASS);

  require_once('./dao/connection.php');
  $connection = new Connection();
  $pdo = $connection->getPdo();

  $stmt = $pdo->prepare('select * from users where user_id = ?');
  $stmt->execute([$id]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  require_once './dao/users.php';
$users = new Users;
require_once './dao/theme_colors.php';
  $themeColors = new ThemeColors;
  if(isset($_SESSION['user_id'])){
    $currentThemeColorId =  $users->getThemeColorId($_SESSION['user_id']);
  }else{
    $currentThemeColorId = 1;
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/Profile_coment.css">
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
    /* height: 150px; */
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
    /* background-color: #653A91; */
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
  .logo{
    margin-top: 0.9vw;
    width: 10vw;
    height: 2.7vw;
  }
  .search-icon {
    height: 38px;
  }
  .link1{
  text-decoration: none;  
  font-size: 0.9vw;
  font-weight: 0.2vw;
  text-align: center;
  margin-top: 1.3vw;
  display: flex;
  justify-content: center;
  align-items: center;
}
.btn{
      background-color: <?=$themeColors->getButtonColorCode($currentThemeColorId)?>;
      color: white;
    }
    .good_img{
      background-color: <?=$themeColors->getButtonColorCode($currentThemeColorId)?>;
    }
  </style>
</head>
<body class="body" style="background-color: <?=$themeColors->getSubColorCode($currentThemeColorId) ?>">

  <!-- ここからがヘッダー -->
  <!--変更点：ヘッダーの高さを150pxから100pxに変更-->
  <div class="header_size" style="background-color: <?=$themeColors->getThemeColorCode($currentThemeColorId)?> ;">
      <?php
        require_once('./dao/users.php');
        $users = new Users;
        // ユーザセッションがある場合はセッションを入れて処理を実行
        if (!empty($_SESSION['user_id'])) {
          $USESR_ID = $_SESSION['user_id'];
          $userIconPath = $users->getUserIconPathById($USESR_ID);
        }
      ?>
      <div class="horizontal">
        <a href="./questiontimeline.php">
          <img class="logo" src="./images/<?=$themeColors->getLogoPath($currentThemeColorId)?>" height="60" alt="ロゴ">
        </a>
        <div class="right">

          <!-- 検索フォーム -->
          <div class="input-group mb-3 search" >
            <form action="./search_result.php" method="GET" id="search-form">
                <div class="horizontal">
                  <div class="input-group-prepend search-icon">
                    <button type="submit" class="input-group-text" id="search-button">
                    <i class="fa fa-search"></i>
                    </button>
                  </div>
                  <input type="hidden" name="sort_type" value="0">
                  <input type="text" name="keyword" class="col-8 form-control" placeholder="検索" aria-label="検索" aria-describedby="basic-addon2">
                </div>
              </form>
          </div>
          <a href="./profile_question.php" class="circle">
            <?php
                  // ユーザアイコンパスが空でない場合は画像を表示し、空の場合はログインページに遷移するボタンを表示する
                  if (!empty($userIconPath)) {
                    echo '<img src="' . $userIconPath . '" alt="ユーザアイコン" style="width: 30px;">';
                  } else {
                    echo '<a href="login.php" class="login_atag">ログイン</a>';
                  }
              ?>
          </a>
          
          <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              投稿する
            </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="./questionCreation.php">質問</a>
                <a class="dropdown-item" href="./articleCreation.php">記事</a>
              </div>
          </div>
        </div>
      </div>

      <div class="horizontal">
        <a href="./questiontimeline.php" class=" text">質問</a>
        <a href="./articlelist.php" class=" text">記事</a>
        <a href="./Ranking.php" class=" text">ランキング</a>
        <a href="./classroom.php" class=" text">空き教室</a>
      </div>
    </div>
  <!-- ここまでがヘッダー -->
<div class="profile">
    <div class="profile_area">
      <div class="circle_area">
        <img src="./<?= $userIconPath ?>" alt="ユーザアイコン" style="width: 50px;">
      </div>
      <?php
      echo"<p class='user_name'>".h($row['user_name'])."</p>";
      echo"<p class='user_mail'>".h($row['user_mail'])."</p>";
      echo"<p class='user_point'>".h($row['user_point'])."pt</p>";
      ?>
      <a href='./profile_edit.php' class="link1">編集</a>
      <a href='logout.php' class="link1">ログアウト</a>
    </div>

    <?php

try{
  require_once './dao/posts.php';
  $postAll = new DAO_post();
  $search = $postAll->prof_coment_post();//データ取得
  echo '<script>';
echo 'console.log(' . json_encode($search) . ')';
echo '</script>';

require_once './dao/tags.php';
$tagAll = new DAO_tag();
$search2 = $tagAll->tags();
echo '<script>';
echo 'console.log(' . json_encode($search2) . ')';
echo '</script>';
require_once './dao/attached_tags.php';
$attachedTags = new AttachedTags();
}catch(Exception $ex){
  echo $ex->getMessage();
}catch(Error $err){
  echo $err->getMessage();
}
?>

    <div class="my_area">
      <p class="p1">投稿したコメント</p>
      <div class="question_area">
          <div class="horizontal1" style="background-color: <?=$themeColors->getThemeColorCode($currentThemeColorId)?> ;">
            <a href="profile_question.php" class="text1">質問</a>
            <a href="profile_kizi.php" class="text1 ">記事</a>
            <a href="#" class="text2 ">コメント</a>
          </div>
          
          <div class="naiyou_area">
          <?php
              foreach ($search as $post) {
                  echo '<div class="naiyou">
                          <div class="syousai_area">
                              <p class="day">' . $post['post_time'] . 'に投稿</p>
                              <p class="title">' . $post['post_title'] . '</p>
                              <div class="tag_area">
                                  <img src="./images/pin.png" alt="" class="img2">';
                  
                                  try {
                                      $attachedTag = $attachedTags->getAttachedTagsByPostId($post['post_id']);
                                      if (!empty($attachedTag)) {
                                          foreach ($attachedTag as $tag) {
                                              echo '<span>' . $tag['tag_name'] . '</span>';
                                          }
                                      } else {
                                          echo 'タグなし';
                                      }
                                  } catch (Exception $ex) {
                                      echo 'タグなし';
                                  } catch (Error $err) {
                                      echo 'タグなし';
                                  }

                                      echo '</div>
                                              </div>
                                              <div class="good_area">
                                                  <div class="good_img">
                                                      <img src="./images/good.png" alt="" class="img3">
                                                  </div>
                                              </div>
                                              <p class="good">' . $post['good_count'] . '</p>
                                            </div>';
                                  }
                                  ?>

          </div>

      </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>