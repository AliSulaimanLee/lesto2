<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>
        <br/><br/>

            <?php include('partials/display-session.php');  //Session section ?>

            <br/><br/><br/>

            <!-- Button to add category -->
            <a href="<?php echo HOMEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
                
            <br/><br/>
            <table class="tbl-full">
                    <tr>
                        <th>ID</th>
                        <th>Title </th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        $sql = "SELECT * FROM kategori_menu";
                        
                        $res = mysqli_query($conn, $sql);

                        //count rows
                        $count = mysqli_num_rows($res); //return number of rows

                        //check whether database have data
                        if($count>0) { 
                            //get data and display
                            while($row=mysqli_fetch_assoc($res)) {
                                $id_category = $row['id_kategori'];
                                $title = $row['nama_kategori'];
                                $image_name = $row['nama_gambar'];
                                $featured = $row['featured'];
                                $active = $row['active'];
                            
                                ?> 
                                    <tr>
                                        <td><?php echo $id_category; ?></td>
                                        <td><?php echo $title; ?></td>

                                        <td>
                                            <?php 
                                                //check whether image name exist
                                                if($image_name!=""){

                                                    //echo $image_name;
                                                    ?> 
                                                        <img src="<?php echo HOMEURL;?>images/category/<?php echo $image_name;?>" width="100px">
                                                    <?php
                                                } else{
                                                    echo "<div class='grey'>no image</div>"; //success, error can be used. but anything else can't
                                                }
                                            ?>
                                        </td>

                                        <td><?php echo $featured; ?></td>
                                        <td><?php echo $active; ?></td>
                                        <td>
                                            <a href="<?php echo HOMEURL;?>admin/update-category.php?id_category=<?php echo $id_category; ?>" class="btn-secondary">Update</a>
                                            <a href="<?php echo HOMEURL;?>admin/delete-category.php?id_category=<?php echo $id_category; ?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                
                                <?php //restart php
                            }



                        } else{
                            //display msg inside table
                            ?> 
                            <tr>
                                <td colspan="6">
                                    <div class='error'>Category Empty.</div>
                                </td>
                            </tr>
                            <?php 
                            
                        }
                    
                    ?>

                    <!--Dummy data // placeholder -->
                    

                    
            </table>
    </div>
</div>

<?php include('partials/footer.php') ?>
