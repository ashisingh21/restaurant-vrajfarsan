    <?php 
    include 'category_dbconnect.php';

    header('Content-Type: application/json');

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST['id'];
            $name = $_POST['name'];
           

          
            $sql = "UPDATE $categorydatabasename_table SET name=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $name, $id);



          
            $stmt->execute();
            $stmt->close();
            $conn->close();

             http_response_code(200);
            echo json_encode(array("message" => "category updated successfully."));
          
        
        } else {
            $json = json_encode(['error' => 'Invalid request']);
            echo $json;
        }

    ?>