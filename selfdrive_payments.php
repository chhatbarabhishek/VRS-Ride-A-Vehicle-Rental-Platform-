<?php
// Database connection details
$servername = "localhost";  // Change this to your database host
$username = "root";         // Change to your database username
$password = "";             // Change to your database password
$dbname = "vrsride";        // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $car_name = $_POST['car_name'];
    $amount = $_POST['amount'];
    $card_number = $_POST['card_number'];
    $card_expiry = $_POST['card_expiry'];
    $card_cvc = $_POST['card_cvc'];
    
    // Prepare the SQL query to insert the data into the database
    $stmt = $conn->prepare("INSERT INTO payments (car_name, amount, card_number, card_expiry, card_cvc) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $car_name, $amount, $card_number, $card_expiry, $card_cvc);
    
    // Execute the query and check for success
    if ($stmt->execute()) {
        // Success message
        echo "<script>
                alert('Payment details have been successfully recorded. Redirecting to the booking page...');
                window.location.href = 'book.php';  // Redirect to the book.php page
              </script>";
    } else {
        // Error message
        echo "<script>
                alert('Error: " . $stmt->error . "');
              </script>";
    }
    
    // Close the prepared statement and connection
    $stmt->close();
    $conn->close();
}
?>