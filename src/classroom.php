<?php session_start(); 
require_once './dao/theme_colors.php';
$themeColors = new ThemeColors;
require_once './dao/users.php';
$users = new Users;
if(isset($_SESSION['user_id'])){
  $currentThemeColorId =  $users->getThemeColorId($_SESSION['user_id']);
}else{
  $currentThemeColorId = 1;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="/src/css/classroom2.css">
    <link rel="stylesheet" href="./css/header.css">
	<title>教室共有画面</title>
	<style>
        body {
		  font-size: calc(16px + (24 - 16) * ((100vw - 320px) / (1920 - 320)));
		}
    .example2{
      display: flex;
    }
    .example2 label{
      background-color: lawngreen;
      color: black;
      border-radius: 2vw; /* 角を丸くする量を指定 */
      width: 6vw;
      height: 4vw;
      font-size: 2vw;
      margin-top: 1vw;
      margin-bottom: 1vw;
    }
    .example2 input:checked+label{
      background-color: grey;
      color: #FFF;
    }
    .example2 input{
     display: none;
    }
	</style>
</head>
<body style="background-color: <?=$themeColors->getSubColorCode($currentThemeColorId) ?>">
    <!-- ここからがヘッダー -->
        <div class="header_size" style="background-color: <?=$themeColors->getThemeColorCode($currentThemeColorId)?> ;">
        <?php
            // require_once('./dao/Users.php');
            // $users = new Users;
            // ユーザセッションがある場合はセッションを入れて処理を実行
        if (!empty($_SESSION['user_id'])) {
            $USESR_ID = $_SESSION['user_id'];
            $userIconPath = $users->getUserIconPathById($USESR_ID);
          }
        ?>
        <div class="horizontal">
            <img class="logo" src="./images/<?=$themeColors->getLogoPath($currentThemeColorId)?>" height="60" alt="ロゴ">
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
                    <a class="dropdown-item" href="./articleCreation.php">記事</a>
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
    <!-- ここまでがヘッダー -->

    <div style="text-align:center">
        <div class="example2">
	        <div class="container">
		        <div class="row">
                    <div class="col">
                        <input type="checkbox" id="131" name="example2"><label for="131" >131</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="132" name="example2"><label for="132">132</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="133" name="example2"><label for="133">133</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="134" name="example2"><label for="134">134</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="135" name="example2"><label for="135">135</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="136" name="example2"><label for="136">136</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="137" name="example2"><label for="137">137</label>
                    </div>
    		    </div>
                <div class="row">
                    <div class="col">
                        <input type="checkbox" id="141" name="example2"><label for="141">141</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="142" name="example2"><label for="142">142</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="143" name="example2"><label for="143">143</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="144" name="example2"><label for="144">144</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="145" name="example2"><label for="145">145</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="146" name="example2"><label for="146">146</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="147" name="example2"><label for="147">147</label>
                    </div>
    		    </div>
                <div class="row">
                    <div class="col">
                        <input type="checkbox" id="151" name="example2"><label for="151">151</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="152" name="example2"><label for="152">152</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="153" name="example2"><label for="153">153</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="154" name="example2"><label for="154">154</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="155" name="example2"><label for="155">155</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="156" name="example2"><label for="156">156</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="157" name="example2"><label for="157">157</label>
                    </div>
    		    </div>
                <div class="row">
                    <div class="col">
                        <input type="checkbox" id="161" name="example2"><label for="161">161</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="162" name="example2"><label for="162">162</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="163" name="example2"><label for="163">163</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="164" name="example2"><label for="164">164</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="165" name="example2"><label for="165">165</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="166" name="example2"><label for="166">166</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="167" name="example2"><label for="167">167</label>
                    </div>
    		    </div>
                <div class="row">
                    <div class="col">
                        <input type="checkbox" id="171" name="example2"><label for="171">171</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="172" name="example2"><label for="172">172</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="173" name="example2"><label for="173">173</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="174" name="example2"><label for="174">174</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="175" name="example2"><label for="175">175</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="176" name="example2"><label for="176">176</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" id="177" name="example2"><label for="177">177</label>
                    </div>
    		    </div>
	    	</div>
	    </div>
	    <h1>＊空いている：緑　＊空いていなかった：グレー</h1>
    </div>
	
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="./script/script.js"></script>
</body>
</html>