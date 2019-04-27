<?php 
require('connection.php');
require('session.php');
include('functions.php');
?>
<?php confirmLogin(); ?>
<?php 
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql_cmd = "UPDATE `comments` SET `status`= 'OFF' WHERE `id`=$id";
    
    if(mysqli_query($conn, $sql_cmd)){
        $_SESSION['SuccessMessage'] = "Comment Disapproved Successfully";
        Redirect_to("comments.php?id=$id");
    }else{
        $_SESSION['ErrorMessage'] = "Something Went Wrong , Please Try Again";
        Redirect_to("comments.php?id=$id");
    }
}

?>