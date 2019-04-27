<?php 
require('connection.php');
require_once('session.php');
//redirect function
function Redirect_to($page){
    header("Location: $page");
    exit;
}

// // login function
// function loginAttempet($username, $password){
//     $sql_cmd = "SELECT * FROM registeration WHERE username='$username' AND password='$password'";
//     $res = mysqli_query($conn, $sql_cmd);
//     if($admin = mysqli_fetch_assoc($res)){
//         return $admin;
//     }else{
//         return null;
//     }
// }

function confirmLogin(){
    if(!isset($_SESSION['user_id'])){
        $_SESSION['ErrorMessage'] = "Login Required";
        Redirect_to('login.php');
    }
}
?>