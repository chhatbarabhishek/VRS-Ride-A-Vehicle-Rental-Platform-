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
        die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
    }

    // --- Handle Update ---
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'update') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        // Check if the trip is completed
        $check_completed_sql = "SELECT trip_completed FROM bookings WHERE id = ?";
        $check_completed_stmt = $conn->prepare($check_completed_sql);
        $check_completed_stmt->bind_param("i", $id);
        $check_completed_stmt->execute();
        $check_completed_result = $check_completed_stmt->get_result();
        $completed_row = $check_completed_result->fetch_assoc();
        $check_completed_stmt->close();

        if ($completed_row && $completed_row['trip_completed']) {
            echo json_encode(['success' => false, 'message' => "Cannot update a completed trip."]);
        } else {
            $drivingType = mysqli_real_escape_string($conn, $_POST["drivingType"]);
            $Picklocation = mysqli_real_escape_string($conn, $_POST["Picklocation"]);
            $Droplocation = mysqli_real_escape_string($conn, $_POST["Droplocation"]);
            $pickupDate = mysqli_real_escape_string($conn, $_POST["pickupDate"]);
            $pickupTime = mysqli_real_escape_string($conn, $_POST["pickupTime"]);
            $carModel = mysqli_real_escape_string($conn, $_POST["carModel"]);
            $carName = mysqli_real_escape_string($conn, $_POST["carName"]);
            $numOfPeople = mysqli_real_escape_string($conn, $_POST["numOfPeople"]);

            if ($id > 0) {
                $sql = "UPDATE bookings SET
                            drivingType = ?,
                            Picklocation = ?,
                            Droplocation = ?,
                            pickupDate = ?,
                            pickupTime = ?,
                            carModel = ?,
                            carName = ?,
                            numOfPeople = ?
                            WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssssi", $drivingType, $Picklocation, $Droplocation, $pickupDate, $pickupTime, $carModel, $carName, $numOfPeople, $id);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => "Booking updated successfully."]);
                } else {
                    echo json_encode(['success' => false, 'message' => "Error updating booking: " . $stmt->error]);
                }
                $stmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => "Invalid booking ID for update."]);
            }
        }
        exit();
    }

    // --- Handle Delete ---
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        // Check if the trip is completed
        $check_completed_sql = "SELECT trip_completed FROM bookings WHERE id = ?";
        $check_completed_stmt = $conn->prepare($check_completed_sql);
        $check_completed_stmt->bind_param("i", $id);
        $check_completed_stmt->execute();
        $check_completed_result = $check_completed_stmt->get_result();
        $completed_row = $check_completed_result->fetch_assoc();
        $check_completed_stmt->close();

        if ($completed_row && $completed_row['trip_completed']) {
            echo json_encode(['success' => false, 'message' => "Cannot delete a completed trip."]);
        } else {
            if ($id > 0) {
                $sql = "DELETE FROM bookings WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => "Booking deleted successfully."]);
                } else {
                    echo json_encode(['success' => false, 'message' => "Error deleting booking: " . $stmt->error]);
                }
                $stmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => "Invalid booking ID."]);
            }
        }
        exit();
    }

    // --- Handle Display Edit Form ---
    $booking = null;
    $error_message = "";
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            $sql = "SELECT * FROM bookings WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $booking = $result->fetch_assoc();
            } else {
                $error_message = "Booking not found.";
            }
            $stmt->close();
        } else {
            $error_message = "Invalid booking ID.";
        }
    }

    $conn->close();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo isset($booking) ? 'Edit Booking' : 'Manage Bookings'; ?></title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Poppins', sans-serif; background-color: #f4f4f4; color: #333; margin: 20px; }
            .container { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 600px; margin: 0 auto; }
            h2 { color: #e64e00; margin-bottom: 20px; text-align: center; }
            .error-message { color: red; margin-bottom: 15px; text-align: center; }
            form label { display: block; margin-bottom: 8px; font-weight: bold; }
            form input[type="text"], form input[type="date"], form input[type="time"], form input[type="number"], form select { width: calc(100% - 20px); padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
            button[type="submit"], .back-button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 1em; text-decoration: none; display: inline-block; margin-top: 10px; margin-right: 10px; }
            button[type="submit"]:hover, .back-button:hover { background-color: #0056b3; }
        </style>
    </head>
    <body>
        <div class="container">
            <?php if (isset($booking)): ?>
                <h2>Edit Booking</h2>
                <?php if ($error_message): ?>
                    <p class="error-message"><?php echo $error_message; ?></p>
                    <a href="car_bookings.php" class="back-button">Back to Bookings</a>
                <?php else: ?>
                    <form id="bookingForm" method="POST" action="manage_bookings.php">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">

                        <label for="drivingType">Driving Type:</label>
                        <select id="drivingType" name="drivingType" required>
                            <option value="driver" <?php if ($booking['drivingType'] === 'driver') echo 'selected'; ?>>Driver Drive</option>
                            <option value="self" <?php if ($booking['drivingType'] === 'self') echo 'selected'; ?>>Self Drive</option>
                        </select><br/>

                        <label for="Picklocation">Pick-up Location:</label>
                        <input type="text" id="Picklocation" name="Picklocation" value="<?php echo $booking['Picklocation']; ?>" required><br/>

                        <label for="Droplocation">Drop Location:</label>
                        <input type="text" id="Droplocation" name="Droplocation" value="<?php echo $booking['Droplocation']; ?>" required><br/>

                        <label for="pickupDate">Pickup Date:</label>
                        <input type="date" id="pickupDate" name="pickupDate" value="<?php echo $booking['pickupDate']; ?>" required><br/>

                        <label for="pickupTime">Pickup Time:</label>
                        <input type="time" id="pickupTime" name="pickupTime" value="<?php echo $booking['pickupTime']; ?>" required><br/>

                        <label for="carModel">Car Model:</label>
                        <input type="text" id="carModel" name="carModel" value="<?php echo $booking['carModel']; ?>" required><br/>

                        <label for="carName">Car Name:</label>
                        <input type="text" id="carName" name="carName" value="<?php echo $booking['carName']; ?>" required><br/>

                        <label for="numOfPeople">Number of People:</label>
                        <input type="number" id="numOfPeople" name="numOfPeople" min="1" value="<?php echo $booking['numOfPeople']; ?>" required><br/>

                        <button type="submit">Update Booking</button>
                        <a href="car_bookings.php" class="back-button">Back to Bookings</a>
                    </form>
                <?php endif; ?>
            <?php else: ?>
                <h2>Manage Bookings</h2>
                <p>No action requested.</p>
                <a href="car_bookings.php" class="back-button">Back to Bookings</a>
            <?php endif; ?>
        </div>
        <script>
                const form = document.getElementById('bookingForm');
                if (form) {
                    console.log('Form found, adding event listener.');
                    form.addEventListener('submit', function(event) {
                        console.log('Form submission intercepted.');
                        event.preventDefault();
                        const formData = new FormData(this);

                        fetch('manage_bookings.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('JSON response:', data);
                            if (data.success) {
                                alert(data.message);
                                window.location.reload();
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred.');
                        });
                    });
                } else {
                    console.log("Form not found");
                }

                // Delete button handling
                document.addEventListener('click', function(event) {
                    if (event.target.classList.contains('delete-button')) {
                        const id = event.target.getAttribute('data-id');
                        console.log("Delete button clicked, ID:", id); // Check click and ID
                        fetch('manage_bookings.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `action=delete&id=${id}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Delete response:", data); // Check response
                            alert(data.message);
                            if (data.success) {
                                window.location.reload();
                            }
                        });
                    }
                });
        </script>
    </body>
    </html>