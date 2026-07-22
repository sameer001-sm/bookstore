<?php include 'includes/header.php'; ?>

<h2 class="mb-4">All Books</h2>

<form method="GET" class="mb-4">
  <div class="input-group">
    <input type="text" name="search" class="form-control" placeholder="Book ya Author search karo..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <button class="btn btn-primary">Search</button>
    <a href="index.php" class="btn btn-secondary">Reset</a>
  </div>
</form>

<div class="row">
<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%' ORDER BY id DESC";
$result = $conn->query($sql);

if($result->num_rows > 0){
    while($book = $result->fetch_assoc()):
?>
    <div class="col-md-3 mb-4">
        <div class="card">
        <img src="uploads/books/<?php echo $book['book_image']; ?>" class="card-img-top" height="200" style="object-fit:cover;">           
        <div class="card-body">
                <h5 class="card-title"><?php echo $book['title']; ?></h5>
                <p class="card-text">Author: <?php echo $book['author']; ?></p>
                <p class="card-text"><b>₹<?php echo $book['price']; ?></b></p>
                <a href="cart.php?add=<?php echo $book['id']; ?>" class="btn btn-success btn-sm">Add to Cart</a>
                <!-- <a href="#" class="btn btn-primary w-100">Add to Cart</a> -->
            </div>
        </div>
    </div>
<?php 
    endwhile;
} else {
    echo "<p>No books found. Add some books from admin.</p>";
}
?>
</div>

<?php include 'includes/footer.php'; ?>