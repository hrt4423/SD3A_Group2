
<?php
  require_once('./dao/attached_tags.php');
  $attachedTags = new AttachedTags();
  $tagIds = array(1, 2, 3);
  $result = $attachedTags->filterPostByTag($tagIds);

  echo '<script>';
  echo 'console.log(' . json_encode($result) . ')';
  echo '</script>';
?>

<?php foreach($result as $row) : ?>
  <div>
    <p>ID: <?= $row['post_id'] ?></p>
    <p>post_time: <?= $row['post_time'] ?></p>
    <p>user_id: <?= $row['user_id'] ?></p>
    <p>post_detail: <?= $row['post_detail'] ?></p>
  </div>
<?php endforeach; ?>