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
</head>
<body>
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
    <h1>プロフィール編集</h1>
    <img src="<?= $userIconPath ?>" alt="ユーザアイコン" style="width: 30px;">
    
    <form action="./file_upload.php" method="post" enctype="multipart/form-data" id="file-upload">
      <p>アイコンを変更</p>
      <input type="file" name="file_upload" value="a">
      <input type="submit" value="アイコンを変更">
    </form>
    <hr>
    <form action="./submit_profile.php" method="post" id="profile-edit">
      <input type="text" name="user_name" value="<?= $userName ?>"><br>
      <input type="text" name="user_mail" value="<?= $userMail ?>"><br>
      <input type="text" name="user_pass" value="<?= $userPassword ?>"><br>
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
      </select><br>
      <textarea form="profile-edit" name="user_profile" placeholder="<?= $userProfile ?>"></textarea><br>
      <button type="submit" class="btn btn-primary" >変更</button>
    </form>
    <a href="./profile_question.php">戻る</a>
    
  </div>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>