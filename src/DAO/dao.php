<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB接続テスト</title>
</head>
<body>
  <?php
    class DAO_test{
      //データベースに接続する関数
      private function dbConnect(){
        //データベースに接続
        $pdo = new PDO('mysql:host=mysql210.phy.lolipop.lan;dbname=LAA1417818-asoda;charset=utf8','LAA1417818','asodapass');
        return $pdo;
      }
  
    //予約IDから席IDを検索する関数
    public function getUserName($userId){
      $pdo = $this -> dbConnect();
  
      //SQLの生成　入力を受け取る部分は”？”
      $sql = "SELECT * FROM users WHERE user_id=?";
  
      //prepare:準備　戻り値を変数に保持
      $ps = $pdo -> prepare($sql);
  
      //”？”に値を設定する
      $ps->bindValue(1, $userId, PDO::PARAM_INT);
  
      //SQLの実行
      $ps->execute();
      //実行結果を配列に格納
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);
  
      if(empty($result)){
          echo '指定したIDに該当するデータはありません。';
      }else{
        foreach($result as $row){
            $userName=$row['user_name'];
        }
      } 
      //echo $seatId;
      return $userName;
    }   
  
    }
  
  ?>
  
</body>
</html>
<?php
  

?>

