<?php
// Start session and connect to the database
session_start();
include('connection.php');

// Define error messages
$errors = array();

// Get inputs and sanitize them
$departure = filter_input(INPUT_POST, "departure", FILTER_SANITIZE_STRING);
$destination = filter_input(INPUT_POST, "destination", FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$seatsavailable = filter_input(INPUT_POST, "seatsavailable", FILTER_SANITIZE_NUMBER_INT);
$regular = filter_input(INPUT_POST, "regular", FILTER_SANITIZE_STRING);
$date = filter_input(INPUT_POST, "date", FILTER_SANITIZE_STRING);
$time = filter_input(INPUT_POST, "time", FILTER_SANITIZE_STRING);
$monday = filter_input(INPUT_POST, "monday", FILTER_SANITIZE_STRING);
$tuesday = filter_input(INPUT_POST, "tuesday", FILTER_SANITIZE_STRING);
$wednesday = filter_input(INPUT_POST, "wednesday", FILTER_SANITIZE_STRING);
$thursday = filter_input(INPUT_POST, "thursday", FILTER_SANITIZE_STRING);
$friday = filter_input(INPUT_POST, "friday", FILTER_SANITIZE_STRING);
$saturday = filter_input(INPUT_POST, "saturday", FILTER_SANITIZE_STRING);
$sunday = filter_input(INPUT_POST, "sunday", FILTER_SANITIZE_STRING);

// Check departure
if (empty($departure)) {
    $errors[] = "Please enter your departure!";
}

// Check destination
if (empty($destination)) {
    $errors[] = "Please enter your destination!";
}

// Check Price
if (empty($price) || !is_numeric($price)) {
    $errors[] = "Please choose a valid price per seat using numbers only!";
}

// Check Seats Available
if (empty($seatsavailable) || !ctype_digit($seatsavailable)) {
    $errors[] = "The number of available seats should contain digits only!";
}

// Check regular
if (empty($regular)) {
    $errors[] = "Please select a frequency!";
} elseif ($regular == "Y") {
    if (empty($monday) && empty($tuesday) && empty($wednesday) && empty($thursday) && empty($friday) && empty($saturday) && empty($sunday)) {
        $errors[] = "Please select at least one weekday!";
    }
    if (empty($time)) {
        $errors[] = "Please choose a time for your trip!";
    }
} elseif ($regular == "N") {
    if (empty($date)) {
        $errors[] = "Please choose a date for your trip!";
    }
    if (empty($time)) {
        $errors[] = "Please choose a time for your trip!";
    }
}

// If there are errors, print error messages
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<div class='alert alert-danger'>$error</div>";
    }
} else {
    // No errors, prepare variables for the query
    $tbl_name = 'carsharetrips';
    $user_id = $_SESSION['user_id'];

    // Escape variables to prevent SQL injection
    $departure = mysqli_real_escape_string($link, $departure);
    $destination = mysqli_real_escape_string($link, $destination);
    $price = mysqli_real_escape_string($link, $price);
    $seatsavailable = mysqli_real_escape_string($link, $seatsavailable);
    $regular = mysqli_real_escape_string($link, $regular);

    // Prepare and execute the SQL query
    if ($regular == "Y") {
        $sql = "INSERT INTO $tbl_name (`user_id`,`departure`, `destination`, `price`, `seatsavailable`, `regular`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `time`) 
                VALUES ('$user_id', '$departure','$destination','$price','$seatsavailable','$regular','$monday','$tuesday','$wednesday','$thursday','$friday','$saturday','$sunday','$time')";
    } else {
        $sql = "INSERT INTO $tbl_name (`user_id`,`departure`, `destination`, `price`, `seatsavailable`, `regular`, `date`, `time`) 
                VALUES ('$user_id', '$departure','$destination','$price','$seatsavailable','$regular','$date','$time')";
    }

    $results = mysqli_query($link, $sql);

    // Check if the query was successful
    if (!$results) {
        echo '<div class="alert alert-danger">There was an error! The trip could not be added to the database!</div>';
    }else{
        echo '<script>window.location.href = window.location.href;</script>';

    }
}
?>
