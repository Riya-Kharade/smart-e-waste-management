<?php
include("db.php");

if(isset($_POST['id']) && is_numeric($_POST['id'])){
    $id = intval($_POST['id']);
    $query = "DELETE FROM users WHERE id=$id AND role='kabadiwala'";
    if(mysqli_query($conn, $query)){
        echo "Kabadiwala deleted successfully (messages auto-deleted)";
    } else {
        echo "Error deleting kabadiwala: " . mysqli_error($conn);
    }
} else {
    echo "Invalid ID";
}
?>
