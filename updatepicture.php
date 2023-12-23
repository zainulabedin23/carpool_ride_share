<?php
session_start();
include('connection.php');

$user_id = $_SESSION['user_id'];

function changeProfilePicture($id, $file, $ext, $con){
    $permanentdestination = 'profilepicture/' . md5(time()) . ".$ext";
    if(move_uploaded_file($file, $permanentdestination)){
        $sql = "UPDATE users SET profilepicture='$permanentdestination' WHERE user_id='$id'";
        $result = mysqli_query($con, $sql);
        if(!$result){
            $resultMessage = '<div class="alert alert-danger">Unable to update profile picture. Please try again later.</div>';
            echo $resultMessage;
        }
    } else {
        $resultMessage = '<div class="alert alert-warning">Unable to upload file. Please try again later.</div>';
        echo $resultMessage;
    }
}

$errors = array();
$name = $_FILES["picture"]["name"];
$extension = pathinfo($name, PATHINFO_EXTENSION);
$type = $_FILES["picture"]["type"];
$size = $_FILES["picture"]["size"];
$fileerror = $_FILES["picture"]["error"];
$tmp_name = $_FILES["picture"]["tmp_name"];

$allowedFormats = array("jpeg" => "image/jpeg", "jpg" => "image/jpg", "png" => "image/png");

if($fileerror == 4){
    $errors[] = "Please upload a file!";
} else {
    if(!in_array($type, $allowedFormats)){
        $errors[] = "Sorry, you can only upload jpeg, jpg, and png files!";
    } elseif($size > 3 * 1024 * 1024){
        $errors[] = "You can only upload files smaller than 3MB!";
    }  
}

if(!empty($errors)){
    foreach($errors as $error){
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }
} else {
    changeProfilePicture($user_id, $tmp_name, $extension, $link);
} 
?>
