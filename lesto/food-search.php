<?php include('partials-front/menu.php');?>
    <!-- Navbar Section Ends Here -->

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php 
            $search = $_POST['search'];
            ?>
            
            <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            
            <?php
                

                $sql = "SELECT * FROM menu WHERE nama LIKE '%$search%' OR deskripsi LIKE '%$search%'";
                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                if($count>0) {
                    while($row=mysqli_fetch_assoc($res)) {
                        $id_menu = $row['id_menu'];
                        $title = $row['nama'];
                        $price = $row['harga'];
                        $description = $row['deskripsi'];
                        $image_name = $row['nama_gambar'];

                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                
                                    if($image_name==""){
                                        echo "<div class='grey'>No image.</div>";
                                    } else{
                                        ?>
                                        <img src="<?php echo HOMEURL; ?>images/food/<?php echo $image_name;?>" class="img-responsive img-curve">
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
                    echo "<div class='grey'>Food not found.</div>";
                }



            ?>


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php') ?>