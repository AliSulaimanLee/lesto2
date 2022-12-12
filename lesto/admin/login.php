<?php include('../config/constants.php')?>

<html>
    <head>
        <title>Login - Lesto</title>
        <link rel="stylesheet" href ="../css/admin.css">
    </head>

    <body>
    <div class="login">
        
        <h1 class= "text-center">Login</h1>
        <br/>

        <!-- Login form starts here -->
        <form action ="" method = "POST" class="text-center">
            Username: <br/>
            <input type="text" name="username" placeholder="Enter Username"> <br/><br/>
           
            Password: <br/>
            <input type="password" name ="password" placeholder="Enter Password"> <br/><br/>

            <input type="submit" name="submit" value="Login" class="btn-primary">
        </form>
        <!-- Login form ends here -->
        <br/>

        <?php include('partials/display-session.php'); //session section
        
        if(isset($_SESSION['not-login-msg'])){
            echo $_SESSION['not-login-msg'];
            unset($_SESSION['not-login-msg']);
        }
        ?>
        
        <br/>
        <p class= "text-center">Created by - <a href = "https://linktr.ee/apayaa2nd">Ali Sulaiman</a></p>
    </div>    

    </body>
</html>

<?php 

    //check whether submit button is clicked
    if(isset($_POST['submit'])) {
        // Process for login
        //get data from Form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //check whether username exist and password match
        $sql = "SELECT * FROM tabel_admin 
        WHERE username = '$username' 
        AND password ='$password'
        ";

        $res = mysqli_query($conn, $sql);

        // check whether user exist
        $count = mysqli_num_rows($res);

        if($count==1) {
            //User available and login successful
            $_SESSION['login'] = "<div class = 'success'>Login Successful.</div>";

            $_SESSION['user'] = $username; //periodically check whether user is logged in
            //redirect
            header('location:'.HOMEURL.'admin/');



        } else{
            $_SESSION['login'] = "<div class = 'error text-center'>Wrong Username or Password.</div>";

            header('location:'.HOMEURL.'admin/login.php');
            //User not available
        }

    }
?>