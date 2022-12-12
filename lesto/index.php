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

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
                //sql query to display categories from db
                $sql = "SELECT * FROM kategori_menu WHERE active='Yes' AND featured='Yes'";
                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);
                if($count>0) {
                    while($row=mysqli_fetch_assoc($res)) {
                        $id_category = $row['id_kategori'];
                        $title_category = $row['nama_kategori'];
                        $image_name_category = $row['nama_gambar'];

                        ?> 
                            <a href="<?php echo HOMEURL;?>category-foods.php?id_category=<?php echo $id_category;?>">
                                <div class="box-3 float-container">
                                    <?php 
                                        if($image_name_category==""){ //if image unavailable
                                           echo "<div class='grey'>No Image</div>";
                                        } else{ //display image
                                            ?>
                                                <img src="<?php echo HOMEURL;?>images/category/<?php echo $image_name_category;?>" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                                    

                                    <h3 class="float-text text-white text-border"><?php echo $title_category;?></h3>
                                </div>
                            </a>
                        
                        <?php
                    }

                } else{
                    echo "<div class='grey'>No category available.</div>";
                }
            ?>


            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD Menu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
            
                //get food from db that are active and featured
                $sql2 = "SELECT * FROM menu WHERE active='Yes' AND featured='Yes'";
                $res2 = mysqli_query($conn, $sql2);

                $count2 = mysqli_num_rows($res2);

                if($count2>0) {
                    while($row2=mysqli_fetch_assoc($res2)) {
                        $id_menu = $row2['id_menu'];
                        $title_menu = $row2['nama'];
                        $description_menu = $row2['deskripsi'];
                        $price_menu = $row2['harga'];
                        $image_name_menu =$row2['nama_gambar'];

                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">

                                <?php
                                    if($image_name_menu=="") {
                                        echo "<div class='grey'>No image</div>";
                                        

                                    } else{
                                        
                                        ?>
                                        <img src="<?php echo HOMEURL;?>images/food/<?php echo $image_name_menu;?>" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>

                                
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title_menu;?></h4>
                                <p class="food-price">Rp.<?php echo $price_menu; ?></p>
                                <p class="food-detail">
                                    <?php echo $description_menu;?>
                                </p>
                                <br>
                                
                                <form method="POST">
                                    <input type="hidden" name="id_menu" value="<?php echo $id_menu;?>">
                                    <input type="submit" name="add" class="btn btn-primary" value="Add to Cart">
                                    
                                </form>
                                <!-- <!a href="order.php" class="btn btn-primary">Order Now</a> -->
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

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
        
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php') ?>

<?php 
    if(isset($_POST['add'])) {
        //print_r($_POST['id_menu']); //check id
        if(isset($_SESSION['cart'])) {

            $item_array_id = array_column($_SESSION['cart'],"id_menu"); //return array of id
            //print_r($item_array_id);

            if(in_array($_POST['id_menu'], $item_array_id)) {
                echo "<script>alert('Item has already been selected.')</script>";
                echo "<script>window.location = 'index.php'</script>";
            } else{
                $count3 = count($_SESSION['cart']); //return number of elements in array of session
                $item_array = array(
                    'id_menu' => $_POST['id_menu']
                );

                $_SESSION['cart'][$count3] = $item_array;
                print_r($_SESSION['cart']);

            }
            
        } else{
            $item_array = array(
                'id_menu' => $_POST['id_menu']
            );

            //create new session variable
            $_SESSION['cart'][0] = $item_array;
            print_r($_SESSION['cart']);
        }

    }

?>