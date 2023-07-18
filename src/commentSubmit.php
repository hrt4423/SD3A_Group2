<?php session_start(); ?>
<?php
        require_once('./dao/Users.php');
        $users = new Users;
        // ユーザセッションがある場合はセッションを入れて処理を実行
        if (!empty($_SESSION['user_id'])) {
          $USESR_ID = $_SESSION['user_id'];
          $userIconPath = $users->getUserIconPathById($USESR_ID);
        }
?>
<?php
      try{
        require_once './DAO/posts.php';
        require_once './dao/good.php';
        require_once './dao/users.php';
        $postAll = new DAO_post();
        $findPost = new posts();
        $goodAll = new Good();
        $userAll = new Users();
        $post_id = $_POST['post_id'];
        $search = $postAll->post_detail($post_id);//記事や質問の投稿詳細
        // echo '<script>';
        // echo 'console.log(' . json_encode($search) . ')';
        // echo '</script>';
        $result = $postAll->post_return($post_id);//それに対する返信検索
        $coment1 = $result['coment1'];
        $coment2 = $result['coment2'];
        // echo '<script>';
        // echo 'console.log(' . json_encode($coment1) . ')';
        // echo '</script>';

        // echo '<script>';
        // echo 'console.log(' . json_encode($coment2) . ')';
        // echo '</script>';

        // echo '<script>';
        // echo 'console.log(' . json_encode($goodcount) . ')';
        // echo '</script>';

        $post = $findPost->findPostById($post_id);

        // $username = $userAll->getUserNameById($user_search);

        if (isset($_POST['commentSubmit'])) {
          $formIndex = $_POST['commentSubmit']; // 送信されたフォームのインデックスを取得
          $comment = $_POST['comment'][$formIndex]; // 対応するコメントの値を取得
          
          $postAll->insertpost($_POST['postID'], $comment, $USESR_ID, $post_id);
          
        }
        if(isset($_POST['answerSubmit'])){
              $postAll->insertpost($post_id, $_POST['comment_answer'], $USESR_ID, $post_id);
        }

        //タグ処理
        require_once './DAO/tags.php';
        $tagAll = new DAO_tag();
        //$tag = $tagAll->postTags($post_id);
        echo '<script>';
        echo 'console.log(' . json_encode($tag) . ')';
        echo '</script>';

        header("Location: question-detail.php?post_id=" . $post_id);
        exit(); // リダイレクト後にスクリプトの実行を終了する


      }catch(Exception $ex){
        echo $ex->getMessage();
      }catch(Error $err){
        echo $err->getMessage();
      }
    ?>