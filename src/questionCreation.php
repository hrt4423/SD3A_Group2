<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>質問作成画面</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/markdown-it/dist/markdown-it.min.js"></script>
  <style>

    body {
      background-color: #FAEEFF;
    }
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
      /* height: 150px; */
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

    .title {
      border-color: #A42FCD;
      margin-top: 20px;
      width: 90%;
      margin-left: auto;
      margin-right: auto;
      height: 50px;
      font-size: 20px;
    }

    .main {
      border-color: #A42FCD;
      margin-top: 20px;
      width: 50%;
      height: 50px;
      font-size: 20px;
    }

    .preview {
      border: 1px solid #A42FCD;
      margin-top: 20px;
      background-color: #fffdfd;
      width: 600px;
      padding-top: 8px;
      padding-left: 8px;
    }

    .yoko {
      display: flex;
      width: 90%;
      margin-left: auto;
      margin-right: auto;
      
    }

    .blacktext {
      margin-left: 5%;
      margin-top: 20px;
      font-size: 25px;
      font-weight: bold;
    }

    .track {
      position: relative;
      width: 100px;
      height: 35px;
      background-color: #ffffff;
      border-radius: 25px;
      overflow: hidden;
      border: 1px solid #A0A0A0;
      margin-top: 20px;
      margin-left: 30px;
    }



    .track-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 12px;
      color: black;
      text-align: center;
      text-transform: uppercase;
      font-weight: bold;
    }

    .custom-button {
      background-color: #653A91;
      color: #EDEDED;
      margin-top: 20px;
      height: 50px;
      width: 300px;
      font-weight: bold;
      font-size: 25px;
      margin-left: 38%;
      /* margin-right: auto; */
    }

    .custom-button:hover {
      color: #EDEDED;
    }

    .custom-point-button {
      background-color: #5754FF;
      height: 50px;
      width: 100px;
      font-size: 25px;
      margin-top: 20px;
      margin-left: 30px;
    }

    .point-text {
      margin-top: 20px;
      text-align: center;
    }
    

  </style>
</head>
<body>
  
 <!-- body部分とstyle部分とscript部分をコピーして使ってください -->
 <div class="header_size">
  <div class="horizontal">
      <img class="logo" src="./images/logo.png" height="60" alt="ロゴ">
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

  <!-- <div class="horizontal">
    <a href="#" class="underline text">質問</a>
    <a href="#" class="underline text">いいね</a>
    <a href="#" class="underline text">投稿</a>
  </div> -->

 </div>
<!-- ここまでがヘッダー -->

<input type="text" class="form-control title" placeholder="タイトル">

<div style="display:flex">
  <div class="blacktext">
    タグ
  </div>

  <div class="track">
    <div class="track-text">Java</div>
  </div>
  <div class="track">
    <div class="track-text">PHP</div>
  </div>
  <div class="track">
    <div class="track-text">Vue.js</div>
  </div>

</div>


<div class="yoko">
  <textarea class="form-control main" rows="8" placeholder="本文"></textarea>
  <div class="preview">プレビュー</div>
</div>




<div class="d-flex">
  <button class="justify-content-center btn custom-button">投稿する</button>
  <button class="btn custom-point-button">🚀</button>
  <div class="point-text">ポイントを消費して<br>質問を優先表示</div>
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
      

      // DOMの読み込みが完了した時点で実行
      document.addEventListener('DOMContentLoaded', function() {
        // 左側のtextarea要素を取得
        const leftTextarea = document.querySelector('.yoko textarea:nth-of-type(1)');
        // プレビューエリアの要素を取得
        const previewArea = document.querySelector('.yoko .preview');

        // MarkdownからHTMLへの変換関数を定義
        function convertMarkdownToHTML(markdown) {
          const md = window.markdownit(); // markdown-itインスタンスを作成
          return md.render(markdown);
        }

        // 左側のtextareaの入力イベントを監視
        leftTextarea.addEventListener('input', function () {
          // MarkdownテキストをHTMLに変換してプレビューエリアに表示
          const markdownText = this.value;
          const htmlText = convertMarkdownToHTML(markdownText);
          previewArea.innerHTML = htmlText;
        });
      });




  </script>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>