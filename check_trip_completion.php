<?php
// Set the timezone to Indian Standard Time (IST)
date_default_timezone_set('Asia/Kolkata');

// Database connection details
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

// Get current IST time
$current_ist = date('Y-m-d H:i:s');

// SQL query to mark trips as completed if the pickup time has passed
$sql = "UPDATE bookings
        SET trip_completed = TRUE
        WHERE trip_completed = FALSE AND pickup_time < ?";

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
