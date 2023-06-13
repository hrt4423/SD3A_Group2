<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>search-result</title>
</head>
<body>
  <p>検索結果</p>

  <?php
    require_once('./dao/posts.php');
    $posts = new DAO_post;
    $result = $posts -> searchPostsByKeyword($_GET['keyword']);
    //var_dump($posts);
    /**
     * 検索は記事と質問に絞る
     * 
     * 記事、質問のユーザー名取得
     * いいね数取得
     * タグ取得
     */
  ?>

  <?php foreach ($result as $row) : ?>
    <?php 
      echo "user_name: $row[user_id]<br>";
      echo "title: $row[post_title]<br>"; 
      echo "date: $row[post_time]<br>";
      echo"tag: ";
      echo "いいね数: ";
    ?>
  <?php endforeach; ?>

  <br><a href="./search.php">戻る</a>
</body>
</html>