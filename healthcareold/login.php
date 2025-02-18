<?php
session_start(); // Start the session

// Database credentials
$servername = "localhost"; // Your MariaDB server name (usually localhost)
$username = "root"; // Your MariaDB username
$password = "1234"; // Your MariaDB password
$dbname = "krishna_healthcare"; // Your MariaDB database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["email"];
    $password = $_POST["password"];

    // Basic input validation (you should add more robust validation)
    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        // Prepare and execute the SQL query (using prepared statements for security)
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?"); // Assuming your users table has id, username, and password columns
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Verify the password (use password_verify() if you're hashing passwords)
            if (password_verify($password, $row["password"])) { //  Important: Use password_hash() when storing passwords.
              $_SESSION["user_id"] = $row["id"]; // Store user ID in session
              $_SESSION["email"] = $row["email"]; // Store username in session
              header("Location: welcome.php"); // Redirect to welcome page after successful login
              exit(); // Important to stop further script execution after redirect
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Username not found.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
</head>
<body>

    <h2>Login</h2>

    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>

</body>
</html>
