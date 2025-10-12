<?php
session_start();
include("db.php");

// Check if customer is logged in
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer'){
    header("Location: login.php");
    exit();
}

if(isset($_POST['message'], $_POST['kabadiwala_id'])){
    $customer_id = $_SESSION['user_id'];
    $kabadiwala_id = $_POST['kabadiwala_id'];
    $message = trim($_POST['message']);

    if($message != ""){
        $stmt = $conn->prepare("INSERT INTO messages (customer_id, kabadiwala_id, sender_type, message, sent_at) VALUES (?, ?, 'customer', ?, NOW())");
        $stmt->bind_param("iis", $customer_id, $kabadiwala_id, $message);
        if($stmt->execute()){
            $_SESSION['message'] = "Message sent successfully!";
        } else {
            $_SESSION['message'] = "Failed to send message!";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Message cannot be empty!";
    }

    header("Location: customer_dashboard.php");
    exit();
}
?>
