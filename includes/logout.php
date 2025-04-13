<?php
include('../includes/connection.txt');
session_start(); 
session_destroy();
header("Location: ../users/login.php");
exit();
?>
