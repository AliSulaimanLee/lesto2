<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br/>

        <?php 
            include('partials/display-session.php');
         ?>

        <br/>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="nama" placeholder="Enter name"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Enter username"></td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Enter password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>


            </table>

        </form>


    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php 
    
    // process the value from Form and save to database
    
    //Check whether the submit button is clicked
    if(isset($_POST['submit'])) {
        // Button clicked

        //Get data from Form
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //Encryption with MD5

        //SQL QUERY to save data to database
        $sql = "INSERT INTO tabel_admin SET
            nama = '$nama',
            username ='$username',
            password='$password'
        ";

    
        //Executing Query
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn)); 
        
        //Check whether query is executed 
        if($res==TRUE){//Data inserted

            //Create session variable to display message
            $_SESSION['add'] = "<div class='success'>Admin Added. </div>";

            //redirect page
            header("location:".HOMEURL.'admin/manage-admin.php');


        }else { //Failed to insert data

            //Create session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to add Admin. </div>";

            //redirect page
            header("location:".HOMEURL.'admin/add-admin.php');
           
        }



        
    } 

?>