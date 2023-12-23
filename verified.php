<?php


session_start();
include('connection.php');
// Check if the user is logged in (You should have a login mechanism in place)
if (!isset($_SESSION['user_id'])) {
    // Redirect to a login page or display an error message
    echo "You are not logged in. Please log in to continue.";
    exit;
}

// Include the database connection file


// Get data from the POST request
if(isset($_POST['verify']))
{
    $license_number = $_POST['license_number'];
    $car_number = $_POST['car_number'];
    $car_model = $_POST['car_model'];
    $user_id = $_SESSION['user_id']; // Get the user_id from the current session


    if (empty($license_number)) {
        echo "License Number is required.";
        exit;
    }

    if (empty($car_number)) {
        echo "Car Number is required.";
        exit;
    }

    if (empty($car_model)) {
        echo "Car Model is required.";
        exit;
    }
    //license image
    $license = $_FILES['license'];
    $filename=$license['name'];
    $filepath=$license['tmp_name'];
    $fileerror=$license['error'];

    $rating=0;
    if($fileerror==0)
    {
        $destfile='uploads/'.$filename;
        move_uploaded_file($filepath,$destfile);
        $sql = "INSERT INTO driver (driver_id, license_no,rating, verified,license_img) VALUES ('$user_id', '$license_number', $rating, 'not verified' ,'$destfile')";
        $result=mysqli_query($link,$sql);

    }
    else
    {
        echo '<div class="alert alert-danger">Error: ' . mysqli_error($link) . '</div>';
    }



    // Insert data into the "driver" table
    // $sql = "INSERT INTO driver (driver_id, license_no,rating, verified,license_img) VALUES ('$user_id', '$license_number', $rating, 'verified' ,'null')";
    // $result=mysqli_query($link,$sql);

    // Insert data into the "car" table


    if (!$result) {
        echo '<div class="alert alert-danger">Error: ' . mysqli_error($link) . '</div>';
    } else {

        $sql = "INSERT INTO car (driver_id, car_no, car_model) VALUES ('$user_id', '$car_number', '$car_model')";
        $result2=mysqli_query($link,$sql);

        // echo '<div class="alert alert-success">You have successfully verified!</div>';
?>
        <script>
            alert("You have successfully verified!");
            window.location.href = "mainpageloggedin.php";
        </script>
<?php
        // header("Location: mainpageloggedin.php");
        // echo $car_model;
    }

    
}



?>