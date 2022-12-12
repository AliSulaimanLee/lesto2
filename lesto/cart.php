<?php include('partials-front/menu.php') ?>

<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Cart</h2>
        <hr>
        <?php 
        
            $id_menu_array = array_column($_SESSION['cart'], 'id_menu');
            //print_r($id_menu_array); //check array for bug fixing
            /*$sql2 = "INSERT INTO detail_pesan SET
            id_menu = '$values'";*/

            $total = (int)0; //initialization

            $sql = "SELECT * FROM menu"; //WHERE id_menu = '$id_menu'
            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);
            if($count>0) {
                while($row=mysqli_fetch_assoc($res)) {
                    foreach($id_menu_array as $id_menu) {
                        if($row['id_menu'] == $id_menu) { //to replace WHERE in sql
                            $id = $row['id_menu'];
                            $title = $row['nama'];
                            $description = $row['deskripsi'];
                            $price = $row['harga'];
                            $image_name = $row['nama_gambar'];
                            
                            $quantity= (int)0;
                            ?>
                                <div class="food-menu-box">
                                    <div class="food-menu-img">
                                        <?php 
                                            if($image_name=="") {
                                                echo "<div class='grey'>No Image</div>";
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
                                        <div>
                                            <form action="" method="POST">
                                            <!-- <button type="button" class="btn btn-primary">-</button> -->
                                            <input type="number" name ="quantity" value="<? echo $quantity;?>" step="1" class="input-responsive" style="width: 10%;">
                                            <input type="hidden" name= "price" value="<?php echo $price;?>">                                                                                     

                                                                                           
                                            <!-- <button type="button" class="btn btn-primary">+</button> NVM NEED JS-->
                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                            <a href="<?php echo HOMEURL;?>cart-remove.php?id_menu=<?php echo $id;?>" class="btn btn-primary">Remove</a>
                                            
                                            </form>                                         
                                        </div>
                                    </div>
                                </div>

                            <?php
                        if(isset($_POST['submit'])) {
                            $key = implode(",",array_keys($id_menu_array)); //array key as string
                            $values = implode(",",array_values($id_menu_array)); //value as string (id_menu)
                
                            //echo "tes";
                            //print_r($id_menu_array);
                            $price = $_POST['price'];
                            $quantity = $_POST['quantity'];
                            $subtotal = (int)$quantity * (int)$price;
                            $total = (int)$total + (int)$subtotal;
                
                            //NEW BUG, ALL ENTITY PRICES ARE UPDATED SIMULTANIOUSLY 
                            //header('location:'.HOMEURL."cart-update.php?id_menu=".$id."&quantity=".$quantity);
                        
                            
                            /*foreach($id_menu_array as $row => $value) {
                                $sql2 = "INSERT INTO detail_pesan SET
                                jumlah = '$quantity';
                                harga = '$price'
                                subtotal = '$subtotal';
                                
                                WHERE id_menu = '$values'";
                
                                $res2 = mysqli_query($conn, $sql2);
                                
                            } */
                        } //pindah sini?
                    
                
                           
                
                        }

                    }

                    
                 
                }
            } else{
                echo "<div class='grey'>Cart empty</div>";
            }
        
        

        ?>
            
    <br><br> 
            
    <div class="clearfix"></div>
    <br><br>

    <div>
            <h2 class="text-center">Price Details</h2>
            <hr>
            <div>
                <div colspan="6">
                    <?php 
                        if(isset($_SESSION['cart'])) {
                            $count2 = count($_SESSION['cart']);
                            echo "<h1>Price ($count2 items)</h1>";

                        } else{
                            echo "<h1>Price (0 items)</h1>";
                        }
                    ?>
                    <div colspan ="6">
                        <h3>Rp.<?php echo $total;?></h3>
                    </div>
                </div>

                <div colspan="6"></div>

            </div>
        </div>
</section>


<?php include('partials-front/footer.php') ?>

