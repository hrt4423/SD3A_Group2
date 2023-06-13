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
    $posts = $posts -> searchPostsByKeyword($_GET['keyword']);
    var_dump($posts);
  ?>

  <br><a href="./search.php">戻る</a>
</body>
</html>