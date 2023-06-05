<?php
    class users{
        private function dbConnect(){
            //データベースに接続
            $pdo = new PDO('mysql:host=localhost; dbname=webdb; charset=utf8',
                            'hirata', 'password');
            return $pdo;
        }
    }
?>