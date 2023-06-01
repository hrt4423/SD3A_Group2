<?php
  
  class posts{
    public function insertPosts($title,
                                $detail
                                 ){
      // require_once './connection.php';
      // $dbClass = new connection();
      // $pdo = $dbClass->dbConnect();

            // DB接続情報
            $dsn = 'mysql:dbname=asoda;host=localhost';
            $user = 'daiki';
            $password = 'daiki';
      
            try{
            $dbh = new PDO($dsn, $user, $password);
            }catch (PDOException $e){
            print('Error:'.$e->getMessage());
            die();
            }

      //テスト検索
      $sql = "INSERT INTO posts (user_id,
                                 post_category_id,
                                 post_time,
                                 post_title,
                                 post_detail
                                 ) 

                          VALUES (:user_id,
                                  :post_category_id, 
                                  :post_time,
                                  :post_title,
                                  :post_detail
                                  )";

      
      // プリペアドステートメントを作成
      $stmt = $dbh->prepare($sql);

      // パラメータをバインド
      $stmt->bindParam(':user_id', $user_id);
      $stmt->bindParam(':post_category_id', $post_category_id);
      $stmt->bindParam(':post_time', $post_time);
      $stmt->bindParam(':post_title', $title);
      $stmt->bindParam(':post_detail', $detail);

      // 値をセット
      $user_id = 1;
      $post_category_id = 1;
      $post_time = '2022/12/26';
      // $post_title = 'テスト1';
      // $post_detail = 'テスト1';

      // ステートメントを実行
      $stmt->execute();

      try {
      echo "データが正常に挿入されました。";
      } catch (PDOException $e) {
      echo "エラー: " . $e->getMessage();
      }
    }
  }
?>