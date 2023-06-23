<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--BootStrap CDN-->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <!--BootStrap icon CDN-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="./css/question-detail.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/markdown-it/dist/markdown-it.min.js"></script>
    <title>質問詳細画面</title>
    <style>
      body {
        background-color: #faeeff;
      }
      .btn-purple {
        background-color: #653a91;
        border-color: #653a91;
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
        background-color: #653a91;
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
        border-bottom: 10px solid #653a91;
        text-decoration: none;
      }

      a:hover {
        color: white;
        border-bottom: none;
        text-decoration: none;
      }

      .preview-button {
        background-color: #b164ff;
        color: #fff;
      }

      .preview-button:hover {
        background-color: #b164ff;
        border-color: #b164ff;
        color: #fff;
      }

      .styled-output {
        background-color: #fff;
      }
    </style>
  </head>
  <body>
    <!-- body部分とstyle部分とscript部分をコピーして使ってください -->
    <div class="header_size">
      <div class="horizontal">
        <img class="logo" src="./images/logo.png" height="60" alt="ロゴ" />
        <div class="right">
          <div class="input-group mb-3 search">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fa fa-search"></i>
              </span>
            </div>
            <input
              type="text"
              class="form-control"
              placeholder="検索"
              aria-label="検索"
              aria-describedby="basic-addon2"
            />
          </div>

          <div class="circle"></div>

          <div class="dropdown">
            <button
              class="btn btn-purple dropdown-toggle"
              type="button"
              id="dropdownMenuButton"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
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
        <a href="#" class="underline text">教室</a>
        <a href="#" class="underline text">ランキング</a>

      </div>
    </div>
    <!-- ここまでがヘッダー -->
    <?php

