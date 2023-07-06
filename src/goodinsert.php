<?php
require_once('dao/good.php');
$goods=new Good();
if (isset($_POST['post_id']) && isset($_POST['user_id'],$_POST['user_point'])) {
 $goods->insertgood($_POST['user_id'],$_POST['point_id'],$_POST['user_point']);
}
?>