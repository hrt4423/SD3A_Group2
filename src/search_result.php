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
  ?>

  <?php foreach ($result as $row) : ?>
    <?php 
      echo "user_name: $row[user_id]<br>";
      echo "title: $row[post_title]<br>"; 
      echo "category_id: $row[post_category_id]";
    ?>
  <?php endforeach; ?>

  <br><a href="./search.php">戻る</a>
</body>
</html>