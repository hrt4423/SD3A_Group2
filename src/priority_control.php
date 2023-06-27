<?php
  //cronで1時間毎に実行する
  //decreasePostPriorityを呼び出す
  require_once('./dao/posts.php');
  $posts = new DAO_post;
  $posts -> decreasePostPriority();
?>