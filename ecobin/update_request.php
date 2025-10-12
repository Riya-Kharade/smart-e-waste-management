<?php
include("db.php");

if(isset($_POST['request_id'])){
    $id = intval($_POST['request_id']);
    $status = isset($_POST['status']) ? mysqli_real_escape_string($conn,$_POST['status']) : null;
    $kabadiwala_id = isset($_POST['kabadiwala_id']) ? intval($_POST['kabadiwala_id']) : null;

    $fields = [];
    if($status) $fields[] = "status='$status'";
    if($kabadiwala_id) $fields[] = "kabadiwala_id=$kabadiwala_id";

    if(!empty($fields)){
        $sql = "UPDATE pickup_schedule SET ".implode(', ',$fields)." WHERE id=$id";
        if(mysqli_query($conn,$sql)){
            echo "success";
        } else echo "error";
    }
}
?>
