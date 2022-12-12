<?php include('partials/menu.php'); ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br>

        <?php include('partials/display-session.php'); ?>
        <br/>

        <form action="" method="POST" enctype="multipart/form-data"> <!--enctype multipart form data allow image file to be uploaded -->

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Category title"></td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td
                    ><input type="file" name='image'>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No" checked>No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td> 
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No" checked>No
                    </td>

                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

        <?php 
            if(isset($_POST['submit'])){
                
                //get data from Form
                $nama_kategori = $_POST['title'];
                
                //for radio type, check whether option is selected
                if(isset($_POST['featured'])) {
                    
                    $featured = $_POST['featured'];
                } else {
                    $featured = "No"; //QUESTIONABLE, are else mandatory? if value is 'no'. then it will be no either way.
                }                     //Pseudo-code : if featured is set, featured takes data from FORM (either yes/no)
                                      //else if NO VALUE WAS SET, default to 'no'. nvm

                if(isset($_POST['active'])) {
                    $active = $_POST['active'];
                } else{
                    $active ="No";
                }

                //check whether image is selected and set value for image name accordingly
                //print_r($_FILES['image']);
                //die(); //break/stop the code
                
                if(isset($_FILES['image']['name'])) { //if input type file image has been set, and has a name value
                    
                    //check whether file is image
                    $image_type = $_FILES['image']['type'];
                    if(preg_match("#image#i",$image_type)) {//check by matching extension, not ideal. consider getimageSize
                        //get image name, source path, and destination path //problem, if no image. send error.
                        $image_name = $_FILES['image']['name'];
                        
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
                            header('location:'.HOMEURL.'admin/add-category.php');
                            die();
                        
                        }

                    } /*
                        //else if($_FILES['cover_image']['size'] == 0 && $_FILES['cover_image']['error'] == 0){ //blank file
                      //  $image_name="";

                    } */ //to check if file is not an image. NOT USED.
                    else{
                        $_SESSION['upload']= "<div class='error'>Please choose an Image File</div>";
                        header('location:'.HOMEURL.'admin/add-category.php');
                        die(); //stop the process
                    }

                    
                } else{
                    
                    //set image_name value as blank
                    $image_name="";
                }

                //insert category to database
                $sql = "INSERT INTO kategori_menu SET
                    nama_kategori='$nama_kategori',
                    nama_gambar='$image_name',
                    featured='$featured',
                    active='$active'
                    ";

                //execute query
                $res = mysqli_query($conn, $sql);

                //check whether query is executed
                if($res==TRUE) {
                    
                    //category added
                    $_SESSION['add-category'] ="<div class='success'>Category added.</div>";
                    
                    header('location:'.HOMEURL.'admin/manage-category.php');
                } else{
                    //failed to add category
                    $_SESSION['add-category'] ="<div class='error'>Failed to add Category.</div>";
                    //refresh
                    header('location:'.HOMEURL.'admin/add-category.php');
                }
                                      
            
            } 
        ?>

        <br>

    </div>
</div>



<?php include('partials/footer.php'); ?>