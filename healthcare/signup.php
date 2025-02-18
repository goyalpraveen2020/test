<?php
$host = "localhost";
$dbname = "krishna_healthcare";
$username = "root";
$password = "1234";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// User data (replace with actual values)
$user = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$pass = password_hash($password, PASSWORD_BCRYPT); // Securely hash the password

// Insert query
$sql = "INSERT INTO users (name, email, password) VALUES ('$user', '$email', '$pass')";

// Execute query
if ($conn->query($sql) === TRUE) {
    echo "User added successfully!";
	header("Location: index.html");
} else {
    echo "Error: " . $conn->error;
}

// Close connection
$conn->close();
?>
