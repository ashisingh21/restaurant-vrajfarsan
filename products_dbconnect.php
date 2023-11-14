<?php 
include 'config.php';

    $servername = "localhost";
    $username = $productdatabasename_username;
    $password = $productdatabasename_password;
    $dbname = $productdatabasename;


    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);             

    } 

?>