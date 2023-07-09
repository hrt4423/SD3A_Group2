
<?php
  require_once('./dao/attached_tags.php');
  $attachedTags = new AttachedTags();
  $tagIds = array(1, 2, 3);
  $result = $attachedTags->filterPostByTag($tagIds);

  echo '<script>';
  echo 'console.log(' . json_encode($result) . ')';
  echo '</script>';
?>


