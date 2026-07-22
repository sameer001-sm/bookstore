<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>

<div class="container mt-5 text-center">
    <h2>Welcome <?php echo $_SESSION['name']; ?> 👋</h2>
    <p>Ye tumhara User Dashboard hai</p>
    
    <a href="index.php" class="btn btn-primary">Shop Books</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>

<?php include 'includes/footer.php'; ?>