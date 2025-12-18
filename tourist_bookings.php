<?php
session_start();

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

$bookings = [];
$completed_bookings = [];
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';

    if (!empty($email) && !empty($name)) {
        $sql = "SELECT * FROM trip_registration WHERE email = ? AND name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['trip_completed'] == 1) {
                    $completed_bookings[] = $row;
                } else {
                    $bookings[] = $row;
                }
            }
            if (empty($bookings) && empty($completed_bookings)) {
                $error_message = "No tourist bookings found for the provided email and name.";
            }

        } else {
            $error_message = "No tourist bookings found for the provided email and name.";
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
    <title>Your Tourist Bookings</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* ... (Your existing styles) ... */
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
            align-items: center;
            gap: 10px;
        }
        .action-buttons a, .action-buttons button {
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9em;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
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
            display: block;
            background-color: #F0c540;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 1em;
            cursor: pointer;
            margin-top: 20px;
            text-align: center;
        }
        .home-button:hover {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Tourist Bookings</h2>

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
            <h3>Your Current Tourist Bookings:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Tourist Spot</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Travel Date</th>
                        <th>Pick Up Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo $booking['id']; ?></td>
                            <td><?php echo $booking['trip_name']; ?></td>
                            <td><?php echo $booking['name']; ?></td>
                            <td><?php echo $booking['email']; ?></td>
                            <td><?php echo $booking['phone']; ?></td>
                            <td><?php echo $booking['date']; ?></td>
                            <td><?php echo $booking['pickup_time']; ?></td>
                            <td><?php echo ($booking['trip_completed'] == 1) ? 'Completed' : 'Not Completed'; ?></td>
                            <td class="action-buttons">
                                <a href="manage_tourist_bookings.php?action=edit&id=<?php echo $booking['id']; ?>" class="edit-button"><i class="fas fa-edit"></i> Edit</a>
                                <form method="POST" action="manage_tourist_bookings.php" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">
                                    <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this tourist booking?')"><i class="fas fa-trash-alt"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if (!empty($completed_bookings)): ?>
            <h3>Your Completed Tourist Bookings:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Tourist Spot</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Travel Date</th>
                        <th>Pick Up Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($completed_bookings as $booking): ?>
                        <tr>
                            <td><?php echo $booking['id']; ?></td>
                            <td><?php echo $booking['trip_name']; ?></td>
                            <td><?php echo $booking['name']; ?></td>
                            <td><?php echo $booking['email']; ?></td>
                            <td><?php echo $booking['phone']; ?></td>
                            <td><?php echo $booking['date']; ?></td>
                            <td><?php echo $booking['pickup_time']; ?></td>
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
                                <a href="manage_tourist_bookings.php?action=edit&id=<?php echo $booking['id']; ?>" class="edit-button"><i class="fas fa-edit"></i> Edit</a>
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
        <?php endif; ?>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error_message) && empty($bookings) && empty($completed_bookings)): ?>
            <p>No tourist bookings found for the provided information.</p>
        <?php endif; ?>

        <a href="index1.php" class="home-button">Go to Home Page</a>
    </div>
</body>
</html>