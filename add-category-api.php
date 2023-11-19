<?php 
include 'category_dbconnect.php';

header('Content-Type: application/json');

 if ($_SERVER["REQUEST_METHOD"] === "POST" ); { 
             

            // Product data
            $name = $_POST['name'];
       
           

            $sql = "INSERT INTO $categorydatabasename_table (name) VALUES (?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $name);
            $stmt->execute();

            $stmt->close();
            $conn->close();
           

            
            $json =  json_encode(['success' => 'success']);
           echo $json;
 }
?>