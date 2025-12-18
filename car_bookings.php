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

// Set the timezone to Indian Standard Time (IST)
date_default_timezone_set('Asia/Kolkata');
$current_ist = date('Y-m-d H:i:s');

// Automatically mark trips as completed if their pickup time has passed
$update_sql = "UPDATE bookings
               SET trip_completed = TRUE
               WHERE trip_completed = FALSE
                 AND CONCAT(pickupDate, ' ', pickupTime) < ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("s", $current_ist);
$update_stmt->execute();
$update_stmt->close();

$bookings = [];
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';

    if (!empty($email) && !empty($name)) {
        $sql = "SELECT *, trip_completed FROM bookings WHERE email = ? AND name = ?"; // Select the new column
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
    <title>Your Car Bookings</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            max-width: 1100px;
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

        .action-buttons {
            display: flex;
            align-items: center; /* Vertically align items in the flex container */
            gap: 10px; /* Space between the buttons/links */
        }
        .action-buttons a, .action-buttons button {
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9em;
            cursor: pointer;
            display: inline-flex; /* Use inline-flex for icon alignment */
            align-items: center;
            gap: 5px; /* Space between icon and text */
        }
        .edit-button {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .edit-button:hover {
            background-color: #0056b3;
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
        .home-button {
            display: block; /* Make it a block-level element to take full width or adjust margin */
            background-color: #F0c540;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 1em;
            cursor: pointer;
            margin-top: 20px; /* Add some space above the button */
            text-align: center; /* Center the text within the button */
        }
        .home-button:hover {
            background-color: #1e7e34;
        }
        .trip-completed {
            font-weight: bold;
            color: green;
        }
        .trip-not-completed {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Car Bookings</h2>

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
                        <th>Pick-up</th>
                        <th>Drop-off</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Car Model</th>
                        <th>Car Name</th>
                        <th>People</th>
                        <th>Trip Status</th> <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo $booking['id']; ?></td>
                            <td><?php echo $booking['drivingType']; ?></td>
                            <td><?php echo $booking['Picklocation']; ?></td>
                            <td><?php echo $booking['Droplocation']; ?></td>
                            <td><?php echo $booking['pickupDate']; ?></td>
                            <td><?php echo $booking['pickupTime']; ?></td>
                            <td><?php echo $booking['carModel']; ?></td>
                            <td><?php echo $booking['carName']; ?></td>
                            <td><?php echo $booking['numOfPeople']; ?></td>
                            <td>
                                <?php
                                if ($booking['trip_completed'] == 1) {
                                    echo '<span class="trip-completed">Completed</span>';
                                } else {
                                    echo '<span class="trip-not-completed">Not Completed</span>';
                                }
                                ?>
                            </td>
                            <td class="action-buttons">
                                <a href="manage_bookings.php?action=edit&id=<?php echo $booking['id']; ?>" class="edit-button"><i class="fas fa-edit"></i> Edit</a>
                                <form method="POST" action="manage_bookings.php" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">
                                    <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this booking?')"><i class="fas fa-trash-alt"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error_message)): ?>
            <p>No bookings found for the provided information.</p>
        <?php endif; ?>

        <a href="index1.php" class="home-button">Go to Home Page</a>
    </div>
</body>
</html>