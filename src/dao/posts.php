<?php
  class posts {
    private function connect(){
      require_once('connection.php');
      $connection = new Connection;
      return $connection->dbConnect();
    }

    public function insertPosts($title, $detail, $user_id, $post_priority) {
        // DB接続情報
        $dsn = 'mysql:dbname=asoda;host=localhost';
        $user = 'root';
        $password = '';

        try {
            $dbh = new PDO($dsn, $user, $password);
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
      $pdo = $this->connect();
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
      $ps = $pdo -> prepare($sql);

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
  }

  class DAO_post{

    private function dbConnect(){
      $pdo = new PDO('mysql:host=localhost;dbname=asoda;charset=utf8','root','root');
      return $pdo;
    }

    public function post () {
      $pdo=$this->dbConnect();
      $sql = "SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
      FROM posts 
      JOIN users ON posts.user_id = users.user_id
      LEFT JOIN goods ON posts.post_id = goods.post_id
      WHERE posts.post_category_id=1
      GROUP BY posts.post_id";
      $ps = $pdo->prepare($sql);
      $ps->execute();
      $search = $ps->fetchAll();
      //$count = count($search);
      return $search;
    }

    public function prof_post () {
      $id=$_SESSION['user_id'];
      $pdo=$this->dbConnect();
      $sql = "SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
      FROM posts 
      JOIN users ON posts.user_id = users.user_id
      LEFT JOIN goods ON posts.post_id = goods.post_id
      WHERE posts.post_category_id=1 AND users.user_id=?
      GROUP BY posts.post_id";
      $ps = $pdo->prepare($sql);
      $ps->execute([$id]);
      $search = $ps->fetchAll();
      //$count = count($search);
      return $search;

    }
    public function prof_kizi_post () {
      $id=$_SESSION['user_id'];
      $pdo=$this->dbConnect();
      $sql = "SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
      FROM posts 
      JOIN users ON posts.user_id = users.user_id
      LEFT JOIN goods ON posts.post_id = goods.post_id
      WHERE posts.post_category_id=2 AND users.user_id=?
      GROUP BY posts.post_id";
      $ps = $pdo->prepare($sql);
      $ps->execute([$id]);
      $search = $ps->fetchAll();
      //$count = count($search);
      return $search;

    }
    public function prof_coment_post () {
      $id=$_SESSION['user_id'];
      $pdo=$this->dbConnect();
      $sql = "SELECT posts.*, users.user_name, COUNT(goods.post_id) AS good_count
      FROM posts 
      JOIN users ON posts.user_id = users.user_id
      LEFT JOIN goods ON posts.post_id = goods.post_id
      WHERE posts.post_category_id=3 AND users.user_id=?
      GROUP BY posts.post_id";
      $ps = $pdo->prepare($sql);
      $ps->execute([$id]);
      $search = $ps->fetchAll();
      //$count = count($search);
      return $search;

    }
    public function post_detail ($id) {
      $pdo=$this->dbConnect();
      $sql ="SELECT * FROM posts WHERE post_id = $id";
      $ps = $pdo->prepare($sql);
      $ps->execute();
      $search = $ps->fetchAll();

      if (!empty($search)) {
        $userId = $search[0]['user_id'];
    
        // ユーザー名を取得するクエリを追加
        $userSql = "SELECT user_name FROM users WHERE user_id = :userId";
        $userPs = $pdo->prepare($userSql);
        $userPs->bindValue(':userId', $userId, PDO::PARAM_INT);
        $userPs->execute();
        $userSearch = $userPs->fetch();
    
        if (!empty($userSearch)) {
          $search[0]['user_name'] = $userSearch['user_name'];

          // goodテーブルのレコード数を取得するクエリを追加
            $goodSql = "SELECT COUNT(*) AS count FROM goods WHERE post_id = $id";
            $goodPs = $pdo->prepare($goodSql);
            $goodPs->execute();
            $goodSearch = $goodPs->fetch();

              if (!empty($goodSearch)) {
                $search[0]['good_count'] = $goodSearch['count'];
              }
        }
      }

      
      return $search;
    }

    public function post_return ($id){
      $pdo=$this->dbConnect();
      $sql ="SELECT * FROM posts WHERE destination_post_id = $id";
      $ps = $pdo->prepare($sql);
      $ps->execute();
      $coment = $ps->fetchAll();

      if (!empty($coment)) {
        $userId = $coment[0]['user_id'];
    
        // ユーザー名を取得するクエリを追加
        $userSql = "SELECT user_name FROM users WHERE user_id = :userId";
        $userPs = $pdo->prepare($userSql);
        $userPs->bindValue(':userId', $userId, PDO::PARAM_INT);
        $userPs->execute();
        $userSearch = $userPs->fetch();
    
        if (!empty($userSearch)) {
          $coment[0]['user_name'] = $userSearch['user_name'];
        }
      }

      // goodテーブルのレコード数を取得するクエリを追加
      $goodSql = "SELECT COUNT(*) AS count FROM goods WHERE post_id = $id";
      $goodPs = $pdo->prepare($goodSql);
      $goodPs->execute();
      $goodSearch = $goodPs->fetch();

      if (!empty($goodSearch)) {
        $coment[0]['good_count'] = $goodSearch['count'];
      }

      return $coment;
    }

    public function insertpost($id,$coment){
      $pdo = $this->dbConnect();
      $sql = "INSERT INTO posts (destination_post_id, post_detail) VALUES (:destination_post_id, :post_detail)";
      $ps = $pdo->prepare($sql);
      $ps->bindValue(':destination_post_id', $id, PDO::PARAM_INT);
      $ps->bindValue(':post_detail', $coment, PDO::PARAM_STR);
      if ($ps->execute()) {
        echo "データが正常に挿入されました";
      } else {
        echo "データの挿入中にエラーが発生しました: " . $ps->errorInfo()[2];
      }
    }

    //記事、質問のみを返す, 該当するレコードがない場合は例外を返す
    public function searchPostsByKeyword($keyword, int $sortType = 0){
      $pdo = $this -> dbConnect();

      switch ($sortType) {
        case 1:
          //SQLの生成
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
      $ps = $pdo -> prepare($sql);

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
      $pdo = $this -> dbConnect();
      $sql = "UPDATE posts SET post_priority = post_priority - 1
              WHERE post_priority > 0
              ";
      $ps = $pdo -> prepare($sql);

      try{
        $ps -> execute();
      }catch(PDOException $e){
        echo $e->getMessage();
      }
    }
  }
?>
