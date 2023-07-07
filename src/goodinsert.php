<?php
require_once('dao/good.php');
$goods=new Good();
if (isset($_POST['post_id']) && isset($_POST['user_id'])&& isset($_POST['user_id'])) {
 $goods->insertgood($_POST['user_id'], $_POST['post_id'],$_POST['user_point_id']);
}
?>