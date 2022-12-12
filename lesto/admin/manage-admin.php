<?php include('partials/menu.php'); ?>
        
        <!-- Main Section Starts -->
        <div class="main-content">
            <div class="wrapper">
            <h1>Manage Admin</h1>

            <br/><br/>

            <?php include('partials/display-session.php');  //Session section ?>

            <br/><br/><br/>

            <!-- Button to add Admin -->
            <a href="add-admin.php" class="btn-primary">Add Admin</a>
                
            <br/><br/>
            
            <table class="tbl-full">
                    <tr>
                        <th>ID</th>
                        <th>Full Name </th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php 
                        //get table admin
                        $sql = "SELECT * FROM tabel_admin"; 

                        //execute query and check for error
                        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                        //check whether query is executed
                        if($res==TRUE) {
                            //count rows to check whether data is available
                            $count = mysqli_num_rows($res); //get rows from database

                            //create temp id to resign new id if data is deleted. 
                            //$temp_id=1;   

                            if($count > 0){ //data available
                                while($rows = mysqli_fetch_assoc($res)) { //while data exist
                                    //get individual data
                                    $id_admin = $rows['id_admin'];
                                    $nama = $rows['nama'];
                                    $username = $rows['username'];
                                    
                                    //display values in a table
                                    ?>
                                      <tr>
                                        <!--<td><//?php echo $temp_id++; ?></td>-->   <!--continuation of temp id (NOT USING)--> 
                                        <td><?php echo $id_admin; ?></td> 
                                        <td><?php echo $nama; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td>
                                            <a href="<?php echo HOMEURL;?>admin/update-admin.php?id_admin=<?php echo $id_admin;?>" class="btn-secondary">Update</a>
                                            <a href="<?php echo HOMEURL;?>admin/delete-admin.php?id_admin=<?php echo $id_admin;?>" class="btn-danger">Delete</a>
                                            <a href="<?php echo HOMEURL;?>admin/update-password.php?id_admin=<?php echo $id_admin;?>" class="btn-primary">Change Password</a>
                                        </td>
                                    </tr>  
                                    <?php
                                }
                            } else { //data not available
                                echo 'query failed';
                            }


                        }


                    ?>

            </table>
            </div>
        </div>
        <!-- Main Section Ends -->

<?php include('partials/footer.php')?>
