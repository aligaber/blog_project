<?php 
require('connection.php');
require('session.php');
include('functions.php');
?>
<?php 
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $approvedby = $_SESSION['username'];
    $sql_cmd = "UPDATE `comments` SET `status`= 'ON', `approvedby` = '$approvedby' WHERE `id`=$id";
    
    if(mysqli_query($conn, $sql_cmd)){
        $_SESSION['SuccessMessage'] = "Comment Approved Successfully";
        Redirect_to("comments.php?id=$id");
    }else{
        $_SESSION['ErrorMessage'] = "Something Went Wrong , Please Try Again";
        Redirect_to("comments.php?id=$id");
    }
}

?>