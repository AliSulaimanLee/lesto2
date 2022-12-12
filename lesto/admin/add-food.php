<?php include('partials/menu.php'); ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br>

        <?php include('partials/display-session.php'); ?>
        <br/>

        <form action="" method="POST" enctype="multipart/form-data"> <!--enctype multipart form data allow image file to be uploaded -->

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Food title"></td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" >
                    </td>
                </tr>

                <tr>
                    <td>Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php 
                                //query to get active categories from db
                                $sql = "SELECT * FROM kategori_menu WHERE active='Yes'";
                            
                                $res = mysqli_query($conn, $sql);

                                //check whether category exist
                                $count = mysqli_num_rows($res);
                                if($count>0) {
                                    while($row=mysqli_fetch_assoc($res)) {
                                        //get details of category
                                        $id_category = $row['id_kategori'];
                                        $title_category = $row['nama_kategori'];

                                        ?> 
                                            <option value="<?php echo $id_category;?>"><?php echo $title_category;?></option>
                                        <?php
                                    }

                                } else{
                                    ?>
                                        <option value="0">no category found</option>
                                    <?php
                                }
                            ?>
                        </select>
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
            //check whether button is clicked
            if(isset($_POST['submit'])) {
                //get data from Form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //check radio buttons and get value accordingly
                if(isset($_POST['featured'])) {
                    $featured = $_POST['featured'];
                } else{
                    $featured = "No";   //default
                }

                if(isset($_POST['active'])) {
                    $active = $_POST['active'];
                } else{
                    $active = "No";   
                }

                if(isset($_FILES['image']['name'])) {
                    //get details of file
                    $image_name = $_FILES['image']['name'];

                    if($image_name != "") {
                        //rename image
                        $ext = end(explode('.', $image_name));
                        $image_name = "Food_Name_".rand(0000,9999).".".$ext;
                        
                        //find path
                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/food/".$image_name;
                        
                        //upload image
                        $upload =move_uploaded_file($source_path, $destination_path);

                        if($upload == FALSE) {
                            //failed
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                            header('location:'.HOMEURL."admin/add-food.php");
                            die();
                        }
                    }   

                    //check whether image selected

                } else{
                    $image_name =""; //blank
                }
                
                //insert into db
                $sql2 = "INSERT INTO menu SET
                    nama = '$title',
                    deskripsi = '$description',
                    harga = '$price',
                    nama_gambar = '$image_name',
                    id_kategori = '$id_category',
                    featured = '$featured',
                    active = '$active'
                    ";

                $res2 = mysqli_query($conn, $sql2);

                if($res2 ==TRUE) {
                    $_SESSION['add'] = "<div class='success'>Food added.</div>";
                    header('location:'.HOMEURL."admin/manage-food.php");
                } else {
                    $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";
                    header('location:'.HOMEURL."admin/add-food.php");

                }


            }
        ?>

        <br>

    </div>
</div>



<?php include('partials/footer.php'); ?>