<?php
include("db.php");

if(isset($_POST['notice_date']) && isset($_POST['description'])){
    $date = mysqli_real_escape_string($conn,$_POST['notice_date']);
    $desc = mysqli_real_escape_string($conn,$_POST['description']);

    $sql = "INSERT INTO holiday_notices (notice_date, description) VALUES ('$date','$desc')";
    if(mysqli_query($conn,$sql)){
        echo "success";
    } else {
        echo "error";
    }
}
?>
