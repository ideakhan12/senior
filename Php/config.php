<?php
    $host = 'localhost';
    $user = 'root';
    $pw = 'bell123';
    $dbName = 'bell';

    $con=mysqli_connect($host, $user, $pw, $dbName);

    if($con->connect_errno)
    {
        printf("Connection failed: %s\n", $con->connect_error);
        die();
    }
?>