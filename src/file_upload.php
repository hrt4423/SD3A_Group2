<?php
  session_start();
  require_once('./dao/users.php');
  $users = new Users;
  $USER_ID = $_SESSION['user_id'];

  //ファイル名を変更
  $newFileName = date("YmdHis"). "-". $_FILES['file_upload']['name'];
  //ファイルの保存先
  $upload_dir = './images/'. $newFileName;
  //アップロードのチェック
  if(move_uploaded_file($_FILES['file_upload']['tmp_name'], $upload_dir)){
    $users->updateUserIconPath($USER_ID, $upload_dir);
    header('Refresh: 3; URL=./profile_question.php');
    echo 'アップロードしました';
    //header('reflesh: 5; Location: ./profile_question.php');
  }else{
    header('Refresh: 5; URL=./profile_question.php');
    echo 'アップロードに失敗しました';
  }
?>