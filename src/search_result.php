<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>search-result</title>
</head>
<body>
  <h1>検索結果</h1>

  <?php
    require_once('./dao/posts.php');
    $posts = new DAO_post;
    require_once('./dao/users.php');
    $users = new Users;
    require_once('./dao/good.php');
    $good = new Good;
    require_once('./dao/attached_tags.php');
    $attachedTags = new AttachedTags;

    //検索処理。検索結果がない場合は例外が投げられるので例外処理を行う
    try{
      $result = $posts -> searchPostsByKeyword($_GET['keyword']);
      foreach($result as $row) { 
  ?>

    <!-- 投稿者、タイトル、投稿日時 -->
    <hr>
    <p><?= $users -> getUserNameById($row['user_id']) ?></p>
    <p><?= $row['post_title'] ?></p>
    <p><?= $row['post_time'] ?></p>
    <!-- 付与されたタグ一覧 -->
    <?php foreach($attachedTags -> getAttachedTagsByPostId($row['post_id']) as $tag) : ?>
      <span><?= $tag['tag_name'] ?>,</span>
    <?php endforeach; ?>
    <!-- いいね数 -->
    <p><?= $good -> goodCount($row['post_id']) ?></p>
    <hr>

  <?php
      } //end foreach
    }catch(Exception $e){
      echo $e->getMessage();
    }
  ?>

  
</body>
</html>