try{
  require_once './DAO/posts.php';
  $postAll = new DAO_post();
  $post_id = $_POST['post_id'];
  $search = $postAll->post_detail($post_id);//記事や質問の投稿詳細
  echo '<script>';
  echo 'console.log(' . json_encode($search) . ')';
  echo '</script>';

  $coment = $postAll->post_return($post_id);//それに対する返信検索
  echo '<script>';
  echo 'console.log(' . json_encode($coment) . ')';
  echo '</script>';

  if(isset($_POST['send_icon'])){
    $postAll = new DAO_post();
        $postAll->insertpost($post_id, $post_detail);
        echo '<script>';
        echo 'console.log(ok)';
        echo '</script>'; 
  }

}catch(Exception $ex){
  echo $ex->getMessage();
}catch(Error $err){
  echo $err->getMessage();
}
?>

    <div class="card">
      <div class="card-body">
        <div id="user-info-post-date" class="row">
          <div name="user-info" class="col-3">
            <span name="user-icon"><i class="bi bi-person-circle"></i></span>
            <span name="user-rank"><i class="bi bi-gem"></i></span>
            <span name="user-name"><?php echo $search[0]['user_name'] ?></span>
          </div>
          <div class="col-3 offset-md-6 text-center"><?php echo $search[0]['post_time'] ?></div>
        </div>
        <div class="row">
          <div class="col-9">
            <div class="card-title">
              <h4 class="text-center"><?php echo $search[0]['post_title'] ?></h4>
            </div>
            <div name="card-tags">
              <i class="bi bi-tags"></i>
              <span class="tag">PHP</span>
              <span class="tag">データベース</span>
            </div>
            <p class="card-text"><?php echo $search[0]['post_detail'] ?></p>
            <div class="reply-area">
              <h5>--回答--</h5>
              <div name="reply-card" class="card" id="card-reply-area">
                <!--回答１-->
                <div class="card-body">
                  <div class="card-title"></div>

                  <?php foreach ($coment as $item): ?>
                  <div name="user-info">
                    <!--投稿者の情報-->
                    <span name="user-icon"
                      ><i class="bi bi-person-circle"></i
                    ></span>
                    <span name="user-rank"><i class="bi bi-gem"></i></span>
                    <span name="user-name"><?php echo $item['user_name']; ?></span>
                  </div>
                  <!--いいねボタン-->
                  <div class="good-button-area">
                    <button class="btn" id="good">
                      <i
                        name="good-button"
                        class="bi bi-hand-thumbs-up-fill"
                      ></i>
                      <span id="good-amount"><?php echo $item['good_count']; ?></span>
                    </button>
                  </div>

                  <div class="card-text">
                    <!--回答文-->
                    <?php echo $item['post_detail']; ?>
                  </div>
                  <?php endforeach; ?>

                 
                        <!-- <hr id="border-line-reply" /> -->

                        <!-- <h6 id="reply-comment">コメント</h6>
                        <div name="user-info" class="col-3">
                          <span name="user-icon"><i class="bi bi-person-circle"></i></span>
                          <span name="user-rank"><i class="bi bi-gem"></i></span>
                          <span name="user-name">ユーザー名</span> -->
                        </div>

                        <!--いいねボタン-->
                        <!-- <div class="good-button-area">
                          <button class="btn" id="good">
                            <i name="good-button" class="bi bi-hand-thumbs-up-fill"></i>
                            <span id="good-amount"></span>
                          </button>
                        </div> -->
                     

                  <div class="card-text">
                    <!--コメント文-->
                    <!-- ***コメント1*** -->

                    <hr id="border-line-reply" />

                    <div class="comment-write-area">
                      <!--コメント入力欄-->
                      <form action="" method="post" id="comment-form">
                        <!-- ここの値のIDをPHPで動的に与えてあげてください comment-text-area-1 -->
                        <div class="form-floating" id="">
                          <textarea
                            class="form-control"
                            placeholder=""
                            id=""
                            form="comment-form"
                            style="height: 150px"
                          ></textarea>
                          <label for="">返信</label>
                          <div class="styled-output"></div>
                        </div>

                        <div style="display: flex">
                          <button
                            type="button"
                            class="btn preview-button"
                            data-toggle="button"
                            aria-pressed="false"
                            autocomplete="off"
                            onclick="convertToMarkdown(1)"
                          >
                            プレビュー
                          </button>

                          <div class="comment-write-area-button">
                            <label id="upload-image-icon">
                              <input type="file" name="file" />
                              <button class="btn btn-outline-dark">
                                <i class="bi bi-card-image"></i>
                              </button>
                            </label>
                            <button
                              type="submit"
                              class="btn btn-outline-dark"
                              id="send-icon"
                            >
                              <i class="bi bi-send"></i>
                            </button>
                          </div>
                        </div>
                        <!-- フォームに投稿IDを隠しフィールドとして追加 -->
                        <input type="hidden" name="post_id" value="">
                      </form>

                      <!--comment-area-button-->
                    </div>
                    <!--/コメント入力欄-->
                  </div>
                </div>
                <!---card-body-->
              </div>
              <!--/回答１-->

              <!--回答２-->
              <!-- <div name="reply-card" class="card" id="card-reply-area">
                
                <div class="card-body">
                  <div class="card-title"></div>

                  <div name="user-info" class="col-3">
                    投稿者の情報
                    <span name="user-icon"
                      ><i class="bi bi-person-circle"></i
                    ></span>
                    <span name="user-rank"><i class="bi bi-gem"></i></span>
                    <span name="user-name">ユーザー名</span>
                  </div>

                  いいねボタン
                  <div class="good-button-area">
                    <button class="btn" id="good">
                      <i
                        name="good-button"
                        class="bi bi-hand-thumbs-up-fill"
                      ></i>
                      <span id="good-amount">13</span>
                    </button>
                  </div>

                  <div class="card-text">***回答２***</div>

                  <hr id="border-line-reply" />

                  <h6 id="reply-comment">コメント</h6>
                  <div name="user-info" class="col-3">
                   投稿者の情報
                    <span name="user-icon"
                      ><i class="bi bi-person-circle"></i
                    ></span>
                    <span name="user-rank"><i class="bi bi-gem"></i></span>
                    <span name="user-name">ユーザー名</span>
                  </div>

                  いいねボタン
                  <div class="good-button-area">
                    <button class="btn" id="good">
                      <i
                        name="good-button"
                        class="bi bi-hand-thumbs-up-fill"
                      ></i>
                      <span id="good-amount">13</span>
                    </button>
                  </div>

                  <div class="card-text">
                    ***コメント2***

                    <hr id="border-line-reply" />

                    <div class="comment-write-area">
                     コメント入力欄
                      <form action="" method="post" id="comment-form">
                        <div class="form-floating" id="comment-text-area-2">
                          <textarea
                            class="form-control"
                            placeholder=""
                            id="text-area-2"
                            form="comment-form"
                            style="height: 150px"
                          ></textarea>
                          <label for="text-area-2">返信</label>
                          <div class="styled-output"></div>
                        </div>

                        <div style="display: flex">
                          <button
                            type="button"
                            class="btn preview-button"
                            data-toggle="button"
                            aria-pressed="false"
                            autocomplete="off"
                            onclick="convertToMarkdown(2)"
                          >
                            プレビュー
                          </button>

                          <div class="comment-write-area-button">
                            <label id="upload-image-icon">
                              <input type="file" name="file" />
                              <button class="btn btn-outline-dark">
                                <i class="bi bi-card-image"></i>
                              </button>
                            </label>
                            <button
                              type="submit"
                              class="btn btn-outline-dark"
                              id="send-icon"
                            >
                              <i class="bi bi-send"></i>
                            </button>
                          </div>
                        </div>
                      </form>

                    comment-area-button
                    </div>
                    /コメント入力欄
                  </div>
                </div>
               card-body
              </div>
              回答２
            </div> -->
          </div>

          <div id="side-area" class="col-3 text-center">
            <button class="btn" id="edit">編集</button>
            <br />
            <div class="good">
              <button class="btn" id="good">
                <i name="good-button" class="bi bi-hand-thumbs-up-fill"></i>
                <span id="good-amount"></span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="answer-write-area">
      <!--回答入力欄-->
      <form action="" method="post" id="comment-form">
        <div class="form-floating" id="comment-text-area-3">
          <textarea
            class="form-control"
            placeholder=""
            name="post_detail"
            id="text-area-3"
            form="comment-form"
            style="height: 150px"
          ></textarea>
          <label for="text-area-3">回答</label>
          <div class="styled-output"></div>
        </div>

        <div style="display: flex">
          <button
            type="button"
            class="btn preview-button"
            data-toggle="button"
            aria-pressed="false"
            autocomplete="off"
            onclick="convertToMarkdown(3)"
          >
            プレビュー
          </button>

          <div class="comment-write-area-button">
            <label id="upload-image-icon">
              <input type="file" name="file" />
              <button class="btn btn-outline-dark">
                <i class="bi bi-card-image"></i>
              </button>
            </label>
            <button type="submit" class="btn btn-outline-dark" id="send-icon" name="send_icon">
              <i class="bi bi-send"></i>
            </button>
          </div>
        </div>
      </form>

      <!--answer-write-area-button-->
    </div>
    <!--/回答入力欄-->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <script>
      $(document).ready(function () {
        // リンクをクリックした時の処理
        $(".underline").click(function (e) {
          e.preventDefault(); // デフォルトのリンク遷移を防止

          // すでにアクティブなリンクがある場合、その下線を消す
          $(".underline.active").removeClass("active");
          // クリックされたリンクに下線をつける
          $(this).addClass("active");
        });
      });

      function convertToMarkdown(textAreaIndex) {
        var textarea = document.getElementById("text-area-" + textAreaIndex);
        var styledOutput = document.querySelector(
          "#comment-text-area-" + textAreaIndex + " .styled-output"
        );

        if (!textarea || !styledOutput) {
          console.error("テキストエリアに文字が入力されてないません");
          return;
        }

        var input = textarea.value;

        if (input) {
          var md = window.markdownit();
          var result = md.render(input);

          styledOutput.innerHTML =
            '<div style="border: 1px solid #ced4da; padding: 10px; margin-top: 10px;">' +
            result +
            "</div>";
        }
      }

      function deletePreview() {
        var div = document.getElementById("styled-output");
        div.classList.toggle("active");
      }
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>