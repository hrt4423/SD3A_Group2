<?php 
  session_start(); 
  if(!isset($_GET['sort_type']))
    $_GET['sort_type'] = 0;
?>
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
  <link href="css/questiontimeline.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
  <link href="./css/header.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
  
  <!-- <script src="js/questiontimeline.js"></script> -->
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
    require_once './dao/posts.php';
    require_once './dao/users.php';
    require_once './dao/good.php';
    require_once './dao/attached_tags.php';
    require_once './dao/tags.php';
    

    $posts = new Posts;
    $users = new Users;
    $good = new Good;
    $attachedTags = new AttachedTags;
    $dao_tag = new DAO_tag;
    $tags = new Tags;

  }catch(Exception $ex){
    echo $ex->getMessage();
  }catch(Error $err){
    echo $err->getMessage();
  }

  try {
    //テーマカラ機能
    require_once './dao/theme_colors.php';
    $themeColors = new ThemeColors;
    if(isset($_SESSION['user_id'])){
      $currentThemeColorId =  $users->getThemeColorId($_SESSION['user_id']);
    }else{
      $currentThemeColorId = 1;
    }
    
    //質問を取得
    $result = $posts->fetchAllPostsByCategory(1, $_GET['sort_type']);
    //タグを取得
    $allTags = $dao_tag->tags();

    //絞り込み検索時の処理
    if(isset($_GET['tag-checkbox'])){
      $tagIds = $_GET['tag-checkbox'];
      $result = $attachedTags->filterPostByTag($tagIds);

      //検索しているタグの名前を取得
      foreach($tagIds as $tagId){
        $tagNames[] = $tags->getTagNameByTagId($tagId);
      }
    }
  }catch(Exception $ex){
    echo $ex->getMessage();
  }catch (Error $err){
    echo $err->getMessage();
  }
  

  //コンソールでの確認用
  echo '<script>';
  echo 'console.log(' . json_encode($allTags) . ')';
  echo '</script>';
?>
<script>
  //ページが読み込まれたときに チェックボックスをクリア
  $(document).ready(function(){
    $('input[name="tag-checkbox"]').prop('checked', false);
  });


  $(document).ready(function(){
    //タグがクリックされた時の処理
    $('input[name="tag-checkbox[]"]').change(function(){
      var selectedTags = [];

      $('input[name="tag-checkbox[]"]:checked').each(function(index, element){
        //チェックボックスのもつID（tags: tag_id）
        var tagId =  $(element).attr('id');

        //ラベルにtagIdを持たせる
        //ラベルのtagIdから対応するチェックボックスを検索できる

        var tagName = $('label[for="' + tagId + '"]').text();
        var tagElement = $('<div class="tag-view" id="' + tagId + '"></div>');
        tagElement.text(tagName);

        tagElement.append('<span class="remove-button">✕</span>');
        selectedTags.push(tagElement);
      });

      $('#selected-tags').html(
        selectedTags
      );

    });

    // タグ削除ボタンがクリックされた時の処理
    $(document).on('click', '.tag-view .remove-button', function() {
      $(this).closest('.tag-view').remove();
      
      //対応するチェックボックスのチェックを外す
      var relatedCheckboxId =  $(this).closest('.tag-view').attr('id');
      $('input[id="' + relatedCheckboxId + '"]').prop('checked', false);
    });

  });
</script>

<body id="body" class="container-fluid" 
  style="background-color: <?=$themeColors->getSubColorCode($currentThemeColorId) ?>
">

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
          <!-- ヘッダー修正
          横幅300px
          入れ子構造のdisplayflex追加
          inputタグcol-8に変更 -->

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
              echo '<a href="login.php" class="login_atag">ログイン</a>';
            }
          ?>
          </a>
          
          <div class="dropdown">
            <button class="btn btn-purple dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

  <div class="row">
    <!-- タグ検索 -->
    <div class="col-3" >
      <form action="./questiontimeline.php" method="GET" id="tag-filter-form"></form> 

      <div>
        <?php if(isset($tagNames)) foreach($tagNames as $tagName) : ?>
          <?= $tagName ?><span>, </span>
        <?php endforeach; ?>
        <?php 
          if(isset($tagNames)) echo '<span>での絞り込み結果</span>'; 
        ?>
      </div>

      <div id="selected-tags"></div>
      <button type="submit" form="tag-filter-form" class="btn btn-purple" id="filter-button">絞り込む</button>
      <hr>

      <?php 
        if(isset($allTags)) { 
      ?>
      <?php foreach($allTags as $tag) : ?>
        <div class="tag-element">
          <input 
            type="checkbox" 
            id="<?=$tag['tag_id']?>" 
            name="tag-checkbox[]"
            class="checkbox" 
            value="<?=$tag['tag_id']?>" 
            form="tag-filter-form"
          >
          <label for="<?=$tag['tag_id']?>" class="tag-name"><?=$tag['tag_name']?></label>
        </div>
      <?php endforeach; ?>
      <?php 
        } else { 
          echo 'タグがありません'; 
        } 
      ?>

      <hr>
    </div>
    <!-- /タグ検索 -->

    <!-- 質問一覧 -->
    <div class="col-6 pl-10">
      <div class="question_area">
        <?php 
          //質問データがある場合は表示
          if(isset($result)){
        ?>
        <?php foreach($result as $row) : ?>
          <div>
            <form action="question-detail.php" method="GET">
              <input type="hidden" name="post_id" value="<?=$row['post_id']?>">
              <button class="question">
                <p class="user2"> <?=$users->getUserNameById($row['user_id'])?> </p>

                <p class="day"> <?=$row['post_time']?>に投稿 </p>

                <p class="title"> <?=$row['post_title']?> </p>

                <div class="tag_area">
                  <img src="./images/pin.png" alt="" class="img2">
                  <?php
                    try{
                  ?>
                    <?php foreach($attachedTags -> getAttachedTagsByPostId($row['post_id']) as $tag) :?>
                      <span><?= $tag['tag_name'] ?>  </span>
                    <?php endforeach; ?>
                  <?php
                    }catch(Exception $ex){
                      echo 'タグなし';
                    }catch(Error $err){
                      echo 'タグなし';
                    }
                  ?>
                </div>
                
                <div class="good_area">
                  <div class="good_img">
                    <img src="./images/good.png" alt="" class="img3">
                  </div>
                </div>
                <p class="good"> <?=$good->goodCount($row['post_id'])?> </p>
              </button>   
            </form>
          </div>
        <?php endforeach; ?>
        <?php 
          } else { 
            echo '質問がありません'; 
          }
        ?>
      </div>
    </div>
    <!-- /質問一覧 -->

    <!-- ソート -->
    <div class="col-3 pr-0">
      <div class="sele_area2">
        <form action="./questiontimeline.php" method="get" id="sort-form">
          <div class="row">
            <div class="col-3 p-0 mr-3">
              <select name=sort_type class="select2 form-select">
                <option value="" disabled selected>
                  <?php
                    switch ($_GET['sort_type']) {
                      case 1:
                        echo '古い順';
                        break;
                      case 2:
                        echo '新着順';
                        break;
                      default:
                        echo 'デフォルト';
                        break;
                    }
                  ?>
                </option>
                <option value="0">デフォルト</a></option>
                <option value="1">古い順</a></option>
                <option value="2">新着順</a></option>
              </select>
            </div>
            <div class="col-6 p-0">
              <button type="submit" class="btn btn-purple ml-3">並び替え</button>
            </div>
          </div>

        </form>
      </div>
    </div>
    <!-- /ソート -->

  </div>
  
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>