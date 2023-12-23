<?php
session_start();
include('connection.php');

?>


    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car Sharing </title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="styling.css">
      <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/sunny/jquery-ui.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
      <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqae-o5nTRe28k9M3BazQIPzkr9AQB3zw"></script>
      <style>



.container {
    text-align: left;
    background-color: #fff;
    padding: 20px;
    position: absolute;
    top: 100px;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
}





.notification {
    color: black;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.notification-text {
    flex-grow: 1;
}

.accept-button, .delete-button {
    background-color: #004658;
    color: #fff;
    border: none;
    padding: 5px 15px;
    border-radius: 20px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

.accept-button:hover {
    background-color: #0056b3;
}

.delete-button:hover {
    background-color: #ff6b6b;
}

/* Add a horizontal line between notifications */
.notification + .notification {
    border-top: 1px solid #ccc;
    margin-top: 10px;
}

       
</style>
<body>
<?php
    if(isset($_SESSION["user_id"])){
        include("navigationbarconnected.php");
    }else{
        include("navigationbarnotconnected.php");
    }  
    ?>
    
<div class="container">
        <div id="notificationContainer">
            <?php
            
            $driver_id = $_SESSION['user_id'];
            $requests = "SELECT * FROM `riderequest` WHERE driver_id='$driver_id'";
            $result = mysqli_query($link, $requests);

            $index=0;
            while( $row = mysqli_fetch_array($result))
            {
                
                $request_id = $row['request_id'];
                $passenger_id = $row['user_id'];
                $status = $row['status'];
                
                $name_query="SELECT `user_id`, `first_name`, `last_name` FROM `users` WHERE user_id='$passenger_id'";
                $name_result = mysqli_query($link, $name_query);
                $name_result = mysqli_fetch_array($name_result);
                $notifications = [
                    $name_result['first_name']." ".$name_result['last_name']." has requested to join your trip."
                ];
                if($status=='pending')
                {
                    echo '<div class="notification">';
                    echo '<span class="notification-text">' . $notifications[0] . '</span>';
                    echo '<button onclick="acceptNotification(' . $index . ', ' . $request_id . ')" class="accept-button">Accept</button>';
                    echo '<button onclick="deleteNotification(' . $index . ', ' . $request_id . ')" class="delete-button">Delete</button>';
                    echo '</div>';

                }
                else if($status=='accepted')
                {
                    echo '<div class="notification">';
                    echo '<span class="notification-text">' . $notifications[0] . '</span>';
                    echo '<button class="accept-button">'.ucwords($status).'</button>';
                    echo '</div>';
                }

                $index =$index+1;

            }


            ?>
        </div>
    </div>


    <script>
        function acceptNotification(index,request_id) {
 
            const notificationDiv = document.querySelectorAll('.notification')[index];
            const acpt_btn = document.querySelectorAll(".accept-button")[index];
            const del_btn = document.querySelectorAll(".delete-button")[index];
            acpt_btn.innerHTML = "Accepted";
            del_btn.style.display = "none";
            $.post(`request_query.php?action=RequestSection&request_id=${request_id}`, function(res){
                alert(res)
                
            })
     


            
        }

        function deleteNotification(index,request_id) {
            // Implement your logic to delete the notification
            // For now, we'll just hide the notification on the client-side
            const notificationDiv = document.querySelectorAll('.notification')[index];
            notificationDiv.style.display = 'none';

            $.post(`request_query.php?action=deleteRequest&request_id=${request_id}`, function(res){
                alert(res)
                
            })
        }
    </script>
</body>
</html>
