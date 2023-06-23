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
      background-color: #653A91;
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
      <div class="horizontal">
          <img class="logo" src="images/logo.png" height="60" alt="ロゴ">
        <div class="right">

          <div class="input-group mb-3 search" >
            <div class="input-group-prepend">
              <span class="input-group-text">
              <i class="fa fa-search"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="検索" aria-label="検索" aria-describedby="basic-addon2">
          </div>

          <div class="circle"></div>
            <div class="dropdown">
                <button class="btn btn-purple dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  投稿する
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">質問</a>
                  <a class="dropdown-item" href="#">記事</a>
                </div>
            </div>
        </div>
      </div>

      <div class="horizontal">
        <a href="#" class="underline text">質問</a>
        <a href="#" class="underline text">いいね</a>
        <a href="#" class="underline text">投稿</a>
        <a href="#" class="underline text">ランキング</a>
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
        while($row=$stmt->fetch()){
          if($beforepoint !=$row['point_sum']){
            echo '<div >
            <p class="user_icon">
             '['user_icon']'
            </P>
            <p class="user_name">
           '['user_name']'
            </p>
            <p class="point_sum">
            '['point_sum']'
            </p>
            </button>   
            </div>';
            $rank=$count;
          }
          $beforepoint=$row['point_sum'];
          $count++;
        
    }
    ?>
        </div>
      </div>
  </div>

  <script>
    $(document).ready(function() {
     // リンクをクリックした時の処理
      $(".underline").click(function(e) {
        e.preventDefault(); // デフォルトのリンク遷移を防止

        // すでにアクティブなリンクがある場合、その下線を消す
        $(".underline.active").removeClass("active");
        // クリックされたリンクに下線をつける
        $(this).addClass("active");
      });
    });
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>