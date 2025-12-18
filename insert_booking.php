<?php

// Database connection details
$servername = "localhost"; // Replace with your database server name (e.g., localhost)
$username = "root";     // Replace with your database username
$password = "";         // Replace with your database password
$dbname = "vrsride"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $email = mysqli_real_escape_string($conn, $_POST["email"]); // Get email
    $name = mysqli_real_escape_string($conn, $_POST["name"]);   // Get name
    $drivingType = mysqli_real_escape_string($conn, $_POST["drivingType"]);
    $Picklocation = mysqli_real_escape_string($conn, $_POST["Picklocation"]);
    $Droplocation = mysqli_real_escape_string($conn, $_POST["Droplocation"]);
    $pickupDate = mysqli_real_escape_string($conn, $_POST["pickupDate"]);
    $pickupTime = mysqli_real_escape_string($conn, $_POST["pickupTime"]);
    $carModel = mysqli_real_escape_string($conn, $_POST["carModel"]);
    $carName = mysqli_real_escape_string($conn, $_POST["carName"]);
    $numOfPeople = mysqli_real_escape_string($conn, $_POST["numOfPeople"]);

    $drivingLicensePath = null; // Initialize driving license path

    // Handle driving license upload if self-drive is selected
    if ($drivingType === 'self' && isset($_FILES['drivingLicense']) && $_FILES['drivingLicense']['error'] === 0) {
        $uploadDir = 'uploads/'; // Create this directory on your server
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB

        $fileType = $_FILES['drivingLicense']['type'];
        $fileSize = $_FILES['drivingLicense']['size'];
        $fileName = basename($_FILES['drivingLicense']['name']);
        $tempFile = $_FILES['drivingLicense']['tmp_name'];
        $newFileName = uniqid() . '_' . $fileName;
        $targetFilePath = $uploadDir . $newFileName;

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
            if (move_uploaded_file($tempFile, $targetFilePath)) {
                $drivingLicensePath = mysqli_real_escape_string($conn, $targetFilePath);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error uploading driving license.']);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid file type or size for driving license. Allowed types: JPG, PNG, PDF (max 2MB).']);
            exit();
        }
    } elseif ($drivingType === 'self' && (!isset($_FILES['drivingLicense']) || $_FILES['drivingLicense']['error'] !== 0)) {
        echo json_encode(['success' => false, 'message' => 'Please upload your driving license for self-drive.']);
        exit();
    }

    // SQL query to insert data (including email and name)
    $sql = "INSERT INTO bookings (email, name, drivingType, Picklocation, Droplocation, pickupDate, pickupTime, carModel, carName, numOfPeople, drivingLicensePath)
            VALUES ('$email', '$name', '$drivingType', '$Picklocation', '$Droplocation', '$pickupDate', '$pickupTime', '$carModel', '$carName', '$numOfPeople', '$drivingLicensePath')";

    if ($conn->query($sql) === TRUE) {
        if ($drivingType === 'self') {
            echo json_encode(['success' => true, 'redirect' => 'payment_page.php']);
        } else {
            echo json_encode(['success' => true, 'message' => 'Booking successful!', 'redirect' => 'book.php']); // Optionally redirect driver drive to book.php or remove redirect
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . "<br>" . $conn->error]);
    }
    exit(); // Important to stop further execution
}

$conn->close();

?>