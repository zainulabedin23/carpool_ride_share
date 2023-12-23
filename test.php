<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include('connection.php'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
       
            
         
<?php
for ($x = 0; $x <= 10; $x++) {
    echo '<form method="post">';
    echo '<button type="submit" name="sendreq" value="Send Request" class="btn btn-success btn-lg sendreq">Hello</button>';
    echo '<br>';
    echo "</form>";
}


?>



            

</body>
</html>



<?php
if (isset($_POST['sendreq'])) {
    $driver_id = 1;
    $rider_id = 2;
    echo "above req";
    $request = "INSERT INTO riderequest(user_id, driver_id, status) VALUES ('$rider_id','$driver_id','pending')";
    $request_query = mysqli_query($link, $request);
    echo "bilo req";

    if ($request_query) {
        echo "Request was successful"; // Debugging output
        echo '<script>';
        echo 'alert("Registration successful")';
        echo '</script>';

    } else {
        echo "Request failed"; // Debugging output
        echo '<script>';
        echo 'alert("Request not sent")';
        echo '</script>';

    }
    
    header("Location: ");

}?>