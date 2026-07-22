<?php 
session_start();
include '../includes/db.php';
if($_SESSION['role'] != 'admin'){ header("Location: ../login.php"); exit; }

// Status update
if(isset($_POST['update_status'])){
    $id = $_POST['order_id'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    header("Location: manage_orders.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Manage Orders</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-4">
<h3>📦 Manage Orders</h3>
<a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>
<table class="table table-bordered">
<thead class="table-dark">
<tr><th>Order ID</th><th>Customer</th><th>Total</th><th>Date</th><th>Status</th><th>Action</th></tr>
</thead>
<tbody>
<?php
$result = $conn->query("SELECT o.*, u.name FROM orders o JOIN users u ON o.user_id=u.id ORDER BY o.id DESC");
while($row = $result->fetch_assoc()){
?>
<tr>
    <td>#<?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td>₹<?php echo $row['total_price']; ?></td>
    <td><?php echo $row['order_date']; ?></td>
    <td>
        <form method="POST" class="d-flex">
            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
            <select name="status" class="form-select form-select-sm me-2">
                <option <?php if($row['status']=='Pending') echo 'selected'; ?>>Pending</option>
                <option <?php if($row['status']=='Shipped') echo 'selected'; ?>>Shipped</option>
                <option <?php if($row['status']=='Delivered') echo 'selected'; ?>>Delivered</option>
            </select>
            <button name="update_status" class="btn btn-sm btn-primary">Update</button>
        </form>
    </td>
    <td><a href="order_details.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">View</a></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</body>
</html>