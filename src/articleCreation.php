<?php session_start(); ?>
<?php
        require_once('./dao/Users.php');
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
<?php

  require_once './dao/connection.php';
  $connection = new Connection();
  $connection->getPdo();
  $connection->getHostname();
  $connection->getUsername();
  $connection->getPassword();
  $connection->getDbname();
  $connection->getDsn();

  // データベース接続情報
  $servername = $connection->getHostname();
  $username = $connection->getUsername();
  $password = $connection->getPassword();
  $dbname = $connection->getDbname();

  // データベースに接続する関数
  function connectToDatabase()
  {
      global $servername, $username, $password, $dbname;

      // データベース接続
      $conn = new mysqli($servername, $username, $password, $dbname);

      // 接続エラーの確認
      if ($conn->connect_error) {
          die("データベース接続エラー: " . $conn->connect_error);
      }

      return $conn;
  }

  // データベース接続
  $conn = connectToDatabase();

  require_once './dao/posts.php';
  require_once './dao/tags.php';
  require_once './dao/attached_tags.php';
  $postClass = new posts();
  $tagClass = new tags($servername, $username, $password, $dbname); 
  $attachedClass = new attached_tags($servername, $username, $password, $dbname);

  if(isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    try {
      $dbh = new PDO($dsn, $user, $password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // クエリの準備
      $sql = "SELECT *
              FROM posts
              WHERE post_id = :post_id";
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        // エラーハンドリング
        echo 'Error: ' . $e->getMessage();
        die();
    }


  }
  



  if (isset($_POST['submit'])) {
      // ボタンがクリックされたときの処理をここに記述する
      $title = $_POST['title'];
      $detail = $_POST['htmlText'];
      $post_detail_markdown = $_POST['detail_textArea'];

      //質問は優先表示機能を使わないので、優先表示の値は0にする
      //$postPriority = isset($_POST['post_priority']) ? $_POST['post_priority'] : '';
      $post_priority = 0;

      // if ($postPriority) {
      //     $post_priority = 72;
      // } else {
      //     $post_priority = 24;
      // }

      //ここにセッションIDいれてほしい
      $user_id = $USESR_ID;

      //記事のID
      $post_category_id = 2;

      // 投稿を挿入し、post_idを取得
      $post_id = $postClass->insertPosts($title, $detail, $user_id, $post_priority, $post_category_id,$post_detail_markdown);

      // タグを追加
      $tagValues = $_POST['tagValues'];
      $tagIds = $tagClass->addTag($tagValues);

      // タグを投稿に関連付ける
      $attachedClass->addTags($post_id, $tagIds);


      ob_start(); // バッファリングを開始
      header("Location: questiontimeline.php");
      exit();
      ob_end_flush(); // バッファの内容を出力
  }
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>質問作成画面</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/markdown-it/dist/markdown-it.min.js"></script>
    <style>
      body {
        background-color: #faeeff;
      }
      .btn-purple {
        background-color: #653a91;
        border-color: #653a91;
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
        /* background-color: #653a91; */
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
        border-bottom: 10px solid #653a91;
        text-decoration: none;
      }

      a:hover {
        color: white;
        border-bottom: none;
        text-decoration: none;
      }

      .title {
        border-color: #a42fcd;
        margin-top: 20px;
        width: 90%;
        margin-left: auto;
        margin-right: auto;
        height: 50px;
        font-size: 20px;
      }

      .main {
        border-color: #a42fcd;
        margin-top: 20px;
        width: 50%;
        height: 50px;
        font-size: 20px;
      }

      .preview {
        border: 1px solid #a42fcd;
        margin-top: 20px;
        background-color: #fffdfd;
        width: 600px;
        padding-top: 8px;
        padding-left: 8px;
      }

      .yoko {
        display: flex;
        width: 90%;
        margin-left: auto;
        margin-right: auto;
      }

      .blacktext {
        margin-left: 5%;
        margin-top: 20px;
        font-size: 25px;
        font-weight: bold;
      }

      .track {
        position: relative;
        width: 100px;
        height: 35px;
        background-color: #ffffff;
        border-radius: 25px;
        overflow: hidden;
        border: 1px solid #a0a0a0;
        margin-top: 20px;
        margin-left: 30px;
      }

      .track-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 12px;
        color: black;
        text-align: center;
        text-transform: uppercase;
        font-weight: bold;
      }

      .custom-button {
        background-color: #653a91;
        color: #ededed;
        margin-top: 20px;
        height: 50px;
        width: 300px;
        font-weight: bold;
        font-size: 25px;
        margin-left: 38%;
        /* margin-right: auto; */
      }

      .custom-button:hover {
        color: #ededed;
      }

      .custom-point-button {
        background-color: #5754ff;
        height: 50px;
        width: 50px;
        font-size: 25px;
        margin-top: 20px;
        margin-left: 30px;
      }

      .point-text {
        margin-top: 20px;
        text-align: center;
      }

      .tag {
            display: inline-block;
            margin-right: 5px;
            padding: 5px;
            background-color: #ffffff;
            border-radius: 5px;
            margin-top: 5px;
        }
        .tag span {
            margin-left: 20px;
            cursor: pointer;
            margin-top: 5px;
        }
        .tag:nth-of-type(1) {
          margin-left: 5%;
        }
        .tag-input {
          margin-left: 5%;
          margin-top: 10px;
          width: 20%;
        }
        .tag-select {
          margin-top: 10px;
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
        <a href="./classroom2.html" class="underline text">空き教室</a>
      </div>
      </div>
    <!-- ここまでがヘッダー -->


    <form action="articleCreation.php" method="post">
      <input type="text" class="form-control title" name="title" placeholder="タイトル" />

    <!-- <input type="text" id="tag-input" class="tag-input" placeholder="タグを入力してください"> -->
    <div style="display: flex;">
      <input class="form-control tag-input" id="tag-input" type="text" placeholder="タグを入力してください">
      <!-- <button id="add-tag-btn" type="button">追加</button> -->
      <button type="button"  id="add-tag-btn" class="btn btn-secondary tag-select">追加</button>

      <select id="tag-select"  class="form-select tag-select" aria-label="Default select example">

      <option value="" disabled selected>タグ候補</option>
        <?php
                // タグ候補の取得
                $sql = "SELECT tag_name FROM tags";
                $result = $conn->query($sql);

                // タグ候補を<option>タグとして表示
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tagName = $row["tag_name"];
                        echo '<option value="' . $tagName . '">' . $tagName . '</option>';
                    }
                }
                // データベース接続を閉じる
                $conn->close();
              ?>
      </select>
    </div>

    <div id="tag-container"></div>

    <script>
        $(document).ready(function() {
            // ボタンがクリックされた時の処理
            $('#add-tag-btn').click(function() {
                var tag = $('#tag-input').val();
                addTag(tag);
            });

            // プルダウンの選択が変更された時の処理
            $('#tag-select').change(function() {
                var selectedTag = $(this).val();
                if (selectedTag !== '') {
                    addTag(selectedTag);
                }
            });

            // タグ削除ボタンがクリックされた時の処理
            $(document).on('click', '.tag span', function() {
                $(this).closest('.tag').remove();
            });

            // フォームがサブミットされた時の処理
            $('form').submit(function() {
                var tagValues = [];
                $('.tag').each(function() {
                    var tagValue = $(this).text().trim();
                    tagValues.push(tagValue);
                });

                // 隠しフィールドの値を更新
                $('#tag-values-container').empty();
                for (var i = 0; i < tagValues.length; i++) {
                    var tagValue = tagValues[i];
                    var inputTag = $('<input type="hidden">')
                        .attr('name', 'tagValues[]')
                        .val(tagValue);
                    $('#tag-values-container').append(inputTag);
                }
            });
        });

      // タグを追加する関数
      function addTag(tag) {
          var tagElement = $('<div class="tag"></div>');
          tagElement.text(tag);

          var removeButton = $('<span>×</span>');
          tagElement.append(removeButton);
          tagElement.append('<input type="hidden" name="tagValues[]" value="' + tag + '">'); // name属性を追加

          $('#tag-container').append(tagElement);
          $('#tag-input').val('');
      }
    </script>

    <div class="yoko">
      <textarea
        class="form-control main"
        rows="8"
        placeholder="本文"
        name="detail_textArea"
        id="detail_textArea"
      ></textarea>
      <div  name="previewHTML" class="preview">プレビュー</div>
    </div>
    
    <div class="d-flex">
      <button name="submit" id="button" class="justify-content-center btn custom-button">投稿する</button>
      <!-- 記事は優先表示機能を実装しない
      <input type="checkbox" name="post_priority" id="toggleButton" data-toggle="toggle" data-on="ON" data-off="OFF" class="btn custom-point-button">
      <div class="point-text">ポイントを消費して<br />質問を優先表示</div> -->
    </div>
    <input style="display: none;" value="" name="htmlText" id="HTML">
   
  </form>


    <script>
      $(document).ready(function () {
        // リンクをクリックした時の処理
        $(".underline").click(function (e) {
          e.preventDefault(); // デフォルトのリンク遷移を防止

          // すでにアクティブなリンクがある場合、その下線を消す
          $(".underline.active").removeClass("active");
          // クリックされたリンクに下線をつける
          $(this).addClass("active");
        });
      });

      // DOMの読み込みが完了した時点で実行
      document.addEventListener("DOMContentLoaded", function () {
        // 左側のtextarea要素を取得
        const leftTextarea = document.querySelector(
          ".yoko textarea:nth-of-type(1)"
        );
        // プレビューエリアの要素を取得
        const previewArea = document.querySelector(".yoko .preview");

        // MarkdownからHTMLへの変換関数を定義
        function convertMarkdownToHTML(markdown) {
          const md = window.markdownit(); // markdown-itインスタンスを作成
          return md.render(markdown);
        }

        // 左側のtextareaの入力イベントを監視
        leftTextarea.addEventListener("input", function () {
          // MarkdownテキストをHTMLに変換してプレビューエリアに表示
          const markdownText = this.value;
          const htmlText = convertMarkdownToHTML(markdownText);
          previewArea.innerHTML = htmlText;
          const convertButton = document.getElementById("button");
          convertButton.addEventListener("click", function () {
            const textareaElementSend = document.getElementById('detail_textArea');
            const markdownTextSend = textareaElementSend.value;
            const htmlTextSend = convertMarkdownToHTML(markdownTextSend);
            

            const contentDiv = document.getElementById('HTML');
            contentDiv.value = htmlTextSend;
          });
        });
      });

      function HTMLSend(){
        const textareaElementSend = document.getElementById('detail_textArea');
        const markdownTextSend = textareaElementSend.value;
        const htmlTextSend = convertMarkdownToHTML(markdownTextSend);

        const contentDiv = document.getElementById('HTML');
        contentDiv.innerHTML = htmlTextSend;
      }
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
