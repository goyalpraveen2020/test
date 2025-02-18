<?php
session_start(); // Start session for login tracking

// Database connection
$conn = new mysqli("localhost", "root", "1234", "krishna_healthcare");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Direct SQL query (Avoid using this in production)
    $result = $conn->query("SELECT id, name, password FROM users WHERE email = '$email'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
		
		 // Debugging Output
    //echo "DEBUG: Entered Password: " . $password . "<br>";
    //echo "DEBUG: Stored Hash: " . $hashed_password . "<br>";
        if (password_verify($password, $hashed_password)) {
            // Password correct - create session
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];

            // Redirect to welcome page
            header("Location: welcome.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User does not exist!";
    }

    $conn->close();
}
?>
