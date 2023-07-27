<?php session_start(); ?>
<?php
  require_once('./dao/users.php');
  $users = new Users;
  // ユーザセッションがある場合はセッションを入れて処理を実行
  if (!empty($_SESSION['user_id'])) {
    $USESR_ID = $_SESSION['user_id'];
    $userIconPath = $users->getUserIconPathById($USESR_ID);
  }
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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--BootStrap CDN-->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <!--BootStrap icon CDN-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css"
    />
    <!-- css -->
    <link rel="stylesheet" href="./css/question-detail.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="./css/header.css">
    <script src="https://cdn.jsdelivr.net/npm/markdown-it/dist/markdown-it.min.js"></script>
    <title>質問詳細画面</title>
    <style>
      body {
        background-color: #faeeff;
      }
      .preview-button {
        background-color: #b164ff;
        color: #fff;
      }

      .preview-button:hover {
        background-color: #b164ff;
        border-color: #b164ff;
        color: #fff;
      }

      .styled-output {
        background-color: #fff;
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
  <body style="background-color: <?=$themeColors->getSubColorCode($currentThemeColorId) ?>">
    <!-- ここからがヘッダー -->
      <div class="header_size" style="background-color: <?=$themeColors->getThemeColorCode($currentThemeColorId)?> ;">
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
        <a href="./questiontimeline.php" class="underline text">質問</a>
        <a href="./articlelist.php" class="underline text">記事</a>
        <a href="./Ranking.php" class="underline text">ランキング</a>
        <a href="./classroom2.html" class="underline text">空き教室</a>
      </div>
      </div>
    <!-- ここまでがヘッダー -->

    <?php
      try{
        require_once './dao/posts.php';
        require_once './dao/good.php';
        //require_once './dao/users.php';
        $postAll = new DAO_post();
        $findPost = new posts();
        $goodAll = new Good();
        //$userAll = new Users();
        if(isset($_GET['post_id']))
          $_SESSION['post_id'] = $_GET['post_id'];

        $post_id = $_SESSION['post_id'];

        //コメントのインサート処理
        if (isset($_POST['commentSubmit'])) {
          $formIndex = $_POST['commentSubmit']; // 送信されたフォームのインデックスを取得
          $comment = $_POST['comment'][$formIndex]; // 対応するコメントの値を取得
          
          $postAll->insertpost($_POST['postID'], $comment, $USESR_ID, $post_id);
          
        }
        if(isset($_POST['answerSubmit'])){
          $postAll->insertpost($post_id, $_POST['comment_answer'], $USESR_ID, $post_id);
        }

        //投稿、コメントの表示
        $search = $postAll->post_detail($post_id);//記事や質問の投稿詳細
        $result = $postAll->post_return($post_id);//それに対する返信検索
        $coment1 = $result['coment1'];
        $coment2 = $result['coment2'];
        

        $post = $findPost->findPostById($post_id);

        // $username = $userAll->getUserNameById($user_search);

        

        //タグ処理
        require_once './dao/tags.php';
        $tagAll = new DAO_tag();

        //---------------------------------------------------------------------------------------------
        echo '<script>';
        echo 'console.log(' . json_encode($search) . ')';
        echo '</script>';

        echo '<script>';
        echo 'console.log(' . json_encode($coment1) . ')';
        echo '</script>';

        echo '<script>';
        echo 'console.log(' . json_encode($coment2) . ')';
        echo '</script>';
        // $count_search = $coment[0]['post_id'];
        // $user_search = $coment[0]['user_id'];

        // $goodcount = $goodAll->goodCount($count_search);//それに対する返信のgoodcount
        echo '<script>';
        echo 'console.log(' . json_encode($goodcount) . ')';
        echo '</script>';

        //$tag = $tagAll->postTags($post_id);
        echo '<script>';
        echo 'console.log(' . json_encode($tag) . ')';
        echo '</script>';

      }catch(Exception $ex){
        echo $ex->getMessage();
      }catch(Error $err){
        echo $err->getMessage();
      }
    ?>

    <div class="card">
      <div class="card-body">
        <div id="user-info-post-date" class="row">
          <div name="user-info" class="col-3">
            <span name="user-icon"><i class="bi bi-person-circle"></i></span>
            <span name="user-rank"><i class="bi bi-gem"></i></span>
            <span name="user-name"><?php echo $search[0]['user_name'] ?></span>
          </div>

        <div style="display: flex;">
        <div class="col-3 offset-md-8 text-center"><?php echo $search[0]['post_time'] ?></div>
          <!-- ボタンの位置 -->
          <div class="text-center">

          <!-- 編集：フォーム -->
          <form method="POST" action="questionArticle_edit.php">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <?php
              if ($post['user_id'] === $USESR_ID){
                echo '<button class="btn" id="edit" type="submit">編集</button>';
              }
            ?>
            <!-- <button class="btn" id="edit" type="submit">編集</button> -->
          </form>

            <br />
            <div class="good">

              <!-- いいね：フォーム -->
              <!-- 記事に対するいいね処理 ↓-->
              <form method="POST" action="goodinsert.php">
                <input type="hidden" name="post_id" value="<?php echo $post_id?>">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'];?>">
                <input type="hidden" name="user_point_id" value="<?php echo $search[0]['user_id'];?>">
                <button class="btn" id="good" type="submit">
                <i name="good-button" class="bi bi-hand-thumbs-up-fill"></i>
                  <span id="good-amount"><?php echo $search[0]['good_count'] ?></span>
                </button>
              </form>
            </div>
          </div>
        </div>

        </div>
        <div class="row">
          <div class="col-9">
            <div class="card-title">
              <h4 class="text-center"><?php echo $search[0]['post_title'] ?></h4>
              </div>
              <div name="card-tags">
                <i class="bi bi-tags"></i>
                <?php 
                  try{
                ?>
                  <?php foreach ($tagAll->postTags($post_id) as $tag): ?>
                    <span class="tag"><?php echo $tag; ?></span>
                  <?php endforeach; ?>
                <?php 
                  }catch(Exception $ex){
                    echo 'タグなし';
                  }catch(Error $err){
                    echo 'タグなし';
                  }
                ?>
              </div>

            <p class="card-text"><?php echo $search[0]['post_detail'] ?></p>

            <div class="reply-area">
              <h5>--回答--</h5>
              <div name="reply-card" class="card" id="card-reply-area">

            <!--回答１-->
            <div class="card-body">
              <div class="card-title"></div>

              <?php foreach ($coment1 as $index => $item): ?>
                <div name="user-info">
                  <!--投稿者の情報-->
                  <span name="user-icon"><i class="bi bi-person-circle"></i></span>
                  <span name="user-rank"><i class="bi bi-gem"></i></span>
                  <span name="user-name"><?php echo $item['user_name']; ?></span>
                </div>
                <!--いいねボタン-->
                <!--/いいねボタン-->

                <div class="card-text">
                  <!--回答文-->
                  <?php echo $item['post_detail']; ?>
                </div>

                <div class="card-text">
                <!--コメント文-->
                <!-- ***コメント<?php echo $index + 1; ?>*** -->

                <?php if ($item['destination_post_id'] !== null && $item['post_id'] === $item['destination_post_id']): ?>
                  <hr id="border-line-reply" />
                <?php endif; ?>

                <?php foreach ($coment2 as $index2 => $item2): ?>
                  <?php if ($item['post_id'] === $item2['destination_post_id']): ?>
                    <!-- 同じ投稿に関連するコメントを表示する部分のコード -->
                    <div name="user-info">
                      <!--投稿者の情報-->
                      <span name="user-icon"><i class="bi bi-person-circle"></i></span>
                      <span name="user-rank"><i class="bi bi-gem"></i></span>
                      <span name="user-name"><?php echo $item2['user_name']; ?></span>
                    </div>
                    <div class="card-text">
                      <!--回答文-->
                      <?php echo $item2['post_detail']; ?>
                    </div>
                    <!-- 返信フォームなどの表示 -->
                  <?php endif; ?>

                <?php endforeach; ?>

                <!-- ここまで -->
                <div class="comment-write-area">

                  <!--コメント入力フォーム-->
                  <form action="question-detail.php?post_id=<?=$post_id?>" method="post" id="comment-form-<?php echo $index + 1; ?>">
                    <!-- ここの値のIDをPHPで動的に与えてあげてください comment-text-area-1 -->
                    <div class="form-floating" id="comment-text-area-<?php echo $index + 1; ?>">
                      <?php if ($item['destination_post_id'] !== null): ?>
                        <input value="<?php echo $item['post_id']; ?>" name="postID" style="display:none">
                      <?php endif; ?>
                      <textarea
                        class="form-control"
                        placeholder=""
                        id="comment"
                        name="comment[<?php echo $index + 1; ?>]"
                        form="comment-form-<?php echo $index + 1; ?>"
                        style="height: 150px"
                      ></textarea>
                      <label for="">返信</label>
                      <div class="styled-output"></div>
                    </div>
                    <div style="display: flex">
                      <button
                        type="button"
                        class="btn preview-button"
                        data-toggle="button"
                        aria-pressed="false"
                        autocomplete="off"
                        onclick="convertToMarkdown(<?php echo $index + 1; ?>)"
                      >
                        プレビュー
                      </button>

                      <div class="comment-write-area-button">
                        <label id="upload-image-icon">
                          <input type="file" name="file" />
                          <button class="btn btn-outline-dark">
                            <i class="bi bi-card-image"></i>
                          </button>
                        </label>
                        <button
                          type="submit"
                          class="btn btn-outline-dark"
                          id="send-icon"
                          name="commentSubmit"
                          value="<?php echo $index + 1; ?>"
                        >
                          <i class="bi bi-send"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                <!--/コメント入力欄-->
              </div>
              <?php endforeach; ?>
            </div>
                <!---card-body-->
              </div>
              <!--/回答１-->
          </div>
          </div>
          <!-- 基のボタンの場所 -->
        </div>
      </div>
    </div>

    <div class="answer-write-area">
      <!--回答入力フォーム-->
      <form action="question-detail.php?post_id=<?=$post_id?>" method="post" id="comment-form">
        
        <div class="form-floating" id="comment-text-area-3">
          <textarea
            class="form-control"
            placeholder=""
            id="text-area-3"
            name="comment_answer"
            form="comment-form"
            style="height: 150px"
          ></textarea>
          <label for="text-area-3">回答</label>
          <div class="styled-output"></div>
        </div>

        <div style="display: flex">
          <button
            type="button"
            class="btn preview-button"
            data-toggle="button"
            aria-pressed="false"
            autocomplete="off"
            onclick="convertToMarkdown(3)"
          >
            プレビュー
          </button>

          <div class="comment-write-area-button">
            <label id="upload-image-icon">
              <input type="file" name="file" />
              <button class="btn btn-outline-dark">
                <i class="bi bi-card-image"></i>
              </button>
            </label>
            <button type="submit" class="btn btn-outline-dark" id="send-icon" name="answerSubmit">
              <i class="bi bi-send"></i>
            </button>
          </div>
        </div>
      </form>

      <!--answer-write-area-button-->
    </div>
    <!--/回答入力欄-->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <script>
      // $(document).ready(function () {
      //   // リンクをクリックした時の処理
      //   $(".underline").click(function (e) {
      //     e.preventDefault(); // デフォルトのリンク遷移を防止

      //     // すでにアクティブなリンクがある場合、その下線を消す
      //     $(".underline.active").removeClass("active");
      //     // クリックされたリンクに下線をつける
      //     $(this).addClass("active");
      //   });
      // });

      function convertToMarkdown(textAreaIndex) {
        var textarea = document.getElementById("text-area-" + textAreaIndex);
        var styledOutput = document.querySelector(
          "#comment-text-area-" + textAreaIndex + " .styled-output"
        );

        if (!textarea || !styledOutput) {
          console.error("テキストエリアに文字が入力されてないません");
          return;
        }

        var input = textarea.value;

        if (input) {
          var md = window.markdownit();
          var result = md.render(input);

          styledOutput.innerHTML =
            '<div style="border: 1px solid #ced4da; padding: 10px; margin-top: 10px;">' +
            result +
            "</div>";
        }
      }

      function deletePreview() {
        var div = document.getElementById("styled-output");
        div.classList.toggle("active");
      }


    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
