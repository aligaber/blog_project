<?php 
require('connection.php');
require('session.php');
include('functions.php');
?>
<?php confirmLogin(); ?>
<?php 
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql_cmd = "DELETE FROM `registeration` WHERE `id`=$id";
    
    if(mysqli_query($conn, $sql_cmd)){
        $_SESSION['SuccessMessage'] = "Admin Deleted Successfully";
        Redirect_to("admins.php?id=$id");
    }else{
        $_SESSION['ErrorMessage'] = "Something Went Wrong , Please Try Again";
        Redirect_to("admins.php?id=$id");
    }
}

?>