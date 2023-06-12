<?php
    //プロフィールのアップデート処理
    require_once('./dao/Users.php');
    $users = new Users;
    //実際はsessionから取得する
    $id = 1;
    $users->updateProfile($id, $_POST);
    header('Location: ./profile_question.php');

?>