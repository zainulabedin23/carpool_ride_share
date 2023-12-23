<?php
// session_start(); // Start the session

if(isset($_SESSION['user_id']) && isset($_GET['logout']) && $_GET['logout'] == 1){
    session_destroy(); // Destroy the session data
    setcookie("rememberme", "", time()-3600); // Delete the "rememberme" cookie if present
    header("Location: index.php"); // Redirect to a login page or desired destination
    exit(); // Exit to prevent further execution
}
?>