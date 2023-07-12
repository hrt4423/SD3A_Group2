<?php
  class Posts {
    private $pdo;
    private $hostname;
    private $username;
    private $password;
    private $dbname;
    private $dsn;
    
    public function __construct() {
      require_once('connection.php');
      $connection = new Connection();
      $this->pdo = $connection->getPdo();
      $this->hostname = $connection->getHostname();
      $this->username = $connection->getUsername();
      $this->password = $connection->getPassword();
      $this->dbname = $connection->getDbname();
      $this->dsn = $connection->getDsn();
    }    

    public function insertPosts($title, $detail, $user_id, $post_priority, $post_category_id) {
      // 検索
      $sql = "INSERT INTO posts (user_id,
                                post_category_id,
                                post_time,
                                post_title,
                                post_detail,
                                post_priority
                                ) 
              VALUES (:user_id,
                      :post_category_id, 
                      :post_time,
                      :post_title,
                      :post_detail,
                      :post_priority
                    )";

      // プリペアドステートメントを作成
      $stmt = $this->pdo->prepare($sql);

      // 日時をセット
      $post_time = date("Y-m-d H:i:s");

      // パラメータをバインド
      $stmt->bindParam(':user_id', $user_id);
      $stmt->bindParam(':post_category_id', $post_category_id);
      $stmt->bindParam(':post_time', $post_time);
      $stmt->bindParam(':post_title', $title);
      $stmt->bindParam(':post_detail', $detail);
      $stmt->bindParam(':post_priority', $post_priority);

      // ステートメントを実行
      $stmt->execute();

      $post_id = (int)$this->pdo->lastInsertId(); // 最後に挿入されたレコードのIDを整数(int)として取得

      try {
          echo "データが正常に挿入されました。";
      } catch (PDOException $e) {
          echo "エラー: " . $e->getMessage();
      }

      return $post_id; // $post_idを整数(int)として返す
    }

    public function insertpost($title, $detail, $user_id, $post_priority) {
      try {
          $dbh = new PDO($this->dsn, $this->username, $this->password);
      } catch (PDOException $e) {
          print('Error:' . $e->getMessage());
          die();
      }

      // テスト検索
      $sql = "INSERT INTO posts (user_id,
                                post_category_id,
                                post_time,
                                post_title,
                                post_detail,
                                post_priority
                                ) 
              VALUES (:user_id,
                      :post_category_id, 
                      :post_time,
                      :post_title,
                      :post_detail,
                      :post_priority
                    )";

      // プリペアドステートメントを作成
      $stmt = $dbh->prepare($sql);

      // 値をセット
      $post_category_id = 1;
      $post_time = date("Y-m-d H:i:s");

      // パラメータをバインド
      $stmt->bindParam(':user_id', $user_id);
      $stmt->bindParam(':post_category_id', $post_category_id);
      $stmt->bindParam(':post_time', $post_time);
      $stmt->bindParam(':post_title', $title);
      $stmt->bindParam(':post_detail', $detail);
      $stmt->bindParam(':post_priority', $post_priority);

      // ステートメントを実行
      $stmt->execute();

      $post_id = (int)$dbh->lastInsertId(); // 最後に挿入されたレコードのIDを整数(int)として取得

      try {
          echo "データが正常に挿入されました。";
      } catch (PDOException $e) {
          echo "エラー: " . $e->getMessage();
      }

      return $post_id; // $post_idを整数(int)として返す
    }

    public function fetchAllPostsByCategory(int $category, int $sortType = 0) {
      switch ($sortType) {
        case 1:
          //古い順
          $sql = "SELECT * FROM posts WHERE post_category_id = ? 
                  ORDER BY post_time ASC";
          break;

        case 2:
          //新着順
          $sql = "SELECT * FROM posts WHERE post_category_id = ? 
                  ORDER BY post_time DESC";
          break;

        default:
          //優先度順
          $sql = "SELECT * FROM posts WHERE post_category_id = ? 
                  ORDER BY  post_priority DESC, post_time DESC";
          break;
      }
      //prepare:準備　戻り値を変数に保持
      $ps = $this->pdo -> prepare($sql);

      //”？”に値を設定する。
      $ps->bindValue(1, $category, PDO::PARAM_INT); 

      //SQLの実行
      $ps->execute();
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      if(empty($result)){
        throw new Exception('キーワードに該当する投稿はありませんでした');
      }else{
        return $result;
      }
    }

    //引数で指定したIDの投稿を取得。該当する投稿がない場合は例外を投げる。
    public function findPostById($postId){
      $sql = "SELECT * FROM posts WHERE post_id = ?";
  
      $ps = $this->pdo->prepare($sql);
      $ps->bindValue(1, $postId, PDO::PARAM_INT); 
      $ps->execute();
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      //1次元の連想配列をかえす
      if(empty($result)){
        throw new Exception('キーワードに該当する投稿はありませんでした');
      }else{
        foreach($result as $row){
          $postRecord = $row;
        }
        return $postRecord;
      }
    }
  }      

  class DAO_post{
    //DB接続（推奨）
    private $pdo;
    public function __construct() {
      require_once('connection.php');
      $connection = new Connection();
      $this->pdo = $connection->getPdo();
    }

    public function post () {
      $sql = "SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
      FROM posts 
      JOIN users ON posts.user_id = users.user_id
      LEFT JOIN goods ON posts.post_id = goods.post_id
      WHERE posts.post_category_id=1
      GROUP BY posts.post_id";
      $ps = $this->pdo->prepare($sql);
      $ps->execute();
      $search = $ps->fetchAll();
      //$count = count($search);
      return $search;
    }

    public function prof_post () {
      $id=$_SESSION['user_id'];
      $sql = "SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
      FROM posts 
      JOIN users ON posts.user_id = users.user_id
      LEFT JOIN goods ON posts.post_id = goods.post_id
      WHERE posts.post_category_id=1 AND users.user_id=?
      GROUP BY posts.post_id";
      $ps = $this->pdo->prepare($sql);
      $ps->execute([$id]);
      $search = $ps->fetchAll();
      //$count = count($search);
      return $search;

    }
    public function prof_kizi_post () {
      $id=$_SESSION['user_id'];
      $sql = "SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
      FROM posts 
      JOIN users ON posts.user_id = users.user_id
      LEFT JOIN goods ON posts.post_id = goods.post_id
      WHERE posts.post_category_id=2 AND users.user_id=?
      GROUP BY posts.post_id";
      $ps = $this->pdo->prepare($sql);
      $ps->execute([$id]);
      $search = $ps->fetchAll();
      //$count = count($search);
      return $search;

    }
    public function prof_coment_post () {
      $id=$_SESSION['user_id'];
      $sql = "SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
      FROM posts 
      JOIN users ON posts.user_id = users.user_id
      LEFT JOIN goods ON posts.post_id = goods.post_id
      WHERE posts.post_category_id=3 AND users.user_id=?
      GROUP BY posts.post_id";
      $ps = $this->pdo->prepare($sql);
      $ps->execute([$id]);
      $search = $ps->fetchAll();
      //$count = count($search);
      return $search;

    }
    public function post_detail($id) {    
      $sql = "
        SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
        FROM posts
        LEFT JOIN users ON posts.user_id = users.user_id
        LEFT JOIN goods ON posts.post_id = goods.post_id
        WHERE posts.post_id = :id
        GROUP BY posts.post_id
      ";
    
      $ps = $this->pdo->prepare($sql);
      $ps->bindValue(':id', $id, PDO::PARAM_INT);
      $ps->execute();
      $search = $ps->fetchAll();
    
        // ユーザー名を取得するクエリを追加
         // Retrieve all user information
         $userSql = "SELECT * FROM users WHERE user_id = :userId";
         $userPs = $this->pdo->prepare($userSql);
         $userPs->bindValue(':userId', $id, PDO::PARAM_INT);
         $userPs->execute();
         $userSearch = $userPs->fetchAll();
    
        if (!empty($userSearch)) {
          $search[0]['user_info'] = $userSearch;

          // goodテーブルのレコード数を取得するクエリを追加
            $goodSql = "SELECT COUNT(*) AS count FROM goods WHERE post_id = $id";
            $goodPs = $this->pdo->prepare($goodSql);
            $goodPs->execute();
            $goodSearch = $goodPs->fetch();

              if (!empty($goodSearch)) {
                $search[0]['good_count'] = $goodSearch['count'];
              }
        }
        return $search;
      }
      
    

    public function post_return($id) {
      $sql1 = "
        SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
        FROM posts
        LEFT JOIN users ON posts.user_id = users.user_id
        LEFT JOIN goods ON posts.post_id = goods.post_id
        WHERE posts.destination_post_id = :id
        GROUP BY posts.post_id
      ";
    
      $sql2 = "
        SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
        FROM posts
        LEFT JOIN users ON posts.user_id = users.user_id
        LEFT JOIN goods ON posts.post_id = goods.post_id
        WHERE posts.parent_post_id = :id
        GROUP BY posts.post_id
      ";
    

      $ps1 = $this->pdo->prepare($sql1);
      $ps1->bindValue(':id', $id, PDO::PARAM_INT);
      $ps1->execute();
      $coment1 = $ps1->fetchAll();
    
      $ps2 = $this->pdo->prepare($sql2);
      $ps2->bindValue(':id', $id, PDO::PARAM_INT);
      $ps2->execute();
      $coment2 = $ps2->fetchAll();

    
      return [
        'coment1' => $coment1,
        'coment2' => $coment2
      ];
    }
    
    
    public function insertpost($id, $coment, $USER_ID, $parent_post_id) {
      $sql = "INSERT INTO posts (destination_post_id, post_title, post_detail, user_id, post_category_id, post_time, parent_post_id) VALUES (:destination_post_id, :post_title, :post_detail, :user_id, :post_category_id, :post_time, :parent_post_id)";
      $ps = $this->pdo->prepare($sql);


      $ps->bindValue(':destination_post_id', $id, PDO::PARAM_INT);
      $ps->bindValue(':post_title', 'タイトル', PDO::PARAM_STR);
      $ps->bindValue(':post_detail', $coment, PDO::PARAM_STR);
      $ps->bindValue(':user_id', $USER_ID, PDO::PARAM_INT);
      $ps->bindValue(':post_category_id', 3, PDO::PARAM_INT);
      $ps->bindValue(':post_time', date('Y-m-d H:i:s'), PDO::PARAM_STR);
      $ps->bindValue(':parent_post_id', $parent_post_id, PDO::PARAM_INT);
      if ($ps->execute()) {
      } else {
        echo "データの挿入中にエラーが発生しました: " . $ps->errorInfo()[2];
      }
    }
    
    

    //記事、質問のみを検索, 該当するレコードがない場合は例外を返す
    public function searchPostsByKeyword($keyword, int $sortType = 0){
      //タイトル、本文、タグから検索。postsテーブルの列のみを返す
      switch ($sortType) {
        //新しい順
        case 1:
          $sql = "SELECT P.* FROM posts as P 
                  LEFT OUTER JOIN attached_tags as AT ON P.post_id = AT.post_id
                  LEFT OUTER JOIN tags as T ON AT.tag_id = T.tag_id
                  WHERE (P.post_title LIKE ? OR
                  P.post_detail LIKE ? OR
                  T.tag_name LIKE ?)
                  AND post_category_id != 3
                  ORDER BY P.post_time ASC
                  ";
          break;
        //古い順
        case 2:
          $sql = "SELECT P.* FROM posts as P 
                  LEFT OUTER JOIN attached_tags as AT ON P.post_id = AT.post_id
                  LEFT OUTER JOIN tags as T ON AT.tag_id = T.tag_id
                  WHERE (P.post_title LIKE ? OR
                  P.post_detail LIKE ? OR
                  T.tag_name LIKE ?)
                  AND post_category_id != 3
                  ORDER BY P.post_time DESC
                  ";
          break;
        //デフォルト（優先度順）
        default:
          $sql = "SELECT P.* FROM posts as P 
                  LEFT OUTER JOIN attached_tags as AT ON P.post_id = AT.post_id
                  LEFT OUTER JOIN tags as T ON AT.tag_id = T.tag_id
                  WHERE (P.post_title LIKE ? OR
                  P.post_detail LIKE ? OR
                  T.tag_name LIKE ?)
                  AND post_category_id != 3
                  ORDER BY P.post_priority DESC, 
                  P.post_time DESC
                  ";
          break;
      }
      
      //prepare:準備　戻り値を変数に保持
      $ps = $this->pdo->prepare($sql);

      //”？”に値を設定する。
      $ps->bindValue(1, "%$keyword%", PDO::PARAM_STR); 
      $ps->bindValue(2, "%$keyword%", PDO::PARAM_STR); 
      $ps->bindValue(3, "%$keyword%", PDO::PARAM_STR); 

      //SQLの実行
      $ps->execute();
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      if(empty($result)){
        throw new Exception('キーワードに該当する投稿はありませんでした');
      }else{
        return $result;
      }
    }

    public function decreasePostPriority(){
      $sql = "UPDATE posts SET post_priority = post_priority - 1
              WHERE post_priority > 0
              ";
      $ps = $this->pdo -> prepare($sql);

      try{
        $ps -> execute();
      }catch(PDOException $e){
        echo $e->getMessage();
      }
    }
  }
?>
