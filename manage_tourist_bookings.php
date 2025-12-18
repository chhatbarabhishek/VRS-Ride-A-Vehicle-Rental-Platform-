<?php
session_start();

// DB credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vrsride";

// DB connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] === 'update') {
    $id = intval($_POST['id']);
    
    // Check if the trip is completed based on pickup_time
    $check = $conn->prepare("SELECT trip_completed, pickup_time FROM trip_registration WHERE id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result()->fetch_assoc();
    $check->close();

    // If the trip is completed or pickup time has passed
    if ($result && $result['trip_completed'] || strtotime($result['pickup_time']) < time()) {
        echo json_encode(['success' => false, 'message' => 'Cannot update completed or past trip']);
        exit;
    }

    // Update trip details
    $stmt = $conn->prepare("UPDATE trip_registration SET trip_name=?, name=?, email=?, phone=?, date=?, pickup_time=? WHERE id=?");
    $stmt->bind_param("ssssssi", $_POST['trip_name'], $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['date'], $_POST['pickup_time'], $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Booking updated']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed']);
    }
    $stmt->close();
    exit;
}

// Handle delete
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] === 'delete') {
    $id = intval($_POST['id']);
    
    // Check if the trip is completed based on pickup_time
    $check = $conn->prepare("SELECT trip_completed, pickup_time FROM trip_registration WHERE id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result()->fetch_assoc();
    $check->close();

    // If the trip is completed or pickup time has passed
    if ($result && $result['trip_completed'] || strtotime($result['pickup_time']) < time()) {
        echo json_encode(['success' => false, 'message' => 'Cannot delete completed or past trip']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM trip_registration WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Booking deleted']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Delete failed']);
    }
    $stmt->close();
    exit;
}

// Handle fetch
$booking = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM trip_registration WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
    $stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Manage Tourist Bookings</title>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 20px; }
        .container { background: white; padding: 25px; max-width: 600px; margin: auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, button { padding: 10px; width: 100%; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #007bff; color: white; cursor: pointer; }
        button:hover { background: #0056b3; }
        .delete-btn { background: red; }
    </style>
</head>
<body>
<div class="container">
    <h2><?php echo $booking ? "Edit Booking" : "No Booking Found"; ?></h2>

    <?php if ($booking): ?>
    <form id="bookingForm">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">

        <label>Trip Name:</label>
        <input type="text" name="trip_name" value="<?php echo $booking['trip_name']; ?>" required>

        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $booking['name']; ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $booking['email']; ?>" required>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo $booking['phone']; ?>" required>

        <label>Date:</label>
        <input type="date" name="date" value="<?php echo $booking['date']; ?>" required>

        <label>Pickup Time:</label>
        <input type="time" name="pickup_time" value="<?php echo $booking['pickup_time']; ?>" required>

        <button type="submit">Update Booking</button>
        <button type="button" class="delete-btn" onclick="deleteBooking(<?php echo $booking['id']; ?>)">Delete Booking</button>
    </form>
    <?php else: ?>
        <p>Booking not found.</p>
    <?php endif; ?>
</div>

<script>
document.getElementById("bookingForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch("manage_tourist_bookings.php", {
        method: "POST",
        body: formData
    }).then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) location.reload();
    }).catch(err => {
        alert("An error occurred.");
        console.error(err);
    });
});

function deleteBooking(id) {
    if (confirm("Are you sure you want to delete this booking?")) {
        fetch("manage_tourist_bookings.php", {
            method: "POST",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=delete&id=${id}`
        }).then(res => res.json())
        .then(data => {
            alert(data.message);
            if (data.success) window.location.href = "tourist_bookings.php";
        });
    }
}
</script>
</body>
</html>
