<?php

    //Start Session
    session_start();

    //constants
    define('HOMEURL', 'http://localhost/lesto/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');  //default username: root
    define('DB_PASSWORD', '');      // default password: [blank]
    define('DB_NAME', 'lesto');

    //Execute Query
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); //connecting database, if fail, display error and stop process
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); //select database



?>