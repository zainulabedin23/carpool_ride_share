<?php
$user_id = $_SESSION['user_id'];

//get username and email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
    $username = $row['username'];
    $picture = $row['profilepicture'];
}else{
    echo "There was an error retrieving the username and email from the database";   
}
?>

<nav role="navigation" class="navbar navbar-custom navbar-fixed-top">

   <div class="container-fluid">

      <div class="navbar-header">

          <a class="navbar-brand">Ride-Share</a>
          <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>

          </button>
      </div>
      <div class="navbar-collapse collapse" id="navbarCollapse">
          <ul class="nav navbar-nav">
              <li class="active"><a href="index.php">Search</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="privacy_policy.html">Help</a></li>
            <li><a href="contact.php">Contact us</a></li>
            <li><a href="mainpageloggedin.php">My Trips</a></li>
            <li><a href="notification.php">Request Received</a></li>
            <li><a href="rider_request.php">Request sent</a></li>

          </ul>
          <ul class="nav navbar-nav navbar-right">
                <!-- <li><a href="#">
                <?php
                                if(empty($picture)){
                                    echo "<div class='image_preview'  data-target='#updatepicture' data-toggle='modal'><img class='previewing2' src='profilepicture/noimage.jpg' /></div>";
                                }else{
                                    echo "<div class='image_preview' data-target='#updatepicture' data-toggle='modal'><img class='previewing2' src='$picture' /></div>";
                                }

                              ?>
                  </a>
                </li> -->
              <li><a href="#"><b><?php echo $username?></b></a></li>
            <li><a href="index.php?logout=1">Log out</a></li>
          </ul>

      </div>
  </div>

</nav>