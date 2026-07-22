<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit(); }
$user_id = $_SESSION['user_id'];

// Add to cart
if(isset($_GET['add'])){
    $book_id = $_GET['add'];
    $check = $conn->query("SELECT * FROM cart WHERE user_id=$user_id AND book_id=$book_id");
    if($check->num_rows > 0){
        $conn->query("UPDATE cart SET qty=qty+1 WHERE user_id=$user_id AND book_id=$book_id");
    } else {
        $conn->query("INSERT INTO cart(user_id, book_id) VALUES($user_id, $book_id)");
    }
    header("Location: cart.php");
}

// Remove from cart
if(isset($_GET['remove'])){
    $id = $_GET['remove'];
    $conn->query("DELETE FROM cart WHERE id=$id AND user_id=$user_id");
    header("Location: cart.php");
}
?>

<div class="container mt-4">
<h2>My Cart</h2>
<table class="table">
<tr><th>Book</th><th>Price</th><th>Qty</th><th>Action</th></tr>
<?php
$total=0;
$result = $conn->query("SELECT c.id, b.title, b.price, c.qty FROM cart c JOIN books b ON c.book_id=b.id WHERE c.user_id=$user_id");
while($row=$result->fetch_assoc()){
    $sub = $row['price'] * $row['qty'];
    $total += $sub;
    echo "<tr><td>{$row['title']}</td><td>₹{$row['price']}</td><td>{$row['qty']}</td><td><a href='cart.php?remove={$row['id']}' class='btn btn-danger btn-sm'>Remove</a></td></tr>";
}
echo "<tr><th colspan=3>Total: ₹$total</th><th><a href='checkout.php' class='btn btn-success'>Checkout</a></th></tr>";
?>
</table>
</div>
<?php include 'includes/footer.php'; ?>