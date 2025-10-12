<?php
include("db.php");
session_start();

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid Request");
}

// Fetch existing Kabadiwala details
$result = mysqli_query($conn, "SELECT * FROM users WHERE id='$id' AND role='kabadiwala'");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("Kabadiwala not found");
}

// Update Kabadiwala data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $update = "UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id='$id'";
    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Kabadiwala updated successfully'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Update failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Kabadiwala</title>
<style>
body {
    font-family: Arial;
    background-color: #f9f9f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
form {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.2);
    width: 350px;
}
input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
}
button {
    width: 100%;
    background-color: #c30010;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
button:hover {
    background-color: #9c000c;
}
a {
    display: inline-block;
    text-align: center;
    margin-top: 10px;
    color: #c30010;
    text-decoration: none;
}
</style>
</head>
<body>
<form method="POST">
    <h2>Edit Kabadiwala</h2>
    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
    <button type="submit">Update</button>
    <a href="admin_dashboard.php">Cancel</a>
</form>
</body>
</html>
