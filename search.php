<?php
// Start session and connect to the database
session_start();
include('connection.php');

// Define error messages
$missingdeparture = '<p><strong>Please enter your departure!</strong></p>';
$invaliddeparture = '<p><strong>Please enter a valid departure!</strong></p>';
$missingdestination = '<p><strong>Please enter your destination!</strong></p>';
$invaliddestination = '<p><strong>Please enter a valid destination!</strong></p>';

// Initialize error variable
$errors = '';

// Check if 'user_id' is set in the session
if (isset($_SESSION['user_id'])) {
    // User is logged in, get the user_id
    $user_id = $_SESSION['user_id'];
} else {
    // User is not logged in, you can handle this case differently
    // For example, display a message or provide limited functionality
    $user_id = null; // Set user_id to null for non-logged-in users
}

// Get inputs
$departure = $_POST["departure"];
$destination = $_POST["destination"];
$tripPrice = '';
$moreInformation = '';

// Check departure
if (!$departure) {
    $errors .= $missingdeparture;
} else {
    $departure = filter_var($departure, FILTER_SANITIZE_STRING);
}

// Check destination
if (!$destination) {
    $errors .= $missingdestination;
} else {
    $destination = filter_var($destination, FILTER_SANITIZE_STRING);
}

// If there are errors, print error message
if ($errors) {
    $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage;
    exit;
}
// $sql = "SELECT * FROM carsharetrips WHERE departure='$departure' AND destination='$destination'";
$sql = "SELECT * FROM carsharetrips WHERE departure='$departure' AND destination='$destination' AND user_id!='$user_id' ORDER BY date ASC, time ASC LIMIT 0, 10";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo "ERROR: Unable to execute: $sql. " . mysqli_error($link);
    exit;
}

if (mysqli_num_rows($result) == 0) {
    echo "<div class='alert alert-info noresults'>There are no journeys matching your search!</div>";
    exit;
}

echo "<div class='alert alert-info journeysummary'>From $departure to $destination.<br />Closest Journeys:</div>";
echo '<div id="message">';

// Cycle through trips and find close ones

// Retrieve each row in $result
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
{

    // Check if the trip date is in the past
    if ($row['seatsavailable'] <= 0 ) {
        continue;
    }

    $dateOK = 1;
    if ($row['regular'] == "N") {
        $source = $row['date'];
        $tripDate = DateTime::createFromFormat('D d M, Y', $source);
        $today = date("D d M, Y");
        $todayDate = DateTime::createFromFormat('D d M, Y', $today);
        $dateOK = ($tripDate > $todayDate);
    }


    // If date is ok
    if ($dateOK) 
    {
        // Print trip

        // Get trip user id
        $person_id = $row['user_id'];


        // Run query to get user details
        $sql2 = "SELECT * FROM users WHERE user_id='$person_id' LIMIT 1";
        $result2 = mysqli_query($link, $sql2);

        if ($result2) 
        {

            // Get user details
            $row2 = mysqli_fetch_array($result2);

            // Get phone number:
            if (isset($_SESSION['user_id'])) {
                $phonenumber = $row2['phonenumber'];

            } else {
                $phonenumber = "Please sign up! Only members have access to contact information.";
            }

            // Get picture
            $picture = $row2['profilepicture'];
            // Get firstname
            $firstname = $row2['first_name'];

            // Get gender
            $gender = $row2['gender'];

            // More information
            
  
            //more information
            $moreInformation = $row2['moreinformation'];
            
            //get trip departure
            // $tripDeparture = $row['departure'];
            
            //get trip destination
            // $tripDestination = $row['destination'];
            
            //get trip price
            $tripPrice = $row['price'];
            
            //get seats available in the trip
            $seatsAvailable = $row['seatsavailable'];
            
            //Get trip frequency and time:
            if($row['regular']=="N"){
                $frequency = "One-off journey.";
                $time = $row['date']." at " .$row['time'].".";
            }else{
                $frequency = "Regular.";
                $weekdays=['monday'=>'Mon','tuesday'=>'Tue','wednesday'=>'Wed','thursday'=>'Thu','friday'=>'Fri','saturday'=>'Sat','sunday'=>'Sun'];
                $array = [];
                foreach($weekdays  as $key => $value){
                    if($row[$key]==1){
                        array_push($array,$value);
                    }
                    $time = implode("-", $array)." at " .$row['time'].".";
                }
            }

            
            //print trip
            // $sql3 = "SELECT * FROM `riderequest` WHERE trip_id='$trip_id' AND user_id='$user_id'";
            // $result3 = mysqli_query($link, $sql3);
            
            
            // if (isset($_SESSION['user_id']) && mysqli_num_rows($result3)==0) 
            $verification_query = "SELECT * FROM `driver` WHERE driver_id='$person_id'";
            $verification_result = mysqli_query($link, $verification_query);
            $verification_result = mysqli_fetch_array($verification_result);
           

            echo 
             "<h3 class='row'>
             <div class='col-sm-3 journey'>
             <div>
                 <!-- Add a container div with a specific width and height -->
                 <div class='image-container'>
                     <img class='previewing' src='$picture' / width = '100px' height ='100px' >
                 </div>
             </div>
         </div>
         

                <div class='col-sm-7 journey'>
                    <div>
                        <span class='departure'>Departure:
                        </span> 
                        $departure.
                    </div>
                    <div>
                        <span class='destination'>Destination:
                        </span> 
                        $destination.
                    </div>
                    
                    <div class='time'>
                        $time
                    </div>
                    <div>
                        $frequency
                    </div>
                </div>

                <div class='col-sm-2 price journey2'>
                    <div class='price'>
                        Rs$tripPrice
                    </div>

                    <div class='perseat'>
                        Per Seat
                    </div>
                    <div class='seatsavailable'>
                        $seatsAvailable left
                    </div>
                </div>
            </h3>";
            
            echo 
            "<div class='moreinfo'>
                <div>
                    <div>
                        Gender: $gender
                    </div>
                    <div class='telephone'>
                        &#9742: $phonenumber
                    </div>";
      

                    // $trip_id = $row['trip_id'];
                    // $sql3 = "SELECT * FROM `riderequest` WHERE trip_id='$trip_id' AND user_id='$user_id'";
                    // $result3 = mysqli_query($link, $sql3);
                    
                    
                    if (isset($_SESSION['user_id'])) 
                    {
                        // echo $person_id;
                        $trip_id = $row['trip_id'];

                        // echo $trip_id;
                        // echo $_SESSION['user_id'];

              
?>                      
                    <button class='btn btn-lg green signup' id='sendReq' onclick='sendAction(1,"<?php echo $person_id ?>","<?php echo $trip_id ?>")'>Send Request</button>
                    <span id="req_send_alert"></span>
<script>
function sendAction(constant,driver_id,trip_id){
    alert("Request Sent !");
    btn = document.getElementById('sendReq');
    spn = document.getElementById('req_send_alert');
    btn.style.display="none";
    spn.innerHTML = "Request Sent !";

   $.post(`request_query.php?action=sendReq&id=${driver_id}&trip_id=${trip_id}`,function(res){   })


} 
</script>

                    
<?php
        
                    }
                    // else{
                    //     echo "<button class='btn btn-lg green signup' >Request Already sent</button>";
                    // }
          
            echo "</div>
                <div class='aboutme'>
                About me: $moreInformation
                </div>
            </div>";
        }
    }
}

?>




















