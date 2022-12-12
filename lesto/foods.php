<?php include('partials-front/menu.php');?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">

            <form action="<?php echo HOMEURL;?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                $sql = "SELECT * FROM menu WHERE active='Yes'";

                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                if($count>0) {
                    while($row=mysqli_fetch_assoc($res)){
                        $id_category = $row['id_menu'];
                        $title = $row['nama'];
                        $description = $row['deskripsi'];
                        $price = $row['harga'];
                        $image_name = $row['nama_gambar'];

                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    if($image_name==""){
                                        echo "<div class='grey'>No image</div>";
                                    } else{
                                        ?>
                                        <img src="<?php echo HOMEURL;?>images/food/<?php echo $image_name;?>" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>

                                
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title;?></h4>
                                <p class="food-price">Rp.<?php echo $price;?></p>
                                <p class="food-detail">
                                    <?php echo $description;?>
                                </p>
                                <br>

                                <a href="#" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>



                        <?php

                   
                   
                   
                    }
                } else{
                    "<div class='grey'>No food available.</div>";
                }
            
            ?>

            


            <div class="clearfix"></div>



        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php') ?>