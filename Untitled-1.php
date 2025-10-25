<?php
// PHP logic (e.g., checking for session, setting variables) goes here

$login_url = "login.php";
$signup_url = "signup.php";

// Start of HTML output
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awana Resturant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="splash-container">
        <h1 class="logo-text">awana <span class="resturant-text">RESTURANT</span></h1>
        <p class="slogan">SAVOR THE ART OF FINE DINING.</p>
        <div class="button-group">
            <a href="' . $login_url . '" class="btn btn-login">Log in</a>
            <a href="' . $signup_url . '" class="btn btn-signup">Sign Up</a>
        </div>
    </div>
</body>
</html>';

?>