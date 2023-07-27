<link href="css/submit_profile.css?<?php echo date('YmdHis'); ?>" rel="stylesheet">
<?php
  session_start();
  //プロフィールのアップデート処理
  require_once('./dao/users.php');
  $users = new Users;
  
  $id = $_SESSION['user_id'];

  try{
    $users->updateProfile($id, $_POST);
  }catch(PDOException $pdoE) {
    header('Refresh: 2; ./profile_edit.php');
    echo 'メールアドレスが重複しています。編集画面へ戻ります。';
    exit;
  }
  
  $users->updateProfile($id, $_POST);
  header('Refresh: 2; ./profile_question.php');
  echo '更新しました。プロフィール画面に戻ります';

?>