<h1>DB接続テスト</h1>
<?php
  try{
    require_once('./dao/connection.php');
    $connection = new Connection;
  }catch(Exception $e){
    echo $e->getMessage();
    exit;
  }catch(Error $e){
    echo $e->getMessage();
    exit;
  }
  echo '接続成功';
?>