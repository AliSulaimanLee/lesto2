<?php 
include('config/constants.php');

if(isset($_GET['id_menu'])) {
    //print_r($_GET['id_menu']); //tes
    
    $id_menu = $_GET['id_menu'];

    foreach($_SESSION['cart'] as $key => $value) { //PSEUDO-CODE : for every index in array as key, refer to value
        if($value['id_menu'] == $_GET['id_menu']) { //if value is equal to id get on url, execute:
            unset($id_menu_array["$id_menu"]);
            unset($_SESSION['cart'][$key]);
            echo "<script>alert('Item Removed.')</script>";
            echo "<script>window.location ='cart.php'</script>";
            header('location:'.HOMEURL."cart.php");
            //redirect

        }
    }
}   
else{
    header('location:'.HOMEURL."cart.php");
}

?>