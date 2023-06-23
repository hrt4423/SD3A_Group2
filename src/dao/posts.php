<?php
  
  class posts {
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
  }
?>
