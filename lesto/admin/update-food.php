<?php include('partials/menu.php'); ?>

<?php 
    if(isset($_GET['id_menu'])) {//if id_menu is set
        
        //get details
        $id_menu = $_GET['id_menu'];

        $sql2 = "SELECT * FROM menu WHERE id_menu ='$id_menu'";

        $res2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($res2);

        //get individual data
        $title = $row2['nama'];
        $description = $row2['deskripsi'];
        $price = $row2['harga'];
        $current_image = $row2['nama_gambar'];
        $current_category_id = $row2['id_kategori'];

        $featured = $row2['featured'];
        $active = $row2['active'];

    } else{
        //redirect
        header('location:'.HOMEURL."admin/manage-food.php");
    }

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <?php include('partials/display-session.php'); ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title;?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description;?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name ="price" value="<?php echo $price;?>">
                    </td>
                </tr>

                <tr>
                    <td>Image: </td>
                    <td>
                        <?php 
                            if($current_image=="") {
                                echo "<div class='grey'>No image</div>";
                            } else{
                                ?>
                                    <img src="<?php echo HOMEURL; ?>images/food/<?php echo $current_image;?>" width="100px">
                                <?php
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Change Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php 
                                //query to get active categories
                                $sql= "SELECT * FROM kategori_menu WHERE active='Yes'";

                                $res= mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($res);

                                if($count>0) {
                                    //category exist
                                    while($row=mysqli_fetch_assoc($res)) {
                                        $category_title = $row['nama_kategori'];
                                        $category_id = $row['id_kategori'];
                                       
                                        //echo "<option value='$category_id'>$category_title</option>"; //alt ver
                                        ?>
                                            <option <?php if($current_category_id==$category_id){echo "selected";}?> value="<?php echo $category_id; ?>"><?php echo $category_title;?></option>
                                        <?php
                                    }

                                } else{
                                    echo "<option value='0'>Category not available</option>"; 
                                }

                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";}?> type="radio" name="featured" value ="Yes"> Yes
                        <input <?php if($featured=="No") {echo "checked";}?> type="radio" name="featured" value ="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes") {echo "checked";}?> type="radio" name="active" value ="Yes"> Yes
                        <input <?php if($active=="No") {echo "checked";}?> type="radio" name="active" value ="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id_menu" value ="<?php echo $id_menu; ?>">
                        <input type="hidden" name="current_image" value ="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
                
            </table>
        </form>

        <?php 
            if(isset($_POST['submit'])) {
                //update
                //get data from Form
                $id_menu = $_POST['id_menu'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //upload if image selected
                if(isset($_FILES['image']['name'])) {

                    $image_type = $_FILES['image']['type'];

                    if(preg_match("#image#i", $image_type)) {
                                     
                        $image_name = $_FILES['image']['name'];

                        if($image_name!="") {
                            $temp = explode('.', $image_name);
                            $ext = end($temp); //temp for bug fix
                            
                            $image_name = "Food_Name_".rand(0000,9999).'.'.$ext;

                            $source_path = $_FILES['image']['tmp_name'];
                            $destination_path = "../images/food/".$image_name;

                            $upload = move_uploaded_file($source_path, $destination_path);

                            if($upload==FALSE) {
                                $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                                header('location:'.HOMEURL.'admin/manage-food.php');
                                die();

                            }

                            if($current_image != "") {
                                $remove_path = "../images/food/".$current_image;

                                $remove = unlink($remove_path);

                                if($remove==FALSE){
                                    
                                    $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                                    header('location:'.HOMEURL."admin/update-food.php?id_menu=".$id_menu);
                                    die();
                                }
                            }
                            
                        } else{
                            $image_name = $current_image;
                        }
                    } else{
                        $_SESSION['upload']= "<div class='grey'>Image not updated: Incorrect format or No new image selected.</div>";
                        $image_name = $current_image;
                    }
                } else{
                    $image_name = $current_image;

                } 

                //update database
                $sql3 = "UPDATE menu SET
                    nama = '$title',
                    deskripsi = '$description',
                    harga = '$price',
                    nama_gambar = '$image_name',
                    id_kategori = '$category',
                    featured = '$featured',
                    active = '$active' 
                    WHERE id_menu = '$id_menu'
                ";
                                        //ERROR SQL failed, why?
                                        //FINISHED bug fix
                                        //new bug no default img
                                        //bug fixed
                $res3 = mysqli_query($conn, $sql3);

                if($res3==TRUE) {
                    $_SESSION['update'] = "<div class='success'>Food updated.</div>";
                    header('location:'.HOMEURL."admin/manage-food.php");
                    
                } else{
                    $_SESSION['update'] = "<div class='error'>Failed to update food.</div>";
                    header('location:'.HOMEURL."admin/update-food.php?id_menu=".$id_menu);

                } 
            }
        ?>
    </div>

</div>
<?php include('partials/footer.php'); ?>

<!-- To DO
            1. default image if not changed

-->