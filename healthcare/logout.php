<?php
session_start();

// Destroy session to log the user out
session_unset();
session_destroy();

header('Location: login.php');
exit();

