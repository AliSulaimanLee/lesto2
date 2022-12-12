<?php include('partials-front/menu.php');?>
    <!-- Navbar Section Ends Here -->
    
    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>


            <?php 
                //sql query to display active categories
                $sql = "SELECT * FROM kategori_menu WHERE active='Yes'";

                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                if($count>0) {
                    while($row=mysqli_fetch_assoc($res)){
                        $id_category = $row['id_kategori'];
                        $title = $row['nama_kategori'];
                        $image_name = $row['nama_gambar'];

                        ?>  
                            <a href="<?php echo HOMEURL;?>category-foods.php">
                                <div class="box-3 float-container">
                                    <?php 
                                        if($image_name=="") {
                                            //image unavailable
                                            echo "<div class='grey'>No image</div>";
                                        } else{
                                            ?>
                                            <img src="<?php echo HOMEURL;?>images/category/<?php echo $image_name;?>" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                                    

                                    <h3 class="float-text text-white text-border"><?php echo $title;?></h3>
                                </div>
                            </a> 

                        <?php

                    }

                } else {
                    echo "<div class='grey'>No category available</div>";
                }
            ?>
                     

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php') ?>