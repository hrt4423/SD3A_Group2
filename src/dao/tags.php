<?php
  class tags {
    // DB接続設定
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "asoda";

    // タグの追加処理
    public function addTag($tagNames) {
        // タグ名が空の場合は処理しない
        if (empty($tagNames)) {
            return [];
        }

        // タグ名が文字列であれば配列に変換
        if (!is_array($tagNames)) {
            $tagNames = explode(',', $tagNames);
        }

        // データベース接続
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($conn->connect_error) {
            die("データベースへの接続に失敗しました: " . $conn->connect_error);
        }

        $tagIds = []; // 追加されたタグのtag_idを格納する配列

        foreach ($tagNames as $tagName) {
            // タグが既に存在するかチェック
            $existingTag = $this->getTagByName($tagName);
            if ($existingTag !== null) {
                // 既に存在する場合はそのタグのtag_idを整数に変換して配列に追加
                $tagIds[] = (int)$existingTag['tag_id'];
                continue;
            }

            // タグをデータベースに追加
            $sql = "INSERT INTO tags (tag_name) VALUES ('$tagName')";
            if ($conn->query($sql) === true) {
                echo "タグが追加されました: $tagName<br>";

                // 追加されたタグのtag_idを取得して整数に変換し、配列に追加
                $tagId = (int)$conn->insert_id;
                $tagIds[] = $tagId;
            } else {
                echo "タグの追加に失敗しました: " . $conn->error . "<br>";
            }
        }

        $conn->close();

        return $tagIds; // 追加または既存のタグのtag_idの配列を返す
    }

    // タグ名による既存タグの取得
    private function getTagByName($tagName) {
        // データベース接続
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($conn->connect_error) {
            die("データベースへの接続に失敗しました: " . $conn->connect_error);
        }

        // タグ名で検索
        $sql = "SELECT * FROM tags WHERE tag_name = '$tagName'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // 既存タグが見つかった場合はそのタグを返す
            $tag = $result->fetch_assoc();
            $conn->close();
            return $tag;
        } else {
            // 既存タグが見つからなかった場合は null を返す
            $conn->close();
            return null;
        }
    }
  }

  class DAO_tag{

    private function dbConnect(){
      $pdo = new PDO('mysql:host=localhost;dbname=asoda;charset=utf8','root','');
      return $pdo;
    }

    public function tags () {
      $pdo=$this->dbConnect();
      $sql = "SELECT * FROM tags ";
      $ps = $pdo->prepare($sql);
      $ps->execute();
      $search = $ps->fetchAll();
      return $search;
    }
  }

?>
