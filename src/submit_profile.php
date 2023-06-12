<?php
    //プロフィールのアップデート処理
    require_once('./dao/Users.php');
    $users = new Users;
    //実際はsessionから取得する
    $id = 1;
    $users->updateProfile($id, $_POST);
    echo 'プロフィールを更新しました。';
    //header('Location: ./profile_question.php');
    header('Refresh: 5; ./profile_question.php');

?>