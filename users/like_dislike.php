<?php
// session_start();
include("../includes/connection.txt");

$x=-1;
if($x)
$stmt1 = $pdo->prepare("UPDATE likes SET like_dislike = 0 WHERE like_id = 8");
else 
$stmt1 = $pdo->prepare("UPDATE likes SET like_dislike = -1 WHERE like_id = 8");

$stmt1->execute();
        echo "done";
    
?>