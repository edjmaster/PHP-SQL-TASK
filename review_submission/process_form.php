<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database credentials
$host = 'localhost';
$db = 'reviews_db';
$user = 'root';
$password = ''; // Adjust based on your setup

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $review = htmlspecialchars($_POST['review']);

    // Validate inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO reviews (name, email, review) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $review);

    // Execute and confirm
    if ($stmt->execute()) {
        echo "Thank you! Your review has been submitted.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
