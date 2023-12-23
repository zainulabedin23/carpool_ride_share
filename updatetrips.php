<?php
// Start session and connect
session_start();
include('connection.php');

// Define error messages
$errors = ""; // Initialize the $errors variable
$missingdeparture = '<p><strong>Please enter your departure!</strong></p>';
$invaliddeparture = '<p><strong>Please enter a valid departure!</strong></p>';
$missingdestination = '<p><strong>Please enter your destination!</strong></p>';
$invaliddestination = '<p><strong>Please enter a valid destination!</strong></p>';
$missingprice = '<p><strong>Please choose a price per seat!</strong></p>';
$invalidprice = '<p><strong>Please choose a valid price per seat using numbers only!!</strong></p>';
$missingseatsavailable = '<p><strong>Please select the number of available seats!</strong></p>';
$invalidseatsavailable = '<p><strong>The number of available seats should contain digits only!</strong></p>';
$missingfrequency = '<p><strong>Please select a frequency!</strong></p>';
$missingdays = '<p><strong>Please select at least one weekday!</strong></p>';
$missingdate = '<p><strong>Please choose a date for your trip!</strong></p>';
$missingtime = '<p><strong>Please choose a time for your trip!</strong></p>';

// Get inputs:
$trip_id = $_POST["trip_id"];
$departure = $_POST["departure2"];
$destination = $_POST["destination2"];
$price = $_POST["price2"];
$seatsavailable = $_POST["seatsavailable2"];
$regular = $_POST["regular2"];
$date = $_POST["date2"];
$time = $_POST["time2"];
$monday = isset($_POST["monday2"]) ? $_POST["monday2"] : 0; // Check if the checkbox is not set, default to 0
$tuesday = isset($_POST["tuesday2"]) ? $_POST["tuesday2"] : 0;
$wednesday = isset($_POST["wednesday2"]) ? $_POST["wednesday2"] : 0;
$thursday = isset($_POST["thursday2"]) ? $_POST["thursday2"] : 0;
$friday = isset($_POST["friday2"]) ? $_POST["friday2"] : 0;
$saturday = isset($_POST["saturday2"]) ? $_POST["saturday2"] : 0;
$sunday = isset($_POST["sunday2"]) ? $_POST["sunday2"] : 0;

// Check departure:
if (!$departure) {
    $errors .= $missingdeparture;
} else {
    $departure = filter_var($departure, FILTER_SANITIZE_STRING);
}

// Check destination:
if (!$destination) {
    $errors .= $missingdestination;
} else {
    $destination = filter_var($destination, FILTER_SANITIZE_STRING);
}

// Check Price
if (!$price) {
    $errors .= $missingprice;
} elseif (!ctype_digit($price)) {
    $errors .= $invalidprice;
} else {
    $price = filter_var($price, FILTER_SANITIZE_STRING);
}

// Check Seats Available
if (!$seatsavailable) {
    $errors .= $missingseatsavailable;
} elseif (!ctype_digit($seatsavailable)) {
    $errors .= $invalidseatsavailable;
} else {
    $seatsavailable = filter_var($seatsavailable, FILTER_SANITIZE_STRING);
}

// Check regular
if (!$regular) {
    $errors .= $missingfrequency;
} elseif ($regular == "Y") {
    if (!$monday && !$tuesday && !$wednesday && !$thursday && !$friday && !$saturday && !$sunday) {
        $errors .= $missingdays;
    }
    if (!$time) {
        $errors .= $missingtime;
    }
} elseif ($regular == "N") {
    if (!$date) {
        $errors .= $missingdate;
    }
    if (!$time) {
        $errors .= $missingtime;
    }
}

// If there are errors, print error message
if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>$errors</div>";
    echo $resultMessage;
} else {
    // No errors, prepare variables for the query
    $tbl_name = 'carsharetrips';
    $departure = mysqli_real_escape_string($link, $departure);
    $destination = mysqli_real_escape_string($link, $destination);
    if ($regular == "Y") {
        // Query for a regular trip
        $sql = "UPDATE $tbl_name SET `departure`= '$departure', `destination`='$destination', `price`='$price', `seats_available`='$seatsavailable', `regular`='$regular', `monday`='$monday', `tuesday`='$tuesday', `wednesday`='$wednesday', `thursday`='$thursday', `friday`='$friday', `saturday`='$saturday', `sunday`='$sunday', `time`='$time' WHERE `trip_id`='$trip_id' LIMIT 1";
    } else {
        // Query for a one-off trip
        $sql = "UPDATE $tbl_name SET `departure`= '$departure', `destination`='$destination', `price`='$price', `seats_available`='$seatsavailable', `regular`='$regular', `date`='$date', `time`='$time'  WHERE `trip_id`='$trip_id'";
    }
    $results = mysqli_query($link, $sql);
    // Check if the query is successful
    if (!$results) {
        echo '<div class="alert alert-danger">There was an error! The trip could not be updated!</div>';
    }else{
        echo "success";
    }
}
?>
