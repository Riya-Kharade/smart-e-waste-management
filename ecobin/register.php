<?php
// register.php
include("db.php"); // include database connection (make db.php with mysqli_connect)

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $role     = trim($_POST['role']);
    $agree    = isset($_POST['agree']) ? 1 : 0;

    if (!$agree) {
        $message = "<div class='alert alert-danger'>You must agree to the terms.</div>";
    } else {
        // Validate inputs
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $message = "<div class='alert alert-danger'>Name must contain only letters and spaces.</div>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "<div class='alert alert-danger'>Invalid email format.</div>";
        } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
            $message = "<div class='alert alert-danger'>Phone number must be 10 digits.</div>";
        } elseif (strlen($password) < 8) {
            $message = "<div class='alert alert-danger'>Password must be at least 8 characters long.</div>";
        } else {
            // 🔄 Store plain password (NOT recommended for real projects)
            // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Check unique phone
            $check = $conn->prepare("SELECT id FROM users WHERE phone=?");
            $check->bind_param("s", $phone);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                $message = "<div class='alert alert-danger'>Phone number already registered.</div>";
            } else {
                $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $name, $email, $phone, $password, $role);

                if ($stmt->execute()) {
                    $message = "<div class='alert alert-success'>Registration successful! <a href='login.php'>Login here</a></div>";
                } else {
                    $message = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
                }
                $stmt->close();
            }
            $check->close();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Ecobin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fff;
    }
    .register-container {
      margin-top: 80px;
    }
    .register-card {
      border: 2px solid #de0a26;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      overflow: hidden;
    }
    .register-left {
      background: #c30010;
      color: #fff;
      padding: 40px;
      text-align: center;
    }
    .register-left h2 {
      font-size: 28px;
      margin-bottom: 20px;
    }
    .register-left img {
      width: 100%;
      max-width: 250px;
      margin: 0 auto;
      display: block;
      margin-top:110px;
    }
    .register-right {
      padding: 40px;
    }
    .form-control {
      border-radius: 8px;
    }
    .btn-custom {
      background: #f01e2c;
      color: #fff;
      font-weight: bold;
      border-radius: 8px;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background: #d1001f;
    }
    .alert {
      margin-top: 10px;
    }
    /* Login link under register form */
.register-right a {
  color: #c30010;
  font-weight: bold;
  text-decoration: none;
  transition: 0.3s;
}
.register-right a:hover {
  color: #f01e2c;
  padding-left: 3px;
}

  </style>
</head>
<body>

<div class="container register-container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card register-card">
        <div class="row g-0">
          <!-- Left Side with image -->
          <div class="col-md-5 register-left">
            <h2>Welcome to Ecobin</h2>
            <p>Join us and manage e-waste smartly!</p>
            <img src="register-img.png" alt="Register Image"> <!-- You can place your image here -->
          </div>
          <!-- Right Side with form -->
          <div class="col-md-7 register-right">
            <h3 class="mb-4">Create Account</h3>
            <?php echo $message; ?>
            <form method="POST" action="">
              <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" required maxlength="10">
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required minlength="8">
              </div>
              <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                  <option value="customer">Customer</option>
                  <option value="kabadiwala">Kabadiwala</option>
                </select>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="agree" id="agree">
                <label class="form-check-label" for="agree">I agree to the terms and conditions</label>
              </div>
              <button type="submit" class="btn btn-custom w-100">Register</button>
            </form>
<p class="mt-3">Already have an account? <a href="login.php">Login here</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
