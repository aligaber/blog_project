<?php require('session.php'); ?>
<?php require('functions.php'); ?>

<?php 
$_SESSION['user_id'] = null;
session_destroy();
Redirect_to('login.php');

?>