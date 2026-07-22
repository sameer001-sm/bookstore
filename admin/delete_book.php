<?php
session_start();
include '../includes/db.php';

// sirf admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];

// delete kar do
$stmt = $conn->prepare("DELETE FROM books WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: dashboard.php?msg=deleted");
exit();
?>