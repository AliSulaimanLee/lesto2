<?php include('partials/menu.php');?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        
        <br><br>
        <?php include('partials/display-session.php'); ?>
        <?php 
            //check whether id is set
            if(isset($_GET['id_category'])) {

                //get data
                $id_category = $_GET['id_category'];

                $sql = "SELECT * FROM kategori_menu WHERE id_kategori ='$id_category'";
                $res = mysqli_query($conn, $sql);
                //count rows to check whether id is valid
                $count = mysqli_num_rows($res);

                if($count==1) {
                    //get all data
                    $row =mysqli_fetch_assoc($res);
                    //get individual data
                    $title = $row['nama_kategori'];
                    $current_image = $row['nama_gambar'];
                    $featured = $row['featured'];
                    $active = $row['active'];

                } else{
                    $_SESSION['no-category-found'] = "<div class='error'>Category not found.</div>";
                    header('location:'.HOMEURL.'admin/manage-category.php');
                }
                

            } else{
                //redirect 
                header('location:'.HOMEURL.'admin/manage-category.php');
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title?>">
                    </td>
                </tr>

                <tr>
                    <td>Image: </td>
                    <td>
                        <?php 
                            if($current_image != "") { //if image is not blank
                                //display image
                                ?> 
                                <img src="<?php echo HOMEURL; ?>images/category/<?php echo $current_image;?>" width ="200px">
                                <?php
                            } else{
                                echo "<div class='grey'>No Image</div>";
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
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value ="Yes"> Yes
                        <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value ="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value ="Yes"> Yes
                        <input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value ="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                        <input type="hidden" name="id_category" value="<?php echo $id_category;?>">
                        <input type="submit" value="Update Category" name="submit" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
            if(isset($_POST['submit'])) {
                //get all data from Form
                $id_category = $_POST['id_category']; //good practice
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //update new image if selected
                //check whether a new image is selected
                if(isset($_FILES['image']['name'])) {

                    //get image details
                    $image_type = $_FILES['image']['type'];

                    if(preg_match("#image#i", $image_type)) { //again, not ideal. //NEED BUG FIX
                         $image_name = $_FILES['image']['name'];   

                         if($image_name != "") {
                            
                            //Auto rename image
                        
                            //Get extension of image
                            $ext = end(explode('.', $image_name)); //similar to .split python
                            //PSEUDOCODE = split name into 2 parts separated by '.' put in an array. select the end of the array.

                            $image_name = "Food_Category_".rand(000,999).'.'.$ext; //Food_Category_021.png


                            $source_path = $_FILES['image']['tmp_name']; //source path
                            $destination_path = "../images/category/".$image_name; 

                            //upload image
                            $upload = move_uploaded_file($source_path, $destination_path);

                            //check if image failed to upload
                            if($upload==FALSE) {
                                //stop process and redirect with error msg
                                $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                                header('location:'.HOMEURL.'admin/manage-category.php');
                                die();
                            
                            }
                            //remove current image
                            if($current_image !="") {
                                $remove_path = "../images/category/".$current_image; 
                                $remove = unlink($remove_path);

                                //check whether image is removed or not 
                                if($remove==FALSE) {
                                    $_SESSION['failed-remove'] = "<div class='error'>Failed to remove image.</div>";
                                    header('location:'.HOMEURL.'admin/manage-category.php');
                                    die();
                                }
                            } 
                             

                         } else{
                            $image_name = $current_image;
                         }
 
                    }else{
                        $_SESSION['upload']= "<div class='grey'>Image not updated: Incorrect format or No new image selected.</div>";
                        $image_name = $current_image;
                        //header('location:'.HOMEURL.'admin/manage-category.php');
                        //die(); //stop the process

                    } //part of the preg_match function, need bug fix. //bug fixed

                } else{
                    $image_name = $current_image;
                }




                //update database
                $sql2 = "UPDATE kategori_menu SET
                    nama_kategori = '$title',
                    nama_gambar = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id_kategori = '$id_category'
                ";

                $res2 = mysqli_query($conn, $sql2);

                //check whether query is executed
                if($res2==TRUE) {
                    //category updated
                    $_SESSION['update'] = "<div class='success'>Category updated.</div>";
                    header('location:'.HOMEURL.'admin/manage-category.php');
                } else{
                    $_SESSION['update'] = "<div class='error'>Failed to update Category.</div>";
                    header('location:'.HOMEURL.'admin/update-category.php');
 
                
                }
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php');?>