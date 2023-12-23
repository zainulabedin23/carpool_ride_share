<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}
include('connection.php');

$user_id = $_SESSION['user_id'];

//get username and email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
    $username = $row['username'];
    $email = $row['email']; 
    $picture = $row['profilepicture'];
}else{
    echo "There was an error retrieving the username and email from the database";   
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="styling.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
      <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="styling.css">
      <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/sunny/jquery-ui.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
      <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqae-o5nTRe28k9M3BazQIPzkr9AQB3zw"></script>
      <style>
        #container{
            margin-top:100px;   
        }

        #notePad, #allNotes, #done{
            display: none;   
        }

        .buttons{
            margin-bottom: 20px;   
        }

        textarea{
            width: 100%;
            max-width: 100%;
            font-size: 16px;
            line-height: 1.5em;
            border-left-width: 20px;
            border-color: #CA3DD9;
            color: #CA3DD9;
            background-color: #FBEFFF;
            padding: 10px;
              
        }
          
          tr{
             cursor: pointer;    
          }
          #previewing{
              max-width: 100%;
              height: auto;
              border-radius: 50%;
          }
          .previewing2{
              margin: auto;
              height: 20px;
              border-radius: 50%;
          }
          #spinner{
              display: none;
              position: fixed;
              top: 0;
              left: 0;
              bottom: 0;
              right: 0;
              height: 85px;
              text-align: center;
              margin: auto;
              z-index: 1100;
          }
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
  </head>
  <body>
    <!--Navigation Bar-->  
      <nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
      
          <div class="container-fluid">
            
              <div class="navbar-header">
              
                  <a class="navbar-brand">Car Sharing</a>
                  <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  
                  </button>
              </div>
              <div class="navbar-collapse collapse" id="navbarCollapse">
                  <ul class="nav navbar-nav">
                    <li><a href="index.php">Search</a></li>  
                    <li ><a href="profile.php">Profile</a></li>
                    <li><a href="privacy_policy.html">Help</a></li>
                    <li><a href="contact.php">Contact us</a></li>
                    <li><a href="mainpageloggedin.php">My Trips</a></li>
                    <li><a href="notification.php">Request Received</a></li>
                    <li class="active"><a href="notification.php">Request sent</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="#">
                            <?php
                                if(empty($picture)){
                                    echo "<div class='image_preview'  data-target='#updatepicture' data-toggle='modal'><img class='previewing2' src='profilepicture/noimage.jpg' /></div>";
                                }else{
                                    echo "<div class='image_preview' data-target='#updatepicture' data-toggle='modal'><img class='previewing2' src='$picture' /></div>";
                                }

                              ?>
                          </a>
                      </li>
                      <li><a href="#"><b><?php echo $username; ?></b></a></li>
                    <li><a href="index.php?logout=1">Log out</a></li>
                  </ul>
              
              </div>
          </div>
      
      </nav>
      <div class="container">
        <div id="notificationContainer">
            <?php
            
            $rider_id = $_SESSION['user_id'];
            $requests = "SELECT * FROM `riderequest` WHERE user_id='$rider_id'";
            $result = mysqli_query($link, $requests);
            $index=0;
            while( $row = mysqli_fetch_array($result))
            {
                
                $request_id = $row['request_id'];
                $driver_id = $row['driver_id'];
                $trip_id = $row['trip_id'];
                $status = $row['status'];

                $name_query="SELECT `user_id`, `first_name`, `last_name` FROM `users` WHERE user_id='$driver_id'";
                $name_result = mysqli_query($link, $name_query);
                $name_result = mysqli_fetch_array($name_result);

                $trip_query="SELECT `trip_id`, `departure`,`destination`, `date` FROM `carsharetrips` WHERE trip_id='$trip_id'";
                $trip_result = mysqli_query($link, $trip_query);
                $trip_result=mysqli_fetch_array($trip_result);
                $notifications = [
                    "You have sent a request to ".$name_result['first_name']." ".$name_result['last_name']." to join his trip From ".$trip_result['departure']." to ".$trip_result['destination']." on ".$trip_result['date']
                   
                ];


                $status=$row['status'];

                echo '<div class="notification">';
                echo '<span class="notification-text">' . $notifications[0] . '</span>';
                // echo '<button onclick="acceptNotification(' . $index . ', ' . $request_id . ')" class="accept-button">'.$status.'</button>';
                echo '<button class="accept-button">'.ucwords($status).'</button>';  
                if($status != 'accepted')
                {                
                    echo '<button onclick="per_delete_Notification(' . $index . ', ' . $request_id . ')" class="delete-button">Delete</button>';
                }
                if($status =='accepted')
                {
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    // echo '<button onclick="rating(' . $index . ', ' . $driver_id . ')" class="delete-button">Rate</button>';
                    echo '<a href="review.php?driver_id=' . $driver_id . '" class="delete-button">Rate</a>';}

                echo '</div>';
                
                $index =$index+1;

            }
            ?>
        </div>
    </div>

    <script>


        function per_delete_Notification(index,request_id) 
        {

            const notificationDiv = document.querySelectorAll('.notification')[index];
            notificationDiv.style.display = 'none';

            $.post(`request_query.php?action=perdeleteRequest&request_id=${request_id}`, function(res){
                alert(res)
                
            })
        }
    </script>

</body>
</html>