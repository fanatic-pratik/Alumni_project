<?php
session_start();
include("../includes/connection.txt");
$q= $_GET['q'];
$u= $_GET['u'];


$sql="select * from likes where post_id=$q and user_id=$u; ";
$result = $pdo->query($sql);
if($rs=$result->fetch()){	
	$sql1="update likes set d = 1 where like_id=".$rs[0]." and user_id=$u; ";
	$result1 = $pdo->query($sql1);
	$sql1="update likes set l= 0 where like_id=".$rs[0]." and user_id=$u; ";
	$result1 = $pdo->query($sql1);
} else {
	$sql1="insert into likes (post_id, user_id,d) values ($q,$u,1)";
	$result1 = $pdo->query($sql1);
}
	$sql1="select sum(l) from likes where post_id=".$q;
	$result1 = $pdo->query($sql1);
	$rs1=$result1->fetch();
	$l=$rs1[0];
	$sql1="select sum(d) from likes where post_id=".$q;
	$result1 = $pdo->query($sql1);
	$rs1=$result1->fetch();
	$d=$rs1[0];
    echo ($l)." Likes, Dislikes: ".$d;
//tbl_likes: like_id, post_id, user_id, l, d
?>
