<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br/><br/>

            <?php include('partials/display-session.php');  //Session section ?>
            <br/><br/>
            <!-- Button to add Food -->
            <a href="<?php echo HOMEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
                
            <br/><br/>
            <table class="tbl-full">
                    <tr>
                        <th>ID</th>
                        <th>Title </th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions </th>
                    </tr>

                    <?php 
                        $sql = "SELECT * FROM menu";

                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);

                        if($count>0) {
                            while($row=mysqli_fetch_assoc($res)){
                                //get value from individual column
                                $id_menu = $row['id_menu'];
                                $title = $row['nama'];
                                $price = $row['harga'];
                                $image_name = $row['nama_gambar'];
                                $featured = $row['featured'];
                                $active = $row['active'];
                                ?> 
                                    <tr>
                                        <td><?php echo $id_menu;?></td>
                                        <td><?php echo $title;?></td>
                                        <td>Rp.<?php echo $price;?></td>
                                        <td>
                                            <?php 
                                                if($image_name == "") {
                                                    echo "<div class='grey'>No image.</div>";
                                                } else{
                                                    ?> 
                                                    <img src="<?php echo HOMEURL;?>images/food/<?php echo $image_name;?>" width = "100px">
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $featured;?></td>
                                        <td><?php echo $active;?></td>
                                        <td>
                                            <a href="<?php echo HOMEURL;?>admin/update-food.php?id_menu=<?php echo $id_menu;?>" class="btn-secondary">Update</a>
                                            <a href="<?php echo HOMEURL;?>admin/delete-food.php?id_menu=<?php echo $id_menu;?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete</a>
                                        </td>
                                    </tr>

                                <?php
                            }
                            
                        } else{
                            echo "<tr><td colspan='7' class = 'error'>Food not yet added.</td></tr>"; //another way to write html in php

                        }
                    ?>

                    <!--Dummy data // placeholder -->
                    
            </table>
    </div>
</div>

<?php include('partials/footer.php') ?>
