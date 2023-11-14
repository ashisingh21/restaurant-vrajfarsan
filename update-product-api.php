    <?php 
    include 'products_dbconnect.php';

    header('Content-Type: application/json');

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
                  $per = $_POST['per']; 
            $type = $_POST['type'];

            // Handle photo update only if a new photo is provided
            if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
                $file_name = $_FILES['photo']['name'];
                $file_type = $_FILES['photo']['type'];
                $file_tmp = $_FILES['photo']['tmp_name'];
                $file_size = $_FILES['photo']['size'];
                move_uploaded_file($file_tmp, 'img/product-photos/' . $file_name);
        

            // Update the product data in the database
            $sql = "UPDATE $productdatabasename_table SET name=?, description=?, price=?, per=?, type=?, photo=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $name, $description, $price, $per, $type, $file_name, $id);



            } else {
            // Update the product data in the database without modifying the existing photo
            $sql = "UPDATE $productdatabasename_table SET name=?, description=?, price=?, per=?, type=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $name, $description, $price, $per, $type, $id);
        }
            $stmt->execute();
            $stmt->close();
            $conn->close();

             http_response_code(200);
            echo json_encode(array("message" => "Product updated successfully."));
          
        
        } else {
            $json = json_encode(['error' => 'Invalid request']);
            echo $json;
        }

    ?>