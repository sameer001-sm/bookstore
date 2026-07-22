<?php 
session_start();
include '../includes/db.php';
if($_SESSION['role'] != 'admin'){ header("Location: ../login.php"); exit; }

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id AND role='user'");
    header("Location: manage_users.php");
}
?>
<div class="container mt-4">
<h3>👥 Manage Users</h3>
<a href="dashboard.php" class="btn btn-secondary mb-3">Back</a>
<table class="table">
<thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr></thead>
<tbody>
<?php $users = $conn->query("SELECT * FROM users WHERE role='user'");
while($u = $users->fetch_assoc()){ ?>
<tr>
    <td><?php echo $u['id']; ?></td>
    <td><?php echo $u['name']; ?></td>
    <td><?php echo $u['email']; ?></td>
    <td><a href="?delete=<?php echo $u['id']; ?>" onclick="return confirm('Delete?')" class="btn btn-sm btn-danger">Delete</a></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>