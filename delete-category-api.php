<?php 
include 'category_dbconnect.php';

header('Content-Type: application/json');

 if ($_SERVER["REQUEST_METHOD"] === "DELETE"); { 
             
$data = json_decode(file_get_contents("php://input"));
             // Validate and retrieve the ID from the request data
    $id = isset($data->id) ? $data->id : null;


    if ($id !== null) {
        // Perform the DELETE operation
        $sql = "DELETE FROM $categorydatabasename_table WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            // Deletion successful
            http_response_code(200);
            echo json_encode(array("message" => "category deleted successfully."));
        } else {
            // Error during deletion
            http_response_code(500);
            echo json_encode(array("message" => "Error deleting category."));
        }  $stmt->close();
    } else {
        // ID not provided or invalid
        http_response_code(400);
        echo json_encode(array("message" => "Invalid or missing ID."));
    }
 }
?>