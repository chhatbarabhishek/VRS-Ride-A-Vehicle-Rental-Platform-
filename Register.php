<?php
include("Config.php");
session_start();
$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['name'];
    $email = mysqli_real_escape_string($db,$_POST['email']);
    $password = $_POST['password'];
    $mobile = $_POST['phone'];

    // Check if email already exists
    $sql = "SELECT Email FROM Users WHERE Email = '$email'";
    $result = mysqli_query($db,$sql); 
    $row = mysqli_num_rows($result);      
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $message = "Email ID already exists";
        $toastClass = "#007bff"; // Primary color
    } else {
        // Prepare and bind
        $stmt = "INSERT INTO Users (username, email, password, mobile) VALUES ('$username', '$email', '$password', '$mobile')";

        if ($stmt->execute()) {
            $message = "Account created successfully";
            $toastClass = "#28a745"; // Success color
        } else {
            $message = "Error: " . $stmt->error;
            $toastClass = "#dc3545"; // Danger color
        }

        $stmt->close();
    }

}
?>