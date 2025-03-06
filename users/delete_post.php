<?php
include("../includes/connection.txt");
$post_id = $_GET['pid'];
$sql = "delete from posts where post_id = $post_id";
$result = $pdo->query($sql);
header('location:home.php');
?>