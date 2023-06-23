<?php
class attached_tags {
      // データベース接続設定
      private $servername = "localhost";
      private $username = "root";
      private $password = "";
      private $dbname = "asoda";

      // タグと投稿の関連付け
      public function addTags($post_id, $tagIds) {
          // データベース接続
          $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
          if ($conn->connect_error) {
              die("データベースへの接続に失敗しました: " . $conn->connect_error);
          }

          // 関連付けをデータベースに追加するためのプリペアドステートメントを作成
          $sql = "INSERT INTO attached_tags (post_id, tag_id) VALUES (?, ?)";
          $stmt = $conn->prepare($sql);

          // パラメータをバインド
          $stmt->bind_param("ii", $post_id, $tag_id);

          foreach ($tagIds as $tag_id) {
              // ステートメントを実行
              if ($stmt->execute()) {
                  echo "タグが投稿に関連付けられました: post_id=$post_id, tag_id=$tag_id<br>";
              } else {
                  echo "タグの関連付けに失敗しました: " . $stmt->error . "<br>";
              }
          }

          $stmt->close();
          $conn->close();
      }
  }
?>
