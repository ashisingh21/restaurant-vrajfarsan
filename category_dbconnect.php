<?php 
include 'config.php';

    $servername = "localhost";
    $username = $categorydatabasename_username;
    $password = $categorydatabasename_password;
    $dbname = $categorydatabasename;


    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);             

    } 

?>