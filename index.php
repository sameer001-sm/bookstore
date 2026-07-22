<?php include 'includes/header.php'; ?>

<h2 class="mb-4">All Books</h2>
<div class="row">
<?php
$sql = "SELECT books.*, categories.name as cat_name FROM books 
        JOIN categories ON books.category_id = categories.id";
$result = $conn->query($sql);

if($result->num_rows > 0){
  while($book = $result->fetch_assoc()):
?>
  <div class="col-md-3 mb-4">
    <div class="card">
      <img src="uploads/<?php echo $book['book_image']; ?>" class="card-img-top" height="200">
      <div class="card-body">
        <h5 class="card-title"><?php echo $book['title']; ?></h5>
        <p class="card-text">Author: <?php echo $book['author']; ?></p>
        <p class="card-text"><b>₹<?php echo $book['price']; ?></b></p>
        <a href="#" class="btn btn-primary">Add to Cart</a>
      </div>
    </div>
  </div>
<?php 
  endwhile; 
} else {
  echo "<p>No books found. Add some books from database.</p>";
}
?>
</div>

<?php include 'includes/footer.php'; ?>