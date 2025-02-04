<?php
include('../includes/connection.txt');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="/submit_registration" method="POST">
  <label for="prn">PRN:</label>
  <input type="text" id="prn" name="prn" required><br><br>

  <label for="name">Name:</label>
  <input type="text" id="name" name="name" required><br><br>

  <label for="email">Gmail:</label>
  <input type="email" id="email" name="email" required><br><br>

  <label for="batch_year">Batch Year:</label>
  <input type="number" id="batch_year" name="batch_year" min="2000" max="2100" required><br><br>
  
  <label for="username">Create Username:</label>
  <input type="text" id="username" name="username" required><br><br>

  <label for="password">Create Password:</label>
  <input type="password" id="password" name="password" required><br><br>

  <button type="submit">Register</button>
</form>

</body>
</html>