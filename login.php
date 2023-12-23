<?php
// Start session
session_start();
// Connect to the database
include("connection.php");

// Check user inputs
$errors = ""; // Initialize error string

// Define error messages
$missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$missingPassword = '<p><strong>Please enter your password!</strong></p>';

// Get email and password
if (empty($_POST["loginemail"])) {
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST["loginemail"], FILTER_SANITIZE_EMAIL);
}

if (empty($_POST["loginpassword"])) {
    $errors .= $missingPassword;
} else {
    $password = filter_var($_POST["loginpassword"], FILTER_SANITIZE_STRING);
}

// If there are any errors
if ($errors) {
    // Print error message
    echo '<div class="alert alert-danger">' . $errors . '</div>';
} else {
    // Prepare variables for the query
    $email = mysqli_real_escape_string($link, $email);
    $password = mysqli_real_escape_string($link, $password);
    $password = hash('sha256', $password);

    // Run query: Check combination of email & password exists
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND activation='activated'";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error running the query!</div>';
    } else {
        // If email & password don't match, print error
        $count = mysqli_num_rows($result);

        if ($count !== 1) {
            echo '<div class="alert alert-danger">Wrong Username or Password</div>';
        } else {

/****************************************************************************************** */
            // Log the user in: Set session variables
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
/******************************************************************************************** */
            if (empty($_POST['rememberme'])) {
                // If remember me is not checked
                echo "success"; // Notify AJAX of successful login
            } else {
                // Create two variables $authenticator1 and $authenticator2
                $authenticator1 = bin2hex(openssl_random_pseudo_bytes(10));
                $authenticator2 = openssl_random_pseudo_bytes(20);

                // Store them in a cookie
                $cookieValue = $authenticator1 . ',' . bin2hex($authenticator2);
                setcookie("rememberme", $cookieValue, time() + 1296000);

                // Run query to store them in rememberme table
                $f2authenticator2 = hash('sha256', $authenticator2);
                $user_id = $_SESSION['user_id'];
                $expiration = date('Y-m-d H:i:s', time() + 1296000);

                $sql = "INSERT INTO rememberme
                (`authenticator1`, `f2authenticator2`, `user_id`, `expires`)
                VALUES
                ('$authenticator1', '$f2authenticator2', '$user_id', '$expiration')";

                $result = mysqli_query($link, $sql);

                if (!$result) {
                    echo '<div class="alert alert-danger">There was an error storing data to remember you next time.</div>';
                } else {
                    echo "success"; // Notify AJAX of successful login
                }
            }
        }
    }
}
?>
