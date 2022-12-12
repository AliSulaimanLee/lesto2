<?php 
    //authorization - access control
    //check whether user is logged in
    if(!isset($_SESSION['user'])) { //if user session not set (expired)
        //redirect
        $_SESSION['not-login-msg'] = "<div class='error text-center'>Access Denied. Please Log in.</div>";
    
        header('location:'.HOMEURL.'admin/login.php');
    }

?>