<?php
  session_start();
  $post_id = $_SESSION['post_id'];
  $USESR_ID = $_SESSION['user_id'];

  require_once('./dao/posts.php');
  $postAll = new DAO_post();

  //コメントのインサート処理
  if (isset($_GET['commentSubmit'])) {
    $formIndex = $_GET['commentSubmit']; // 送信されたフォームのインデックスを取得
    $comment = $_GET['comment'][$formIndex]; // 対応するコメントの値を取得
    
    $postAll->insertpost($_GET['postID'], $comment, $USESR_ID, $post_id);            
  }

  if(isset($_GET['answerSubmit'])){
    $postAll->insertpost($post_id, $_GET['comment_answer'], $USESR_ID, $post_id);
  }

  header("Location: question-detail.php?post_id=$post_id");
?>