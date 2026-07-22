<?php 
session_start();
include '../includes/db.php';
if($_SESSION['role'] != 'admin'){ header("Location: ../login.php"); exit; }
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-4">
<h2>Welcome Admin: <?php echo $_SESSION['name']; ?></h2>
<a href="add_book.php" class="btn btn-success">+ Add New Book</a>
<a href="../logout.php" class="btn btn-danger float-end">Logout</a>
<a href="manage_orders.php" class="btn btn-primary">Manage Orders</a>
<a href="manage_users.php" class="btn btn-info">Manage Users</a>
</div>

<div class="container mt-4">
<h3>📊 Dashboard Stats</h3>
<div class="row">
<?php
$users = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
$orders = $conn->query("SELECT COUNT(*) as c FROM orders")->fetch_assoc()['c'];
$sales = $conn->query("SELECT SUM(total_price) as s FROM orders")->fetch_assoc()['s'];
if($sales == null) $sales = 0;
?>
  <div class="col-md-4">
    <div class="card text-bg-primary mb-3">
      <div class="card-body">
        <h5 class="card-title">Total Users</h5>
        <h2><?php echo $users; ?></h2>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-bg-success mb-3">
      <div class="card-body">
        <h5 class="card-title">Total Orders</h5>
        <h2><?php echo $orders; ?></h2>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-bg-warning mb-3">
      <div class="card-body">
        <h5 class="card-title">Total Sales</h5>
        <h2>₹<?php echo $sales; ?></h2>
      </div>
    </div>
  </div>
</div>
</div>

<div class="container mt-5">
    <h3>📚 Manage Books</h3>
    <table class="table table-bordered table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>#ID</th>
                <th>Book Name</th>
                <th>Author</th>
                <th>Price</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM books ORDER BY id DESC");
        if($result->num_rows > 0){
            while($book = $result->fetch_assoc()){
        ?>
            <tr>
                <td><?php echo $book['id']; ?></td>
                <td><?php echo $book['book_name']; ?></td>
                <td><?php echo $book['author']; ?></td>
                <td>₹<?php echo $book['price']; ?></td>
                <td>
                    <a href="edit_book.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete_book.php?id=<?php echo $book['id']; ?>" 
                       onclick="return confirm('Pakka delete karna hai?')" 
                       class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
        <?php 
            }
        } else {
            echo "<tr><td colspan='5' class='text-center'>Koi book nahi mili</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>