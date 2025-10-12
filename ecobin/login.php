<?php
include("db.php"); // database connection
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone    = trim($_POST['phone']);
    $password = trim($_POST['password']);

    // Fetch user by phone
    $stmt = $conn->prepare("SELECT id, name, role, password FROM users WHERE phone=?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // plain text comparison
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = strtolower($user['role']); // convert to lowercase for consistency

            // redirect based on role
            if ($_SESSION['role'] === 'customer') {
                header("Location: customer_dashboard.php");
            } elseif ($_SESSION['role'] === 'kabadiwala') {
                header("Location: kabadiwala_dashboard.php");
            } else {
                header("Location: index.php"); // fallback
            }
            exit();
        } else {
            $message = "<div class='alert alert-danger'>Invalid password.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>No account found with this phone number.</div>";
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Ecobin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #fff; font-family: Arial, sans-serif; }
    .login-container { margin-top: 80px; }
    .login-card { border: 2px solid #de0a26; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .login-left { background: #c30010; color: #fff; padding: 40px; text-align: center; }
    .login-left img { width: 100%; max-width: 250px; margin-top: 10px; }
    .login-right { padding: 40px; margin-top:80px; }
    .btn-custom { background: #f01e2c; color: #fff; font-weight: bold; border-radius: 8px; transition: 0.3s; }
    .btn-custom:hover { background: #d1001f; }
    .login-right a { color: #c30010; font-weight: bold; text-decoration: none; transition: 0.3s; }
    .login-right a:hover { color: #f01e2c; padding-left: 3px; }
    body { 
  background: #fff; 
  font-family: Arial, sans-serif; 
  height: 100vh; 
  display: flex; 
  justify-content: center; 
  align-items: center; 
}

.login-container { 
  width: 100%; 
  max-width: 1300px; 
}

.login-card { 
  border: 2px solid #de0a26; 
  border-radius: 12px; 
  box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
}

  </style>

</head>
<body>

<div class="container login-container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card login-card">
        <div class="row g-0">
          <!-- Left Side -->
          <div class="col-md-5 login-left">
            <h2>Welcome Back</h2>
            <p>Login to your Ecobin account</p>
            <img src="login.png" alt="Login Image">
          </div>
          <!-- Right Side -->
          <div class="col-md-7 login-right">
            <h3 class="mb-4">Login</h3>
            <?php echo $message; ?>
            <form method="POST" action="">
              <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" required maxlength="10">
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-custom w-100">Login</button>
            </form>
            <p class="mt-3">Don’t have an account? <a href="register.php">Register here</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
