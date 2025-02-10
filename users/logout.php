<?php
include('../includes/connection.txt');
session_start(); 
session_destroy();
header("Location: login.php");
exit;
?>
