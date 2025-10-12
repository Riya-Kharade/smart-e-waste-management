<?php
include("db.php");
if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    $q = mysqli_query($conn, "DELETE FROM holiday_notices WHERE id=$id");
    if($q) echo "Holiday deleted successfully!";
    else echo "Error deleting holiday.";
} else {
    echo "Invalid request!";
}
?>
