<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit(); }
$user_id = $_SESSION['user_id'];

// Calculate total
$result = $conn->query("SELECT c.qty, b.price FROM cart c JOIN books b ON c.book_id=b.id WHERE c.user_id=$user_id");
$total = 0;
while($row=$result->fetch_assoc()){
    $total += $row['price'] * $row['qty'];
}

// Place Order
if($total > 0){
    $conn->query("INSERT INTO orders(user_id, total_price) VALUES($user_id, $total)");
    $order_id = $conn->insert_id;
    
    $result = $conn->query("SELECT c.book_id, c.qty, b.price FROM cart c JOIN books b ON c.book_id=b.id WHERE c.user_id=$user_id");
    while($row=$result->fetch_assoc()){
        $conn->query("INSERT INTO order_items(order_id, book_id, qty, price) VALUES($order_id, {$row['book_id']}, {$row['qty']}, {$row['price']})");
    }
    
    $conn->query("DELETE FROM cart WHERE user_id=$user_id");
    echo "<div class='container mt-5 alert alert-success'>Order Placed Successfully! Order ID: $order_id</div>";
} else {
    echo "<div class='container mt-5 alert alert-danger'>Cart is Empty!</div>";
}
?>
<div class="container text-center"><a href="index.php" class="btn btn-primary">Continue Shopping</a></div>
<?php include 'includes/footer.php'; ?>