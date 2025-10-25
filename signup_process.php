<?php
// 1. Start a session (useful for sending messages or redirecting after login)
session_start();

// 2. Include the database connection file (e.g., db_connect.php)
// You will create this file later when setting up MySQL.
// include 'db_connect.php'; 

// Check if the form was actually submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Retrieve form data
$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

// Basic Server-Side Validation
$errors = [];

// A. Check for empty fields
if (empty($firstName) || empty($email) || empty($password) || empty($confirmPassword)) {
    $errors[] = "All fields are required.";
}

// B. Check Password Match
if ($password !== $confirmPassword) {
    $errors[] = "Passwords do not match.";
}

// C. Validate Email Format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

// D. Check Password Length/Complexity (Optional but recommended)
if (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters long.";
}

if (count($errors) > 0) {
    // If errors exist, store them in the session and redirect back to the signup form.
    $_SESSION['errors'] = $errors;
    header("Location: signup.html");
    exit();
}

// 1. Hash the password securely
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// 2. Connect to the database (Assuming $conn is the connection object from db_connect.php)
// You must have MySQL running and connected here.
// Example: $conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

// 3. Check if the email already exists (essential step!)
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Email already taken
    $_SESSION['errors'] = ["This email is already registered."];
    header("Location: signup.html");
    exit();
}

// 4. Insert the new user into the database
$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
// "ssst" means string, string, string, string (for the four variables)
$stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);

if ($stmt->execute()) {
    // Success!
    
    // Optional: Log the user in immediately
    $_SESSION['user_id'] = $conn->insert_id;
    $_SESSION['user_name'] = $firstName;
    
    // Redirect to the dashboard/order page
    header("Location: dashboard.php");
    exit();

} else {
    // Database error
    $_SESSION['errors'] = ["Registration failed due to a server error."];
    header("Location: signup.html");
    exit();
}

// Close the statement and connection
$stmt->close();
$conn->close();

} else {
    // If someone tries to access this page directly, redirect them
    header("Location: signup.html");
    exit();
}

// Inside signup_process.php (after successful database insertion):

if ($stmt->execute()) {
    // Success! Log the user in and redirect.
    $_SESSION['user_id'] = $conn->insert_id;
    $_SESSION['user_name'] = $firstName;
    
    // *** CHANGE REDIRECT URL TO THE NEW BRANCH SELECTION PAGE ***
    header("Location: branch_select.html"); 
    exit();

} else {
    // ... handle error ...
    $_SESSION['errors'] = ["Registration failed due to a server error."];
    header("Location: signup.html");
    exit();
}
?>