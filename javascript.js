//create a geocoder object to use the geocode
var geocoder = new google.maps.Geocoder();
var data;

//Ajax Call for the sign up form 
//Once the form is submitted
$("#signupform").submit(function(event){
    //hide message
    $("#signupmessage").hide();
    //show spinner
    $("#spinner").css("display", "block");
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
    //send them to signup.php using AJAX
    $.ajax({
        url: "signup.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#signupmessage").html(data);
                //hide spinner
                $("#spinner").css("display", "none");
                //show message
                $("#signupmessage").slideDown();
            }
        },
        error: function(){
            $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            //hide spinner
            $("#spinner").css("display", "none");
            //show message
            $("#signupmessage").slideDown();
            
        }
    
    });

});

//Ajax Call for the login form
//Once the form is submitted
$("#loginform").submit(function(event) {
    // Hide message
    $("#loginmessage").hide();
    // Prevent default php processing
    event.preventDefault();
    // Collect user inputs
    var datatopost = $(this).serializeArray();

    // Send them to login.php using AJAX
    $.ajax({
        url: "login.php",
        type: "POST",
        data: datatopost,
        success: function(data) {
            console.log(data); // Check what data is received from the server
            if (data) {
                // Redirect to mainpageloggedin.php on successful login
                window.location = "index.php";
            } else {
                $('#loginmessage').html(data);
                // Show message
                $("#loginmessage").slideDown();
            }
        },
        
        error: function() {
            $("#loginmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            // Show message
            $("#loginmessage").slideDown();
        }
    });
});



// //Ajax Call for the forgot password form
// //Once the form is submitted
// $("#forgotpasswordform").submit(function(event){ 
//     //hide message
//     $("#forgotpasswordmessage").hide();
//     //show spinner
//     $("#spinner").css("display", "block");
//     //prevent default php processing
//     event.preventDefault();
//     //collect user inputs
//     var datatopost = $(this).serializeArray();
// //    console.log(datatopost);
//     //send them to signup.php using AJAX
//     $.ajax({
//         url: "forgot-password.php",
//         type: "POST",
//         data: datatopost,
//         success: function(data){
//             $('#forgotpasswordmessage').html(data);
//             //hide spinner
//             $("#spinner").css("display", "none");
//             //show message
//             $("#forgotpasswordmessage").slideDown();
//         },
//         error: function(){
//             $("#forgotpasswordmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
//             //hide spinner
//             $("#spinner").css("display", "none");
//             //show message
//             $("#forgotpasswordmessage").slideDown();
//         }
    
//     });

// });

//Ajax Call for the search form 
$("#searchform").submit(function(event){
    $("#results").fadeOut();
    // $("#spinner").css("display", "block");
    event.preventDefault();
    data = $(this).serializeArray();
    console.log(data);
    
    $.ajax({
        url: "search.php",
        data: data,
        type: "POST",
        success: function(data2){
            console.log(data);
            if(data2){
                $('#results').html(data2);
                //accordion
                $("#message").accordion({
                    icons: false,
                    active:false,
                    collapsible: true,
                    heightStyle: "content"   
                });
            }
            $("#spinner").css("display", "none");
            $("#results").fadeIn();
    },
        error: function(){
            $("#results").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            $("#spinner").css("display", "none");
            $("#results").fadeIn();

}
    }); 
   
    
});
// Bind the click event to the class .send-request-btn



// Use a class selector for the button
function btn() {
    console.log('Button clicked');
    const tripId = $(this).data('trip-id');
    const receiverId = $(this).data('receiver-id');
// data=$(this).serializeArray)
    // Make an AJAX request to send the request
    $.ajax({
        type: 'POST',
        url: 'trip_request.php', // Replace with the actual URL of your PHP script
        data: {
            trip_id: tripId,
            receiver_id: receiverId
        },
        success: function (response) {
            // Handle the response from the server
            if (response.success) {
                // Request sent successfully
                alert('Request sent successfully!');
            } else {
                // Error sending request
                alert('Error sending request: ' + response.message);
            }
        },
        error: function () {
            // Handle AJAX errors here
            alert('An error occurred while sending the request.');
        }
    });
};

   