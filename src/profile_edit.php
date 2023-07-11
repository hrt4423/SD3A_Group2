<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <script src="https://cdn.jsdelivr.net/npm/markdown-it/dist/markdown-it.min.js"></script>
  <title>profile-edit</title>
  <style>
    .btn-primary{
      background-color: purple;
      color: white;
    }
      body {
          background-color: #FAEEFF;
          font-size: calc(16px + (24 - 16) * ((100vw - 320px) / (1920 - 320))); 
      }
      .square {
        background-color: #FFF;
        border-radius: 2vw;
      }
      .square2 {
        padding-left: 15vw; /* 左側の余白 */
        padding-right: 15vw; /* 右側の余白 */
      }
      input[type="file"] {
          display: none;
      }
      label {
        background-color: purple;
            color: white;
          cursor: pointer;
      }
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
<body >

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
<!-- ↑ヘッダー -->

  <?php
    require_once('./dao/Users.php');
    $users = new Users;
    $USESR_ID = $_SESSION['user_id'];
    $userIconPath = $users->getUserIconPathById($USESR_ID);
    $userData[] = $users->getUserDataById($USESR_ID);
    //var_dump($userData);
    $userName = $userData[0]['user_name'];
    $userMail = $userData[0]['user_mail'];
    $userPassword = $userData[0]['user_pass'];
    $userColor = $userData[0]['thema_color_id'];
    $userProfile = $userData[0]['user_profile'];
  ?>

  <div class="container-fluid">
    <h1 style="text-align:center;">プロフィール編集</h1>
    <hr>
    <div class="square2">
      <div style="display:flex;" class="square">
        <div style="width:5%;">
        </div>
          <div style="width:30%;">
            <img src="<?= $userIconPath ?>" alt="ユーザアイコン" style="width: 30px;" >
            <form action="./file_upload.php" method="post" enctype="multipart/form-data" id="file-upload">
              <p>アイコンを変更</p>
              <label >
                <input type="file" name="file_upload" value="a">ファイルを選択
              </label>
              <input type="submit" value="アイコンを変更">
            </form>
          </div>
          <form action="./submit_profile.php" method="post" id="profile-edit">
            <div class="container">
              <div class="row">
                <div class="col">
                  <p>ユーザ名</p>
                </div>
                <div class="col">
                  <input type="text" name="user_name" value="<?= $userName ?>">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <p>メールアドレス</p>
                </div>
                <div class="col">
                  <input type="text" name="user_mail" value="<?= $userMail ?>">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <p>パスワード</p>
                </div>
                <div class="col">
                  <input type="text" name="user_pass" value="<?= $userPassword ?>">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <p>カラー</p>
                </div>
                <div class="col">
                  <select name="thema_color_id">
                    <option value="1">Purple</option>
                    <option value="2">Blue</option>
                    <option value="3">Green</option>
                    <option value="4">Yellow</option>
                    <option value="5">Orange</option>
                    <option value="6">Red</option>
                    <option value="7">Pink</option>
                    <option value="8">White</option>
                    <option value="9">Black</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <textarea form="profile-edit" name="user_profile" placeholder="<?= $userProfile ?>"></textarea>
                </div>
              </div>
          </form>
          <div style="width:5%;">
          </div>
      </div>
    </div>
  </div>

  <br>
  <div style="text-align:center;">
    <button type="submit" class="btn btn-primary" form="profile-edit">変更</button> 
  </div>
  
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>