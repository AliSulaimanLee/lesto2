<?php 
    include('../config/constants.php');

    //check whether value is passed on url
    if(isset($_GET['id_menu']) AND isset($_GET['image_name'])) {
        //get id and image name
        $id_menu = $_GET['id_menu'];
        $image_name = $_GET['image_name'];

        if($image_name != "") {
            $path ="../images/food/".$image_name;
            
            //remove img from folder

            $remove = unlink($path);

            if($remove==FALSE) {
                $_SESSION['upload'] = "<div class='error'>Failed to remove image.</div>";
                header('location:'.HOMEURL."admin/manage-food.php");
                die();
            } 
            
        } else{
            $image_name =#
        }

        $sql = "DELETE FROM menu WHERE id_menu = '$id_menu'";

        $res = mysqli_query($conn, $sql);

        if($res==TRUE) {
            //deleted
            $_SESSION['delete'] = "<div class='success'>Food deleted</div>";
            header('location:'.HOMEURL."admin/manage-food.php");
        } else{ 
            $_SESSION['delete'] = "<div class='error'>Failed to delete food.</div>";
            header('location:'.HOMEURL."admin/manage-food.php");

        }

        //remove image if available

        //delete food from db
        
    } else{
        //redirect
        header('location:'.HOMEURL."admin/manage-food.php");
    }
?>