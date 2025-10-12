<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'kabadiwala') {
    header("Location: login.php");
    exit();
}

$kabadiwala_id = $_SESSION['user_id'];
$message = trim($_POST['message']);
$customer_id = $_POST['customer_id'];

if($message != "" && $customer_id != "") {
    $sql = "INSERT INTO messages (kabadiwala_id, customer_id, message, sender_type, sent_at) 
            VALUES ('$kabadiwala_id', '$customer_id', '".mysqli_real_escape_string($conn, $message)."', 'kabadiwala', NOW())";
    mysqli_query($conn, $sql);
}

header("Location: kabadiwala_dashboard.php#messages"); // redirect back to messages
exit();
?>
