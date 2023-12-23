<?php
// Start a session to access session variables
session_start();
include('connection.php');
?>



<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<title>Contact-Us</title>
    <style>
        *{
	box-sizing: border-box;
	font-family: 'poppins', sans-serif;
}
body{
	margin: 0;
	padding: 0;
	
	
	
}
.form{
    display: flex;
	align-items: center;
	justify-content: center;
    background-color: #004658;
    height: 90vh;
}
.container{
	width: 350px;
	background-color: white;
	border-radius: 5px;
	padding: 20px;
	text-align: center;
}
.container input{
	width: 100%;
	padding: 10px;
	border: none;
	border-bottom: 2px solid #777777;
	margin-bottom: 20px;
	font-size: 16px;
	outline: none;
}
.btn{
	border: none !important;
	cursor: pointer;
	background-color: #004658;
    color: white;
	margin: 15px 0;
	font-size: 16px;
	width: 100%;
	padding: 14px;
}
.btn:hover{
	background-color: #033744;
	color: white;
}
/* Style the navigation section */
/* Style the navigation section */
section {
    background-color: #ffffff;
    padding: 3px 0;
}

/* Style the navigation bar */
.navbar {
    text-align: left; /* Align the navbar to the left */
}

/* Style the navigation menu items */
.navbar ul {
    list-style-type: none;
    padding: 0;
}

.navbar li {
    display: inline-block;
    margin: 0 10px;
}

.navbar a {
    color: #004658;
    text-decoration: none;
    font-weight: bold;
    font-size: 16px;
}

/* Style the active menu item */
.navbar li.active {
    border-bottom: 2px solid #004658;
}

/* Hover effect for menu items */
.navbar li:hover {
    border-bottom: 2px solid #004658;
    transition: border-bottom 0.3s ease-in-out;
}


    </style>
</head>
<body>
    <section>
    <nav class="navbar">
        
        <div class="align">
            
        <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Search</a></li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="#">Help</a></li>
          <li><a href="contact.html">Contact us</a></li>
          
        </ul>
    </div>
    </nav>
</section>
<section class="form">
	<div class="container">
		<h2>Get in Touch</h2>
		<form id="contactForm">
			<input type="text" id="name" placeholder="name" name="name" required>
			<input type="text" id="phone" placeholder="phone" name="phone" required>
			<input type="text" id="query" placeholder="query" name="query" required>
            
			<button type="submit" class="btn">submit</button>
		</form>
	</div> 
</section>
<script>
document.getElementById("contactForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    var name = document.getElementById("name").value;
    var phone = document.getElementById("phone").value;
    var query = document.getElementById("query").value;

    // Make an AJAX request to save data
    $.ajax({
                url: "feedback.php", // PHP script to handle data saving
                type: "POST",
                data: {
                    name: name,
                    phone: phone,
                    query: query
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        // Data saved successfully, show success message and reset the form
                        swal({
                            title: "Success!",
                            text: "Your message has been sent successfully.",
                            icon: "success",
                            button: false,
                        });
                        setTimeout(function() {
                            window.location.href = "index.php";
                        }, 3000);
                    } else {
                        // Error occurred while saving data, show error message
                        swal({
                            title: "Error!",
                            text: "Failed to save your message. Please try again later.",
                            icon: "error",
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors here
                    console.error("AJAX request failed: " + status, error);
                    swal({
                        title: "Error!",
                        text: "Failed to save your message. Please try again later.",
                        icon: "error",
                    });
                }
            });
        });


</script>

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://smtpjs.com/v3/smtp.js"></script>


</body>
</html>