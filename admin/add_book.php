<?php 
session_start();
include '../includes/db.php';

// Sirf admin hi access kar paye
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){ 
    header("Location: ../login.php"); 
    exit();
}

$msg = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

    // Image upload
    $image = $_FILES['image']['name'];
    $target = "../uploads/books/".$image;
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $stmt = $conn->prepare("INSERT INTO books (title, author, price, description, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss",$title,$author,$price,$desc,$image);
    
    if($stmt->execute()){
        $msg = "<div class='alert alert-success'>Book Added Successfully!</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Error: Book not added</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Book - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container mt-4" style="max-width:600px;">
    <h3>Add New Book</h3>
    <a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">← Back to Dashboard</a>
    
    <?php echo $msg; ?>
    
    <form method="post" enctype="multipart/form-data" class="card p-4 shadow">
        <div class="mb-3">
            <label class="form-label">Book Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Author</label>
            <input type="text" name="author" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Price ₹</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Book Cover Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        <button class="btn btn-success w-100">Add Book</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>