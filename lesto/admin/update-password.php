<?php include('partials/menu.php')?>

<div class = "main-content"> 
    <div class = "wrapper">
        <h1>Change Password</h1>
        <br/>

        <?php //display session
        include('partials/display-session.php');
        ?>

        <?php
            if(isset($_GET['id_admin'])){
                $id_admin = $_GET['id_admin'];
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td> Current Password: </td>
                    <td>
                        <input type="password" name = "current_password" placeholder = "Enter password">

                    </td>
                </tr>

                <tr>
                    <td> New Password: </td>
                    <td>
                        <input type="password" name = "new_password" placeholder = "Enter password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name = "confirm_password" placeholder = "Enter Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id_admin" value="<?php echo $id_admin; ?>">
                        <input type="submit" name="submit" value="Change Password" class= "btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>        
</div>

<?php 
    
    //check whether submit is clicked
    if(isset($_POST['submit'])){
        
        // get data from Form
        $id_admin = $_POST['id_admin'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        // check whether user with current id and password exist
        $sql = "SELECT * FROM tabel_admin WHERE id_admin = '$id_admin' AND password='$current_password'";

        $res = mysqli_query($conn, $sql);

        if($res==TRUE) {
            $count =mysqli_num_rows($res);

            if($count==1) { //user exist and current password match

                //check whether new password and confirm password match
                if($new_password==$confirm_password) {

                    //update password  //no duplicate $sql type in a page
                    $sql2 = "UPDATE tabel_admin SET 
                    password = '$new_password'
                    WHERE id_admin = $id_admin
                    ";

                    $res2 = mysqli_query($conn, $sql2);

                    if($res2==TRUE) { 

                        $_SESSION['change-pwd'] = "<div class='success'>Password changed. </div>";
                        //redirect
                        header('location:'.HOMEURL.'admin/manage-admin.php');

                        

                    }else {
                        $_SESSION['change-pwd'] = "<div class='success'>Failed to change Password. </div>";
                        //refresh
                        header('location:'.HOMEURL.'admin/update-password.php?id_admin='.$id_admin);

                    }

                } 
                else {
                    //display error message
                    $_SESSION['pwd-not-match'] = "<div class='error'>Password does not match. </div>";
                    //refresh page
                    header('location:'.HOMEURL.'admin/update-password.php?id_admin='.$id_admin);
                }
            
            } 
            else { //user doesn't exist
                
                //redirect
                $_SESSION['user-not-found'] = "<div class='error'>User not found or Password is Wrong. </div>";
                header('location:'.HOMEURL.'admin/manage-admin.php');
            }
        }


        //change password if all above is true

    } else {

    }

?>
<?php include('partials/footer.php')?>