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

  class AttachedTags{
    private function dbConnect(){
      //データベースに接続
      $pdo = new PDO('mysql:host=localhost; dbname=asoda; charset=utf8',
                      'root', 'root');
      return $pdo;
    }

    public function getAttachedTagsByPostId($postId){
      $pdo = $this -> dbConnect();
      //SQLの生成
      $sql = "SELECT T.tag_name
              FROM attached_tags as AT
              INNER JOIN tags as T 
              ON AT.tag_id = T.tag_id
              WHERE post_id=?";
      //prepare:準備　戻り値を変数に保持
      $ps = $pdo -> prepare($sql);

      //”？”に値を設定する。
      $ps->bindValue(1, $postId, PDO::PARAM_INT); 

      //SQLの実行
      $ps->execute();
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      if(empty($result)){
        return '指定したIDに該当するデータはありません。';
      }else{
        return $result;
      } 
    }
  }
?>