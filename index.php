<?php
session_start();
include('connection.php');

//logout
include('logout.php');

//remember me
include('remember.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car Sharing Website Final</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="styling.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
      <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqae-o5nTRe28k9M3BazQIPzkr9AQB3zw"></script>
      <style>
          /*margin top for myContainer*/
          #myContainer {
              
              text-align: center;
              color: black;
          }
          
          /*header size*/
          #myContainer h1{
              font-size: 4em;
              color:white;
              padding:40px;
          }
          
          .bold{
              font-weight: bold;
          }
       
          .signup{
              margin-top: 20px;
          }
        
          #results{
            margin-bottom: 100px;   
          }
          .driver{
            font-size:1.5em;
            text-transform:capitalize;
            text-align: center;
          }
          .price{
            font: size 1.2em;
          }
          .departure, .destination{
            font-size:1.5em;
          }
          .perseat{
            font-size:0.5em;
          }
          .journey{
            text-align:left; 
          }
          .journey2{
            text-align:right; 
          }
          .time{
            margin-top:10px;  
          }
          .telephone{
            margin-top:10px;
          }
          .seatsavailable{
            font-size:0.7em; 
            margin-top:5px;
          }
          .moreinfo{
            text-align:left; 
          }
          .aboutme{
            border-top:1px solid grey;
            margin-top:15px;
            padding-top:5px;
          }
          #message{
            margin-top:20px;
          }
          .journeysummary{
            text-align:left; 
            font-size:1.5em;
          }
          .noresults{
            text-align:center;  
            font-size:1.5em;
          }
          
          .previewing{
              max-width: 100%;
              height: auto;
              border-radius: 50%;
          }
          .previewing2{
              margin: auto;
              height: 20px;
              border-radius: 50%;
          }
          .header {
  background: url('m1.jpg') no-repeat center center;
background-attachment: fixed;
background-size: cover;
  padding: 20px;
  text-align: center;
 
}
          .container {
  display: flex;
  justify-content: space-between; /* Distribute space equally between the child elements */
  padding-bottom: 10px;
  color:#2e5266ff;
  padding-top: 40px;
  padding-bottom:40px;
}

.box {
  flex: 1; /* Grow to take available space equally */
  padding: 20px;
  
}
h6{
  font-size: 28px;
  font-weight: 400px;
}
.about1{
  padding-bottom:20px;
}
.container1 {
            display: flex;
            align-items: center;
            height: 60vh;
            background-color:#004658;
           
        }

        .image-div {
            flex: 1;
            padding: 20px;
        }
        .container1 h5{
          font-size: 40px;
  font-weight:800px;
  color: white;
        }
        .text-div {
            flex: 1;
            padding: 20px;
        }
        .container1 p{
            color:white;}
        img {
            max-width: 100%;
            height: auto;
            display: block;
        }
  .container2 {
            display: flex;
            align-items: center;
            height: 60vh;
           
        }

        .image-div {
            flex: 1;
            padding: 100px;
        }

        .text-div {
            flex: 1;
            padding: 20px;
        }
        .container2 p{
            color:black;
          }
        img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        .container2 h5{
          font-size: 40px;
  font-weight:800px;
  color: black;
        }
        .container1 .signup-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ffff;
            color: #004658; 
            text-decoration: none;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .container1 .signup-button:hover {
            background-color: #ffff; 
            color:#007bff;
        }

        .container2 .signup-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #004658;
            color: #ffff; 
            text-decoration: none;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .signup-button:hover {
            background-color: #004659; 
            color:white;
        }
        .about2{
          height:60vh;
          padding-bottom:200px;
        }
          /*footer*/
          .pg-footer {
  font-family: 'Roboto', sans-serif;
}



.header p{
  color:white;
}

