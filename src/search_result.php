<?php 
  session_start(); 
  if(!isset($_GET['sort_type'])){
    $_GET['sort_type'] = 0;
  }
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="./css/search_result.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
  <link href="./css/header.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
 
  <title>search-result</title>
</head>
<style>
  .btn{
      background-color: <?=$themeColors->getButtonColorCode($currentThemeColorId)?>;
      color: white;
    }
    .good_img{
      background-color: <?=$themeColors->getButtonColorCode($currentThemeColorId)?>;
    }
  </style>
<body style="background-color: <?=$themeColors->getSubColorCode($currentThemeColorId) ?>">
  <?php 
    //優先度を減算する処理
    
  ?>
  <!-- ここからがヘッダー -->
    <div class="header_size" style="background-color: <?=$themeColors->getThemeColorCode($currentThemeColorId)?> ;">
      <?php
        // require_once('./dao/Users.php');
        // $users = new Users;
        // ユーザセッションがある場合はセッションを入れて処理を実行
        if (!empty($_SESSION['user_id'])) {
          $USESR_ID = $_SESSION['user_id'];
          $userIconPath = $users->getUserIconPathById($USESR_ID);
        }
      ?>
      <div class="horizontal">
        <img class="logo" src="./images/<?=$themeColors->getLogoPath($currentThemeColorId)?>" height="60" alt="ロゴ">
        <div class="right">

          <!-- 検索フォーム -->
          <div class="input-group mb-3 search" >
            <form action="./search_result.php" method="GET" id="search-form">
                <div class="horizontal">
                  <div class="input-group-prepend">
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
                  echo '<a href="login.php">ログイン</a>';
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
        <a href="./questiontimeline.php" class="underline text">質問</a>
        <a href="./articlelist.php" class="underline text">記事</a>
        <a href="./Ranking.php" class="underline text">ランキング</a>
        <a href="./classroom.php" class="underline text">空き教室</a>
      </div>

    </div>
  <!-- ここまでがヘッダー -->
<div class="background" style="background-color: <?=$themeColors->getSubColorCode($currentThemeColorId) ?>">
  <h1>検索結果</h1>
  <form action="./search_result.php" method="GET" id="sort-form">
    <select name="sort_type" id="sort-type">

      <option value="" disabled selected> 
        <?php 
          switch ($_GET['sort_type']) {
            case 1:
              echo '昇順';
              break;
            case 2:
              echo '降順';
              break;
            default:
              echo 'デフォルト';
              break;
          }
        ?> 
      </option>

      <option value="0">デフォルト</option>
      <option value="1">昇順</option>
      <option value="2">降順</option>
    </select>
    <input type="hidden" name="keyword" value="<?= $_GET['keyword'] ?>">
    <input type="submit" value="ソート">
  </form>

  <?php
    require_once('./dao/posts.php');
    $posts = new DAO_post;
    // require_once('./dao/users.php');
    // $users = new Users;
    require_once('./dao/good.php');
    $good = new Good;
    require_once('./dao/attached_tags.php');
    $attachedTags = new AttachedTags;

    //検索処理。検索結果がない場合は例外が投げられるので例外処理を行う
    try{
      switch ($_GET['sort_type']) {
        case 0:
          $result = $posts -> searchPostsByKeyword($_GET['keyword']);
          break;
        case 1: //ASC
          $result = $posts -> searchPostsByKeyword($_GET['keyword'], 1);
          break;
        case 2: //DESC
          $result = $posts -> searchPostsByKeyword($_GET['keyword'], 2);
          break;
      }

      echo '<script>';
      echo 'console.log(' . json_encode($result) . ')';
      echo '</script>';

      // for($i = 0; $i < 4; $i++){
      //   echo "<h3>$i</h3>";
      //   var_dump($result[$i]);
      //   echo '<hr>';
      // }

      foreach($result as $row) { 
  ?>

    <!-- 投稿者、タイトル、投稿日時 -->
    <div class="article_area">
      <form action="question-detail.php" method="GET">
      <input type="hidden" name="post_id" value="<?=$row['post_id']?>">
    <button class="result">          
    <p class="user2">
      <?= $users -> getUserNameById($row['user_id']) ?>
    </p>
    <p class="title">
      <?= $row['post_title'] ?>
    </p>
    <p class="day">
      <?= $row['post_time'] ?>
    </p>
    <!-- 付与されたタグ一覧 -->
    <div class="tag_area">
    <img src="./images/pin.png" alt="" class="img2">
    <?php
      try{
    ?>
      <?php foreach($attachedTags -> getAttachedTagsByPostId($row['post_id']) as $tag) : ?>
        <span><?= $tag['tag_name'] ?>,</span>
      <?php endforeach; ?>
    <?php
      }catch(Exception $e){
        echo 'タグなし';
      }catch(Error $e){
        echo 'タグなし';
      }
    ?>
    </div>
    <!-- いいね数 -->
         <div class="good_area">
                  <div class="good_img">
                    <img src="./images/good.png" alt="" class="img3">
                  </div>
                </div>
                <p class="good"><?= $good -> goodCount($row['post_id']) ?></p>
    </button>
    </form>
             
</div>
  <?php
      } //end foreach
    }catch(Exception $e){
      echo $e->getMessage();
    }
  ?>
</div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>