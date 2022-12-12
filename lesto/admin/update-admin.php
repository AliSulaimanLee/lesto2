<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br/>

        <?php 
           include('partials/display-session.php');
        ?>

        <?php 
            //display selected admin data
            //get ID of selected admin
            
            if(isset($_GET['id_admin'])) {
                //get data
                $id_admin = $_GET['id_admin'];

                //create query
                $sql= "SELECT * FROM tabel_admin WHERE id_admin = $id_admin";

                $res = mysqli_query($conn, $sql);

                if($res==TRUE) {
                    
                    //check whether data is available
                    $count = mysqli_num_rows($res);

                    //chech whether it is a single admin data 
                    if($count==1) {
                        //get details
                        $row = mysqli_fetch_assoc($res);

                        $nama = $row['nama'];
                        $username = $row['username'];

                    } else{
                        //redirect
                        header('location:'.HOMEURL.'admin/manage-admin.php');
                    }
                }

            } else{
                //redirect 
                header('location:'.HOMEURL.'admin/manage-admin.php');
            }
            
            
            

        ?>

        <form action="" method="POST">
            <table class="tbl-30">
            <tr>
                <td>Full name: </td>
                <td>
                    <input type="text" name="nama" value="<?php echo $nama?>" placeholder="Enter name">
                </td>
            </tr>

            <tr>
                <td>Username: </td>
                <td>
                <input type="text" name="username" value="<?php echo $username?>" placeholder="Enter username">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="hidden" name="id_admin" value ="<?php echo $id_admin ?>">
                    <input type="submit" name="submit" value ="Update Admin" class="btn-secondary"> 
                </td>
            </tr>
            </table>
    </div>
</div>

<?php
    //check whether submit button is clicked
    if(isset($_POST['submit'])) {
        
        //get all values from from
        $id_admin = $_POST['id_admin'];
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        
        //query to update admin
        $sql = "UPDATE tabel_admin SET
        nama = '$nama',
        username = '$username'
        WHERE id_admin = '$id_admin'
        ";

        //execute query
        $res = mysqli_query($conn, $sql);

        if($res==TRUE) {//admin updated

            $_SESSION['update'] = "<div class='success'>Admin Updated.</div>";
            header('location:'.HOMEURL.'admin/manage-admin.php');

        } else{// failed to update
            $_SESSION['update'] = "<div class='error'>Failed to update Admin.</div>";
            header('location:'.HOMEURL.'admin/update-admin.php');
        }

        
    
        

    }
?>

<?php include('partials/footer.php'); ?>