footer {
            background-color: #004658;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
  

      
      </style>
  </head>
  <body>
    <!--Navigation Bar-->  
    <?php
    if(isset($_SESSION["user_id"])){
        include("navigationbarconnected.php");
    }else{
        include("navigationbarnotconnected.php");
    }  
    ?>
    
    <div class="container-fluid" id="myContainer">
          <div class="row">
              <div class="header">
                  <h1>Your pick of rides at low prices</h1>
                  
                  <p class="bold">
                  </p>
                  <!--Search Form-->
                  <form class="form-inline" method="get" id="searchform" >
                      <div class="form-group">
                          <label class="sr-only" for="departure">Departure:</label>
                          <input type="text" class="form-control" id="departure" placeholder="Departure" name="departure">
                      </div>
                      <div class="form-group">
                          <label class="sr-only"></label>
                          <input type="text" class="form-control" id="destination" placeholder="Destination" name="destination">
                      </div>
                      <input type="submit" value="Search" class="btn btn-lg green" name="search">
                      
                  
                  </form>
                  <!--Search Form End-->
                  
                  <!--Google Map-->
                  
                  <!--Sign up button-->
                  <?php
                  if(!isset($_SESSION["user_id"])){
                      echo '<button type="button" class="btn btn-lg green signup" data-toggle="modal" data-target="#signupModal">Sign up</button>';
                  }
                  ?>
                  <div id="results">
                    <!--will be filled with Ajax Call-->
                  </div>
              
              </div>
          
          </div>
      
      </div>

    <!--Login form/Modal-->    
      <form method="post" id="loginform">
        <div class="modal" id="loginModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <!-- model header -->
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>
                  <h4 id="myModalLabel">
                    Login:    
                  </h4>
                </div>
                <!-- model header ends -->
              <div class="modal-body">
                  
                  <!--Login message from PHP file-->
                  <div id="loginmessage"></div>
                  

                  <div class="form-group">
                      <label for="loginemail" class="sr-only">Email:</label>
                      <input class="form-control" type="email" name="loginemail" id="loginemail" placeholder="Email" maxlength="50">
                  </div>
                  <div class="form-group">
                      <label for="loginpassword" class="sr-only">Password:</label>
                      <input class="form-control" type="password" name="loginpassword" id="loginpassword" placeholder="Password" maxlength="30">
                  </div>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="rememberme" id="rememberme">
                        Remember me
                      </label>
                          <a class="pull-right" style="cursor: pointer" data-dismiss="modal" data-target="#forgotpasswordModal" data-toggle="modal">
                      Forgot Password?
                      </a>
                  </div>
                  
              </div>
              <div class="modal-footer">
                  <!-- login button -->
                  <input class="btn green" name="login" type="submit" value="Login">
                  <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                  </button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="signupModal" data-toggle="modal">
                  Register
                </button>  
              </div>
          </div>
      </div>
      </div>
      </form>

    <!--Sign up form--> 
      <form method="post" id="signupform">
        <div class="modal" id="signupModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>
                  <h4 id="myModalLabel">
                    Sign up today
                  </h4>
              </div>
              <div class="modal-body">
                  
                  <!--Sign up message from PHP file-->
                  <div id="signupmessage"></div>
                  
                  <div class="form-group">
                      <label for="username" class="sr-only">Username:</label>
                      <input class="form-control" type="text" name="username" id="username" placeholder="Username" maxlength="30">
                  </div>
                  <div class="form-group">
                      <label for="firstname" class="sr-only">Firstname:</label>
                      <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Firstname" maxlength="30">
                  </div>
                  <div class="form-group">
                      <label for="lastname" class="sr-only">Lastname:</label>
                      <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Lastname" maxlength="30">
                  </div>
                  <div class="form-group">
                      <label for="email" class="sr-only">Email:</label>
                      <input class="form-control" type="email" name="email" id="email" placeholder="Email Address" maxlength="50">
                  </div>
                  <div class="form-group">
                      <label for="password" class="sr-only">Choose a password:</label>
                      <input class="form-control" type="password" name="password" id="password" placeholder="Choose a password" maxlength="30">
                  </div>
                  <div class="form-group">
                      <label for="password2" class="sr-only">Confirm password</label>
                      <input class="form-control" type="password" name="password2" id="password2" placeholder="Confirm password" maxlength="30">
                  </div>
                  <div class="form-group">
                      <label for="phonenumber" class="sr-only">Telephone:</label>
                      <input class="form-control" type="text" name="phonenumber" id="phonenumber" placeholder="Telephone Number" maxlength="15">
                  </div>
                  <div class="form-group">
                      <label><input type="radio" name="gender" id="male" value="male">Male</label>
                      <label><input type="radio" name="gender" id="female" value="female">Female</label>
                  </div>
                  <div class="form-group">
                      <label for="moreinformation">Comments: </label>
                      <textarea name="moreinformation" class="form-control" rows="5" maxlength="300"></textarea>
                  </div>
              </div>
              <!-- sign up to database   -->
              <div class="modal-footer">
                  <input class="btn green" name="signup" type="submit" value="Sign up">
                  <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                  </button>
              </div>
          </div>
      </div>
      </div>
      </form>

    <!--Forgot password form-->
      <form method="post" id="forgotpasswordform">
        <div class="modal" id="forgotpasswordModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>
                  <h4 id="myModalLabel">
                    Forgot Password? Enter your email address: 
                  </h4>
              </div>
              <div class="modal-body">
                  
                  <!--forgot password message from PHP file-->
                  <div id="forgotpasswordmessage"></div>
                  

                  <div class="form-group">
                      <label for="forgotemail" class="sr-only">Email:</label>
                      <input class="form-control" type="email" name="forgotemail" id="forgotemail" placeholder="Email" maxlength="50">
                  </div>
              </div>
              <div class="modal-footer">
                  <input class="btn green" name="forgotpassword" type="submit" value="Submit">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  Cancel
                </button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-toggle="modal" data-target="#signupModal">
                  Register
                </button>  
              </div>
          </div>
      </div>
      </div>
      </form>
      <section class ="about" id="About">
<div class="container">
  <div class="box">
  <img src = "coins.png" width="50px" height ="50px"></img>
  <h6>Your pick of rides at low prices</h6>
  <p>No matter where you’re going, by bus or carpool, find the perfect ride from our wide range of destinations and routes at low prices.</p>
  </div>
  <div class="box">
  <img src = "approval.png" width="50px" height ="50px"></img>
  <h6>Trust who you travel with</h6>
  <p>We take the time to get to know each of our members and bus partners. We check reviews, profiles and IDs, so you know who you’re travelling with and can book your ride at ease on our secure platform.</p>
  </div>
  <div class="box">
  <img src = "lighting.png" width="50px" height ="50px"></img>
  <h6>Scroll, click, tap and go!</h6>
  <p>Booking a ride has never been easier! Thanks to our simple app powered by great technology, you can book a ride close to you in just minutes.</p>
  </div>
</div>

</section>
<section class ="about1">
<div class="container1">
        <div class="image-div">
            <img src="ab1.png" alt="Your Image" width ="400x" height ="400px">
        </div>
        <div class="text-div">
        <h5>Your safety is our priority</h5>
            <p>At Ride-Share, we're working hard to make our platform as secure as it can be. But when scams do happen, we want you to know exactly how to avoid and report them. Follow our tips to help us keep you safe.</p>
            <button type="button" class="btn btn-lg green signup" data-toggle="modal" data-target="#signupModal">Sign up</button>
            </div>
        
    </div>
</section>
<section class ="about1">
<div class="container2">
        
        <div class="text-div">
        <!-- signup button bottom  -->
        <h5>Driving in your car soon?</h5>
            <p>Good news, drivers: get rewarded for your good habits! Earn the Carpool Bonus by completing 3 carpools in 3 months. See eligibility conditions.</p>
            <!-- <a href="signup.html" class="signup-button" data-target="#signupModal">Sign Up</a> -->
            <button type="button" class="btn btn-lg green signup" data-toggle="modal" data-target="#signupModal">Sign up</button>
            </div>
        <div class="image-div">
            <img src="ab2.png" alt="Your Image" width ="400x" height ="400px">
        </div>
    </div>
</section>

<footer>
        &copy;  All rights reserved 2023    B-1    G-4
    </footer>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  
    <script src="js/bootstrap.min.js"></script>
    <script src="map.js"></script>  
    <script src="javascript.js"></script>
  </body>
</html>



