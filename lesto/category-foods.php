<?php include('partials-front/menu.php');?>

<?php 
    //check if id is passed
    if(isset($_GET['id_category'])) {
        $id_category =$_GET['id_category'];

        $sql = "SELECT nama_kategori FROM kategori_menu WHERE id_kategori='$id_category'";
        // take only name

        $res = mysqli_query($conn, $sql);
        $row =mysqli_fetch_assoc($res);

        $title_category = $row['nama_kategori'];
    } else{
        header('location:'.HOMEURL); //validation
    }   
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $title_category;?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
            
                $sql2 = "SELECT * FROM menu WHERE id_kategori='$id_category'";

                $res2 = mysqli_query($conn, $sql2);
                $count2 = mysqli_num_rows($res2);

                if($count2>0) {
                    while($row2=mysqli_fetch_assoc($res2)) {
                        $id_menu = $row2['id_menu'];
                        $title = $row2['nama'];
                        $price = $row2['harga'];
                        $description = $row2['deskripsi'];
                        $image_name = $row2['nama_gambar'];

                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                if ($image_name==""){
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
                    echo "<div class='grey'>No food available</div>";
                }
            ?>

                        
            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php') ?>