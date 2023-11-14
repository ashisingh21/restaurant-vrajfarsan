<?php 
include 'products_dbconnect.php';

header('Content-Type: application/json');

 if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['photo']) ); { 
             

            // Product data
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price']; 
             $per = $_POST['per']; 
              $type = $_POST['type']; 
           


            // photo save in server
            $file_name = $_FILES['photo']['name'];
            $file_type = $_FILES['photo']['type'];
            $file_tmp = $_FILES['photo']['tmp_name'];
            $file_size = $_FILES['photo']['size'];
            move_uploaded_file($file_tmp,'img/product-photos/'.$file_name);
            
            $sql = "INSERT INTO $productdatabasename_table (name, description,  price ,per,type, photo) VALUES (?,?,?, ?, ?,?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $name, $description, $price,$per,$type, $file_name);
            $stmt->execute();

            $stmt->close();
            $conn->close();
           

            
            $json =  json_encode(['success' => 'success']);
           echo $json;
 }
?>