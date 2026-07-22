<?php
session_start();
include '../includes/db.php';

// sirf admin login ho to hi access
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];
$msg = "";

// book ka data nikal lo
$stmt = $conn->prepare("SELECT * FROM books WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();

// form submit hua
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $desc = $_POST['description'];

    $stmt = $conn->prepare("UPDATE books SET title=?, author=?, price=?, stock=?, description=? WHERE id=?");
    $stmt->bind_param("ssdisi", $title, $author, $price, $stock, $desc, $id);
    
    if($stmt->execute()){
        $msg = "Book Updated Successfully!";
        $book = $stmt->get_result(); // refresh data
        header("Location: dashboard.php?msg=updated");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Book</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Back</a>
    
    <form method="POST" class="card p-4 shadow">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo $book['title']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Author</label>
            <input type="text" name="author" value="<?php echo $book['author']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="<?php echo $book['price']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" value="<?php echo $book['stock']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"><?php echo $book['description']; ?></textarea>
        </div>
        <button class="btn btn-success">Update Book</button>
    </form>
</div>
</body>
</html>