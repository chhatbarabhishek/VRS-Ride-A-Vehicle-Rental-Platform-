<?php
session_start();

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

$bookings = [];
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';

    if (!empty($email) && !empty($name)) {
        $sql = "SELECT * FROM bookings WHERE email = ? AND name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row;
            }
        } else {
            $error_message = "No bookings found for the provided email and name.";
        }
        $stmt->close();
    } else {
        $error_message = "Please enter both your email and name.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 20px;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        h2 {
            color: #e64e00;
            margin-bottom: 20px;
            text-align: center;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
        form {
            margin-bottom: 25px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            display: flex;
            gap: 15px;
            align-items: center;
        }
        form label {
            font-weight: bold;
        }
        form input[type="email"],
        form input[type="text"],
        form button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form button {
            background-color: #F0c540;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: #e64e00;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .edit-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9em;
        }
        .edit-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Bookings</h2>

        <form method="POST">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <button type="submit">View Bookings</button>
        </form>

        <?php if ($error_message): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if (!empty($bookings)): ?>
            <h3>Your Current Bookings:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Driving Type</th>
                        <th>Pick-up Location</th>
                        <th>Drop-off Location</th>
                        <th>Pick-up Date</th>
                        <th>Pick-up Time</th>
                        <th>Car Model</th>
                        <th>Car Name</th>
                        <th>Number of People</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo $booking['booking_id']; ?></td>
                            <td><?php echo $booking['drivingType']; ?></td>
                            <td><?php echo $booking['Picklocation']; ?></td>
                            <td><?php echo $booking['Droplocation']; ?></td>
                            <td><?php echo $booking['pickupDate']; ?></td>
                            <td><?php echo $booking['pickupTime']; ?></td>
                            <td><?php echo $booking['carModel']; ?></td>
                            <td><?php echo $booking['carName']; ?></td>
                            <td><?php echo $booking['numOfPeople']; ?></td>
                            <td>
                                <a href="edit_booking.php?id=<?php echo $booking['booking_id']; ?>" class="edit-button">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error_message)): ?>
            <p>No bookings found for the provided information.</p>
        <?php endif; ?>
    </div>
</body>
</html>