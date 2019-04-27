<?php
session_start();


//define error message
function ErrorMessage(){
    if(isset($_SESSION['ErrorMessage'])){
        $output = "<div class='alert alert-danger'>".htmlentities($_SESSION['ErrorMessage'])."</div>";
        $_SESSION['ErrorMessage'] = null;
        return $output;
    }
}

//define success message 
function SuccessMessage(){
    if(isset($_SESSION['SuccessMessage'])){
        $output = "<div class='alert alert-success'>".htmlentities($_SESSION['SuccessMessage'])."</div>";
        $_SESSION['SuccessMessage'] = null;
        return $output;
    }
}
?>