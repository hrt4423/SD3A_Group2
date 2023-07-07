<?php
  class tags {
    //DB接続（推奨）
    private $pdo;
    public function __construct() {
      require_once('connection.php');
      $connection = new Connection();
      $this->pdo = $connection->dbConnect();
    }


  
    // タグの追加処理
    public function addTag($tagNames)
    {
        // タグ名が空の場合は処理しない
        if (empty($tagNames)) {
            return [];
        }

        // タグ名が文字列であれば配列に変換
        if (!is_array($tagNames)) {
            $tagNames = explode(',', $tagNames);
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
            $sql = "INSERT INTO tags (tag_name) VALUES (:tagName)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':tagName', $tagName, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "タグが追加されました: $tagName<br>";

                // 追加されたタグのtag_idを取得して整数に変換し、配列に追加
                $tagId = (int)$this->pdo->lastInsertId();
                $tagIds[] = $tagId;
            } else {
                echo "タグの追加に失敗しました: " . $stmt->errorInfo()[2] . "<br>";
            }
        }

        return $tagIds; // 追加または既存のタグのtag_idの配列を返す
    }

    // タグ名による既存タグの取得
    private function getTagByName($tagName)
    {
        $sql = "SELECT * FROM tags WHERE tag_name = :tagName";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':tagName', $tagName, PDO::PARAM_STR);
        $stmt->execute();

        $tag = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tag !== false) {
            return $tag; // 既存タグが見つかった場合はそのタグを返す
        } else {
            return null; // 既存タグが見つからなかった場合は null を返す
        }
    }

    
  }

  class DAO_tag{
    private $pdo;
    
    public function __construct() {
      require_once('connection.php');
      $connection = new Connection();
      $this->pdo = $connection->dbConnect();

    }

    public function tags () {
      $sql = "SELECT * FROM tags ";
      $ps = $this->pdo->prepare($sql);
      $ps->execute();
      $search = $ps->fetchAll();
      return $search;
    }

      public function postTags($post_id) {

        $sql = "
          SELECT tags.tag_name
          FROM tags
          INNER JOIN attached_tags ON tags.tag_id = attached_tags.tag_id
          WHERE attached_tags.post_id = :post_id
        ";

        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $ps->execute();
        $tags = $ps->fetchAll(PDO::FETCH_COLUMN);

        return $tags;
      }
      
  }

?>