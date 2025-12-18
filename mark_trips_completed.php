<?php

// Set the timezone to Indian Standard Time (IST)
date_default_timezone_set('Asia/Kolkata');

// Database connection details (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vrsride";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current IST
$current_ist = date('Y-m-d H:i:s');

// SQL UPDATE query
$sql = "UPDATE bookings
        SET trip_completed = TRUE
        WHERE trip_completed = FALSE AND end_time < ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $current_ist);

if ($stmt->execute()) {
    $rows_affected = $stmt->affected_rows;
    echo "Successfully marked " . $rows_affected . " trips as completed.\n";
} else {
    echo "Error updating trip completion status: " . $conn->error . "\n";
}

$stmt->close();
$conn->close();

?>