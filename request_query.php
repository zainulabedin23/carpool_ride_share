<?php 
    session_start();
    include('connection.php');

    if($_REQUEST['action']==='sendReq')
    {
        $driver_id  = $_REQUEST['id'];
        $trip_id=$_REQUEST['trip_id'];
        $user_id = $_SESSION['user_id'];


        $request = "INSERT INTO riderequest(user_id, driver_id, status,	trip_id) VALUES ('$user_id','$driver_id','pending','$trip_id')";
        $request_query = mysqli_query($link, $request);




   
        
        if ($request_query) {
            $success  =  "Request send, saved into DB";
        } else {
            $success  =  "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    
 

    }
    else if($_REQUEST['action']==='RequestSection'){
        $request_id  = $_REQUEST['request_id'];
        $user_id = $_SESSION['user_id'];
        // $dateAdded_now = date('Y-m-d');
        $update_req = "UPDATE riderequest SET status='accepted' WHERE request_id='$request_id'";
        $result = mysqli_query($link, $update_req);
        if($result){
            $seat_query = "update carsharetrips set seatsavailable = seatsavailable-1 where trip_id = (select trip_id from riderequest where request_id = '$request_id')";
            $seat_result = mysqli_query($link, $seat_query);
            echo "Request Accepted";

        }
        else{

            echo "Error";
        }

        
        
        
    }
    else if($_REQUEST['action']==='deleteRequest')
    {
        $request_id  = $_REQUEST['request_id'];
        $user_id = $_SESSION['user_id']; //driver id

        $update_req = "UPDATE riderequest SET status='Rejected' WHERE request_id='$request_id'";
        $result = mysqli_query($link, $update_req);

        $status_query = "select status from riderequest where request_id = '$request_id'";
        $status_result = mysqli_query($link, $status_query);
        $status_result = mysqli_fetch_array($status_result);

        if($result){
            echo "Request Deleted";

        }
        else{

            echo "Error";
        }

    }
    else if($_REQUEST['action']==='perdeleteRequest')
    {
        $request_id  = $_REQUEST['request_id'];

        $delete_query = "DELETE FROM riderequest WHERE request_id='$request_id'";
        $result = mysqli_query($link, $delete_query);
        if($result){
            echo "Request Deleted";

        }
        else{

            echo "Error";
        }


    }

?>
