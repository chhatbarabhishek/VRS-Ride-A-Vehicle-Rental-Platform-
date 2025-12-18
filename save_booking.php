<!-- wrong code -->






<!-- <?php
// Database configuration
$host = "localhost";
$dbname = "vrsride";  // Replace with your database name
$username = "root";  // Replace with your MySQL username
$password = "";  // Replace with your MySQL password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $pickLocation = $_POST['Picklocation'];
    $dropLocation = $_POST['Droplocation'];
    $pickupDate = $_POST['pickupDate'];
    $pickupTime = $_POST['pickupTime'];
    $carModel = $_POST['carModel'];
    $carName = $_POST['carName'];
    $numOfPeople = $_POST['numOfPeople'];
    $driveType = $_POST['driveType'];  // 'selfDrive' or 'driverDrive'

    // Initialize variables for the new fields
    $drivingLicense = NULL;

    // Handle 'Self Drive' case for driving license
    if ($driveType == 'selfDrive' && isset($_FILES['drivingLicense']) && $_FILES['drivingLicense']['error'] == 0) {
        $drivingLicense = $_FILES['drivingLicense']['name'];
        // Move the uploaded file to a directory (optional)
        move_uploaded_file($_FILES['drivingLicense']['tmp_name'], 'uploads/' . $drivingLicense);
    }

    // Prepare the SQL query to insert the booking details
    $sql = "INSERT INTO booking (pick_location, drop_location, pickup_date, pickup_time, car_model, car_name, num_of_people, drive_type, driving_license)
            VALUES ('$pickLocation', '$dropLocation', '$pickupDate', '$pickupTime', '$carModel', '$carName', '$numOfPeople', '$driveType', '$drivingLicense')";

    // Execute the query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        // Success: Show pop-up message and redirect
        echo "Booking details inserted successfully.";
    } else {
        // Error: Show pop-up with error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?> -->
