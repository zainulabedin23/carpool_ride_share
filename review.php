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
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/sunny/jquery-ui.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
      <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqae-o5nTRe28k9M3BazQIPzkr9AQB3zw"></script>
        <script src="js/bootstrap.min.js"></script>


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
/* Form Container Styles */
.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 80px;
    
   
    
}

/* Heading Styles */
.form-heading {
    font-size: 24px;
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

/* Input Styles */
.form-control {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

/* Select Styles */
.form-control.select {
    height: 40px;
}

/* Textarea Styles */
.form-control.textarea {
    height: 150px;
    resize: vertical;
}

/* Button Styles */
.form-btn {
    background-color: #4caf50;
    color: #fff;
    border: none;
    padding: 12px 20px;
    font-size: 18px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.form-btn:hover {
    background-color: #45a049;
}

      </style>
</head>
<body>

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
                    <li><a href="help.html">Help</a></li>
                    <li><a href="contact.php">Contact us</a></li>
                    <li><a href="mainpageloggedin.php">My Trips</a></li>
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
      <form method="post" enctype="multipart/form-data" class="form-container">
    <h4 class="form-heading">Rate and Review</h4>
    
    
    
    <label for="rating">Rating</label>
    <select class="form-control select" name="rating" required>
        <option value="">Select Rating</option>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
    </select>
    
    <label for="new-review">Review</label>
    <textarea class="form-control textarea" cols="50" id="new-review" name="review" placeholder="Enter your review here..." rows="5"></textarea>
    
    <div class="text-right mt10">
        <button class="form-btn" type="submit" name="review_submit">Submit</button>
    </div>
</form>



</body>
</html>
<?php

    if (isset($_POST['review_submit'])) {
        //  echo '<script>alert("'.print_r($_POST).'")</script>';
        $user_name = $_POST['userName'];
        $rating = $_POST['rating'];
        $review = $_POST['review'];
        $added_on = date('Y-m-d H:i:s');
        $driver_id = $_GET['driver_id'];

        $user_id = $_SESSION['user_id']; // Get the user_id from the current session
        // echo '<script>alert("' .  $rating . '")</script>';
        

        $sql = "INSERT INTO review_table (driver_id, user_id, user_rating, user_review, added_on) VALUES ('$driver_id', '$user_id', '$rating', '$review', '$added_on')";
        $result=mysqli_query($link,$sql);
        if (!$result) {
            echo '<div class="alert alert-danger">Error: ' . mysqli_error($link) . '</div>';
        } else {
            echo '<script>alert("You have successfully submitted your review!")</script>';
            // header("location: rider_request.php");
            echo '<script>window.location.href = "rider_request.php";</script>';
        }
        


    }
?>
