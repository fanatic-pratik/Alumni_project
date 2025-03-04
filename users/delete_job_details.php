<?php
// session_start();
include('../includes/connection.txt');
$jid=$_GET['id'];
$sql= "DELETE from job_profile_curr where job_id = $jid";
$result=$pdo->query($sql);
header('location:job_details1.php');
?>