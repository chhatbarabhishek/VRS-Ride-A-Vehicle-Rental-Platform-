<?php
// Database connection
$host = "localhost";  // Change this to your database host
$user = "root";       // Change this to your database username
$password = "";       // Change this to your database password
$dbname = "vrsride";  // Change this to your database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Sanitize and validate input
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $feedback = mysqli_real_escape_string($conn, trim($_POST['feedback']));

    // Check if all fields are filled
    if (!empty($name) && !empty($email) && !empty($feedback)) {
        // Insert feedback into the database
        $sql = "INSERT INTO feedback (name, email, feedback) VALUES ('$name', '$email', '$feedback')";

        if ($conn->query($sql) === TRUE) {
            // Success: Show alert with success message and redirect to home page
            echo '<script type="text/javascript">
                    alert("Thank you for your feedback!");
                    window.location.href = "index1.php";  // Change "index.php" to your homepage URL
                  </script>';
        } else {
            // Error: Show alert with error message and redirect to home page
            echo '<script type="text/javascript">
                    alert("Error: ' . $conn->error . '");
                    window.location.href = "index1.php";  // Change "index.php" to your homepage URL
                  </script>';
        }
    } else {
        // Missing fields: Show alert with error message and redirect to home page
        echo '<script type="text/javascript">
                alert("All fields are required!");
                window.location.href = "index1.php";  // Change "index.php" to your homepage URL
              </script>';
    }

    // Close connection
    $conn->close();
}
?>