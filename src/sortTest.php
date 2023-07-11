
<?php
  require_once('./dao/attached_tags.php');
  $attachedTags = new AttachedTags();
  $tagIds = array(1, 2, 3);
  $result = $attachedTags->filterPostByTag($tagIds);

  echo '<script>';
  echo 'console.log(' . json_encode($result) . ')';
  echo '</script>';
?>

<?php foreach($result as $row):?>
  <p>id: <?= $row['post_id'] ?></p>
  <p>date: <?= $row['post_time'] ?></p>
  <p>title: <?= $row['post_title'] ?></p>
  <p>detail: <?= $row['post_detail'] ?></p>
  <hr>
<?php endforeach;?>


