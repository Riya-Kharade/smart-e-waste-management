<?php
include("db.php");

if(isset($_POST['id']) && is_numeric($_POST['id'])){
    $id = intval($_POST['id']);
    $query = "DELETE FROM users WHERE id=$id AND role='customer'";
    if(mysqli_query($conn, $query)){
        echo "Customer deleted successfully";
    } else {
        echo "Error deleting customer: " . mysqli_error($conn);
    }
} else {
    echo "Invalid";
}
?>
