<?php include('../config/constants.php');

    //echo "Delete Page";

    //check whether id_category and image_name is set/passed.
    if(isset($_GET['id_category']) AND isset($_GET['image_name'])) {
        //get value and delete
        $id_category = $_GET['id_category'];
        $image_name = $_GET['image_name'];

        //remove physical image file
        if($image_name != "") {// if image available
            //find image path
            $path = "../images/category/".$image_name;
            //delete
            $remove = unlink($path); //remove file from folder
            
            //check if image deleted
            if($remove==FALSE) { //failed to remove
                $_SESSION['remove'] = "<div class='error'>Failed to remove image.</div>";
                header('location:'.HOMEURL.'admin/manage-category.php');
                die(); //redirect and stop
            }
        }

        //delete data
        $sql = "DELETE FROM kategori_menu WHERE id_kategori = '$id_category'";

        $res= mysqli_query($conn, $sql);

        if($res==TRUE) {
            $_SESSION['delete'] = "<div class='success'>Category deleted.</div>";
            //redirect
            header('location:'.HOMEURL.'admin/manage-category.php');
        } else{
            $_SESSION['delete'] = "<div class='error'>Failed to delete Category.</div>";
            //redirect
            header('location:'.HOMEURL.'admin/manage-category.php');
        
        }


    } else{
        //redirect 
        header('location:'.HOMEURL.'admin/manage-category.php');
    }


?>

