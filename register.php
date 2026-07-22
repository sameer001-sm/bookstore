<?php 
include 'includes/db.php'; 

$msg = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // password encrypt
    
    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s",$email);
    $check->execute();
    if($check->get_result()->num_rows > 0){
        $msg = "<div class='alert alert-danger'>Email already registered!</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, 'user')");
        $stmt->bind_param("sss",$name,$email,$pass);
        if($stmt->execute()){
            $msg = "<div class='alert alert-success'>Registration successful! <a href='login.php'>Login Now</a></div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - BookBazaar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:400px;">
    <h3 class="text-center mb-4">Create Account</h3>
    
    <?php echo $msg; ?>
    
    <form method="post" class="card p-4 shadow">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-success w-100">Register</button>
    </form>
    <p class="text-center mt-3">Already have account? <a href="login.php">Login Here</a></p>
</div>
</body>
</html>