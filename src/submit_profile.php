<?php
  session_start();
  //プロフィールのアップデート処理
  require_once('./dao/users.php');
  $users = new Users;
  
  $id = $_SESSION['user_id'];

  try{
    $users->updateProfile($id, $_POST);
  }catch(PDOException $pdoE) {
    echo 'メールアドレスが重複しています。編集画面へ戻ります。';
    header('Refresh: 2; ./profile_edit.php');
    exit;
  }
  
  $users->updateProfile($id, $_POST);
  echo '更新しました。プロフィール画面に戻ります';
  header('Refresh: 2; ./profile_question.php');

?>