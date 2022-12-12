<?php 
    include('../config/constants.php');

    //destroy session
    session_destroy();

    //redirect
    header('location:'.HOMEURL.'admin/login.php');
?>