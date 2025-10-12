<?php
include("db.php");

if(isset($_POST['id']) && isset($_POST['status']) && isset($_POST['kabadiwala_id'])){
    $id = intval($_POST['id']);
    $status = $_POST['status'];
    $kabadiwala_id = intval($_POST['kabadiwala_id']);

    $sql = "UPDATE pickup_schedule SET status='$status', kabadiwala_id='$kabadiwala_id' WHERE id=$id";
    if(mysqli_query($conn, $sql)){
        echo "Pickup request updated successfully!";
    } else {
        echo "Error updating request: ".mysqli_error($conn);
    }
}
?>
