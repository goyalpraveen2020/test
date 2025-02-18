<?php
session_start();
if (isset($_SESSION["user_id"])) {
    echo "Welcome, " . $_SESSION["username"] . "!";
    // ... rest of your welcome page content ...
} else {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
?>
