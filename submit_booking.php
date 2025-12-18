<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Change to your MySQL database username
$password = ""; // Change to your MySQL database password
$dbname = "vrsride"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $pickup_time = $_POST['pickup_time'];
    $trip_name = $_POST['trip_name'];

    // Prepare the SQL query to insert the data
    $stmt = $conn->prepare("INSERT INTO trip_registration (name, email, phone, date, pickup_time, trip_name) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $phone, $date, $pickup_time, $trip_name);

    // Execute the query and check for success
    if ($stmt->execute()) {
        // Success: Show popup message and redirect to homepage
        echo '<script type="text/javascript">
                alert("Booking successful!");
                window.location.href = "tourist.php";  // Change "index.php" to your homepage URL
              </script>';
    } else {
        // Error: Show error message in popup and redirect to homepage
        echo '<script type="text/javascript">
                alert("Error: ' . $stmt->error . '");
                window.location.href = "tourist.php";  // Change "index.php" to your homepage URL
              </script>';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>