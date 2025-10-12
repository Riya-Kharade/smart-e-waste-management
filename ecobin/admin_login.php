<?php
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Hardcoded admin credentials
    $admin_user = "ecobin_riya";
    $admin_pass = "Riya@210";

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['user_id'] = 1;
        $_SESSION['name']    = "Admin";
        $_SESSION['role']    = "admin";

        header("Location: admin_dashboard.php");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Invalid admin credentials.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { height:100vh; margin:0; display:flex; justify-content:center; align-items:center; background:url('https://cdn.unenvironment.org/2022-11/GettyImages-1372577388_small.jpeg') no-repeat center center fixed; background-size:cover; font-family:'Arial',sans-serif; }
.overlay { position:absolute; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1; }
.login-card { position:relative; z-index:2; background:rgba(255,255,255,0.95); border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.3); padding:30px; width:100%; max-width:400px; text-align:center; animation:fadeIn 1s ease-in-out; }
.login-card h4 { margin-bottom:25px; font-weight:bold; }
.btn-danger { transition: all 0.3s; }
.btn-danger:hover { background-color:#c82333; transform:translateY(-2px); }
@keyframes fadeIn { from { opacity:0; transform:translateY(-20px);} to {opacity:1; transform:translateY(0);} }
.form-label { font-weight:500; }
</style>
</head>
<body>
<div class="overlay"></div>
<div class="login-card">
    <?php echo $message; ?>
    <h3 class="mb-3">Admin Login</h3>
    <form method="POST" action="">
        <div class="mb-3 text-start">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger w-100">Login</button>
    </form>
</div>
</body>
</html>
