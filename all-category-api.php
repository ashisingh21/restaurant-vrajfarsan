<?php 
include 'category_dbconnect.php';

header('Content-Type: application/json');

$query = "SELECT * FROM $categorydatabasename_table";
$data = mysqli_query($conn, $query);

$total = mysqli_num_rows($data);

if ($total != 0) {
    // Fetch all rows into an array
    $rows = mysqli_fetch_all($data, MYSQLI_ASSOC);

    // Convert the array to JSON
    $jsonResult = json_encode($rows);

    // Output the JSON
    echo $jsonResult;
} else {
    // Handle the case where there are no rows
    echo json_encode(['message' => 'No data found']);
}

?>