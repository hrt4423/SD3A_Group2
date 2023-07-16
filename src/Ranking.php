<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/Ranking.css">
  <title>Ranking</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    .btn-purple {
      background-color: #653A91;
      border-color: #653A91;
      color: #fff;
    }
    .btn-purple:hover {
      background-color: #4b2661;
      border-color: #4b2661;
      color: #fff;
    }
    .btn-purple:focus {
      box-shadow: none;
      color: #fff;
    }

    .header_size {
      height: 150px;
      background-color: #b164ff;
    }

    .horizontal {
      display: flex;
      text-align: center;
    }

    .search {
      width: 200px;
      height: 37px;
      margin-right: 20px;
    }

    .right {
      margin-left: auto;
      display: flex;
      margin-top: 15px;
    }

    .text {
      color: white;
      font-size: 30px;
      font-weight: bold;
      flex-grow: 1;
      margin-top: 35px;
    }

    .circle {
      width: 37px;
      height: 37px;
      border-radius: 50%;
      /* background-color: #653A91; */
      margin-right: 20px;
    }

    .btn-purple {
      background-color: #653a91;
      color: #fff;
    }

    .btn {
      margin-right: 20px;
    }

    .underline {
      text-decoration: none; /* 下線をなくす */
      display: inline-block;
      width: 100%;
    }

    .underline.active {
      text-decoration: underline; 
      border-bottom: 10px solid #653A91;
      text-decoration: none;
    }

    a:hover {
      color: white;
      border-bottom: none;
      text-decoration: none;
    }
  </style>
</head>
<body class="body">
<div class="header_size">
      <?php
        session_start();
        require_once('./dao/Users.php');
        $users = new Users;
        // ユーザセッションがある場合はセッションを入れて処理を実行
        if (!empty($_SESSION['user_id'])) {
          $USESR_ID = $_SESSION['user_id'];
          $userIconPath = $users->getUserIconPathById($USESR_ID);
        }
      ?>
      <div class="horizontal">
        <img class="logo" src="./images/logo.png" height="60" alt="ロゴ">
        <div class="right">

          <!-- 検索フォーム -->
          <div class="input-group mb-3 search" >
            <form action="./search_result.php" method="GET" id="search-form">
                <div class="horizontal">
                  <div class="input-group-prepend">
                    <button type="submit" class="input-group-text" id="search-button">
                    <i class="fa fa-search"></i>
                    </button>
                  </div>
                  <input type="hidden" name="sort_type" value="0">
                  <input type="text" name="keyword" class="col-8 form-control" placeholder="検索" aria-label="検索" aria-describedby="basic-addon2">
                </div>
              </form>
          </div>
          <a href="./profile_question.php" class="circle">
            <?php
                  // ユーザアイコンパスが空でない場合は画像を表示し、空の場合はログインページに遷移するボタンを表示する
                  if (!empty($userIconPath)) {
                    echo '<img src="' . $userIconPath . '" alt="ユーザアイコン" style="width: 30px;">';
                  } else {
                    echo '<a href="login.php" class="login_atag">ログイン</a>';
                  }
              ?>
          </a>
          
          <div class="dropdown">
            <button class="btn btn-purple dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              投稿する
            </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="./questionCreation.php">質問</a>
                <a class="dropdown-item" href="#">記事</a>
              </div>
          </div>
        </div>
      </div>

      <div class="horizontal">
        <a href="./questiontimeline.php" class="underline text">質問</a>
        <a href="./articlelist.php" class="underline text">記事</a>
        <a href="./Ranking.php" class="underline text">ランキング</a>
        <a href="./classroom.php" class="underline text">空き教室</a>
      </div>
    </div>
<!-- ↑ヘッダー -->

<div class="allrank_area">
  <p class="rank_title">ユーザランキング</p>
    <div class="area">
        <div class="rank_area">
        
        <?php 
        $rank=1;
        $count=1;
        $beforepoint=0;
        $pdo = new PDO('mysql:host=localhost;dbname=asoda;charset=utf8','root','root');
        $stmt = $pdo->prepare('select * from users ORDER BY point_sum DESC');
        $stmt ->execute();
        echo "<table>";
        while($row=$stmt->fetch()){
          if($beforepoint !=$row['point_sum']){
            $rank=$count;
          }
          if($rank==1){
            echo '<tr>
            <td class="rank">
            <image src="./images/rank1.png">
            </td>
            ';

            if(isset($row['user_icon'])){
              echo '<td><img src="' .$row['user_icon']. '"style="width: 30px"></td>';
            }

            echo '
            <td class="user_name">
           '.$row["user_name"].'
            </td>
            <td class="point_sum">
            '.$row["point_sum"].'pt
            </td>   
            </tr>';
          $beforepoint=$row['point_sum'];
          $count++;
          }else if($rank==2){
            echo '<tr>
            <td class="rank">
            <image src="./images/rank2.png">
            </td>
            ';

            if(isset($row['user_icon'])){
              echo '<td><img src="' .$row['user_icon']. '" style="width: 30px"></td>';
            }

            echo '
            <td class="user_name">
           '.$row["user_name"].'
            </td>
            <td class="point_sum">
            '.$row["point_sum"].'pt
            </td>   
            </tr>';
          $beforepoint=$row['point_sum'];
          $count++;
          }else if($rank==3){
            echo '<tr>
            <td class="rank">
            <image src="./images/rank3.png">
            </td>

            ';
            if(isset($row['user_icon'])){
              echo '<td><img src="' .$row['user_icon']. '" style="width: 30px""></td>';
            }

            echo '
            <td class="user_name">
           '.$row["user_name"].'
            </td>
            <td class="point_sum">
            '.$row["point_sum"].'pt
            </td>   
            </tr>';
          $beforepoint=$row['point_sum'];
          $count++;
          }else{
          echo '<tr>
            <td class="rank">
            '.$rank.'
            </td>
            ';
            
            if(isset($row['user_icon'])){
              echo '<td><img src="' .$row['user_icon']. '" style="width: 30px""></td>';
            }

            echo '
            <td class="user_name">
           '.$row["user_name"].'
            </td>
            <td class="point_sum">
            '.$row["point_sum"].'pt
            </td>   
            </tr>';
          $beforepoint=$row['point_sum'];
          $count++;
          }
        
    }
    echo "</table>";
    ?>
        </div>
      </div>
  </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>