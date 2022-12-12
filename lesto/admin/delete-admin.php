<?php 
    include('../config/constants.php');

    //get ID of to-be-deleted admin
    $id_admin = $_GET['id_admin'];

    //SQL query to delete admin
    $sql = "DELETE FROM tabel_admin WHERE id_admin = $id_admin";

    //execute query
    $res = mysqli_query($conn, $sql);

    //check whether query is executed
    if($res==TRUE){ //executed
        //create session variable to display msg
        $_SESSION['delete'] = "<div class='success'>Admin deleted. </div>"; //color doesn't work, why?

        header('location:'.HOMEURL.'admin/manage-admin.php');

    } else { //failed to execute 
       $_SESSION['delete'] = "<div class='error'>Failed to delete Admin. </div>";

       header('location:'.HOMEURL.'admin/manage-admin.php');
    }

    //redirect to manage-admin.php and display appropriate msg



?>