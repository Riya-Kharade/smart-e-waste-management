<?php
include("db.php");

if(isset($_POST['id']) && isset($_POST['status'])){
    $id = intval($_POST['id']);
    $status = $_POST['status'];

    $sql = "UPDATE pickup_schedule SET status='$status' WHERE id=$id";
    if(mysqli_query($conn, $sql)){
        echo "Schedule updated successfully!";
    } else {
        echo "Error updating schedule: ".mysqli_error($conn);
    }
}
?>
