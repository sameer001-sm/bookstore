<?php 
require 'db.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BookBazaar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">BookBazaar</a>

    <div>
      <?php if(isset($_SESSION['user_id'])): ?>
        <a class="btn btn-outline-light" href="dashboard.php">Dashboard</a>
        <a class="btn btn-danger" href="logout.php">Logout</a>
      <?php else: ?>
        <a class="btn btn-outline-light" href="login.php">Login</a>
        <a class="btn btn-warning" href="register.php">Register</a>
        <a class="btn btn-outline-light" href="logout.php">Logout</a>

      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container mt-4">