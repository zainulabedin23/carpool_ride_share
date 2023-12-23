<?php
include('connection.php');

// Get data from the POST request
$name = mysqli_real_escape_string($link, $_POST["name"]);
$phone = mysqli_real_escape_string($link, $_POST["phone"]);
$query = mysqli_real_escape_string($link, $_POST["query"]);

if (empty($name) || empty($phone) || empty($query)) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

$insert_sql = "INSERT INTO contact_form_data (`name`, `phone`, `query`) VALUES ('$name', '$phone', '$query')";

if (mysqli_query($link, $insert_sql)) {
    // Form data inserted successfully, send success response
    echo json_encode(["status" => "success"]);
} else {
    // Error occurred while inserting data, send failure response
    echo json_encode(["status" => "error", "message" => mysqli_error($link)]);
}

// Close database connection
mysqli_close($link);
?>
