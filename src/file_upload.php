<?php
    //ファイル名を変更
    $newFileName = date("YmdHis"). "-". $_FILES['file_upload']['name'];
    //ファイルの保存先
    $upload_dir = './images/'. $newFileName;
    //アップロードのチェック
    if(move_uploaded_file($_FILES['file_upload']['tmp_name'], $upload_dir)){
        echo 'アップロード';
    }else{
        echo 'アップロード失敗';
    }
?>