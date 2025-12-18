<?php
session_start();
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the posted data
    $amount = $_POST['amount'];
    $car_name = $_POST['car_name'];
    $card_number = preg_replace('/\s+/', '', $_POST['card_number']); // Remove spaces
    $card_expiry = $_POST['card_expiry'];
    $card_cvc = $_POST['card_cvc'];

    // Basic server-side validation (add more robust checks)
    $errors = [];
    if (!preg_match('/^[0-9]{16}$/', $card_number)) {
        $errors[] = "Invalid card number (must be 16 digits).";
    }
    if (!preg_match('/^(0[1-9]|1[0-2])\/[0-9]{2}$/', $card_expiry)) {
        $errors[] = "Invalid expiry date (MM/YY format).";
    }
    if (!preg_match('/^[0-9]{3,4}$/', $card_cvc)) {
        $errors[] = "Invalid CVC (must be 3 or 4 digits).";
    }

    if (!empty($errors)) {
        echo "<script type='text/javascript'>";
        foreach ($errors as $error) {
            echo "alert('$error');";
        }
        echo "window.history.back();"; // Go back to the payment form
        echo "</script>";
        exit();
    }

    // Simulate payment success
    $payment_status = 'success'; // In real-world, you should integrate with a payment gateway

    // Store the payment details in the database
    if ($payment_status == 'success') {
        $stmt = $conn->prepare("INSERT INTO payments (car_name, amount, card_number, card_expiry, card_cvc, payment_status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $car_name, $amount, $card_number, $card_expiry, $card_cvc, $payment_status);

        if ($stmt->execute()) {
            // Success: Show popup and redirect
            echo "<script type='text/javascript'>
                    alert('Payment of ₹$amount for the car $car_name was processed successfully. Thank you!');
                    window.location.href = 'book.php';  // Redirect to the book.php page
                  </script>";
        } else {
            // Error: Show error message
            echo "<script type='text/javascript'>
                    alert('Error in processing payment. Please try again.');
                  </script>";
        }

        $stmt->close();
    }
    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Use min-height for better responsiveness */
            margin: 0;
        }
        .payment-container {
            background: #fff;
            padding: 40px;
            width: 90%; /* Adjust width for smaller screens */
            max-width: 450px; /* Maximum width */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        .payment-container h2 {
            font-size: 28px; /* Adjust font size */
            color: #e64e00;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px; /* Increase spacing */
            text-align: left; /* Align labels to the left */
        }
        .payment-container label {
            font-weight: bold;
            margin-bottom: 8px; /* Increase spacing */
            display: block;
            color: #333; /* Darker label color */
        }
        .payment-container input[type="number"],
        .payment-container input[type="text"],
        .payment-container select {
            width: calc(100% - 22px); /* Adjust width for padding and border */
            padding: 12px; /* Slightly reduce padding */
            margin-bottom: 15px; /* Increase spacing */
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
        }
        .payment-container button {
            background-color: #F0c540;
            color: #fff;
            padding: 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .payment-container button:hover {
            background-color: #e64e00;
        }
        .payment-container select {
            appearance: none; /* Remove default arrow */
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg fill="%23333" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
        }
        /* Responsive adjustments */
        @media (max-width: 600px) {
            .payment-container {
                padding: 30px;
            }
            .payment-container h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h2 style="color:#e64e00;font-size:28px;">Secure Payment</h2>

        <form method="POST" action="selfdrive_payments.php" id="paymentForm">
            <div class="form-group">
                <label for="car_name">Select Car:</label>
                <select name="car_name" id="car_name" onchange="updateAmount()" required>
                    <option value="Breeza" data-price="1000">Breeza - ₹1000/day</option>
                    <option value="Eco Sports" data-price="800">Eco Sports - ₹800/day</option>
                    <option value="i20" data-price="500">i20 - ₹500/day</option>
                    <option value="Swift" data-price="500">Swift - ₹500/day</option>
                    <option value="Mahindra Scorpio" data-price="3000">Mahindra Scorpio - ₹3000/day</option>
                    <option value="Tata Hexa" data-price="3500">Tata Hexa - ₹3500/day</option>
                    <option value="Tata Tiago" data-price="600">Tata Tiago - ₹600/day</option>
                    <option value="Baleno" data-price="500">Baleno - ₹500/day</option>
                    <option value="Hyundai Creta" data-price="1500">Hyundai Creta - ₹1500/day</option>
                    <option value="Tata Manza" data-price="500">Tata Manza - ₹500/day</option>
                    <option value="Skoda Superb" data-price="1200">Skoda Superb - ₹1200/day</option>
                </select>
            </div>

            <div class="form-group">
                <label for="amount">Amount (₹):</label>
                <input type="number" id="amount" name="amount" value="1000" required readonly>
            </div>

            <div class="form-group">
                <label for="card_number">Card Number:</label>
                <input type="text" id="card_number" name="card_number" placeholder="Enter 16-digit card number" pattern="[0-9]{16}" required>
            </div>

            <div class="form-group">
                <label for="expiry">Expiry Date (MM/YY):</label>
                <input type="text" id="expiry" name="card_expiry" placeholder="MM/YY" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" required>
            </div>

            <div class="form-group">
                <label for="cvc">CVC:</label>
                <input type="text" id="cvc" name="card_cvc" placeholder="Enter 3 or 4 digit CVC" pattern="[0-9]{3,4}" required>
            </div>

            <button type="submit">Pay Now</button>
        </form>
    </div>

    <script>
        // Update the amount based on the selected car
        function updateAmount() {
            var selectElement = document.getElementById("car_name");
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var price = selectedOption.getAttribute("data-price");
            document.getElementById("amount").value = price;
        }

        // Block back button initially and handle onpopstate
        history.pushState(null, null, location.href);

        window.onpopstate = function (event) {
            // Display a confirmation message
            if (!confirm("Your payment is not completed. Are you sure you want to leave this page?")) {
                // If the user clicks "Cancel", push the current state back to prevent navigation
                history.pushState(null, null, location.href);
            } else {
                // If the user clicks "OK", allow the back navigation
                // You might want to implement additional logic here, such as:
                // - Clearing any temporary payment session data.
                // - Logging that the user abandoned the payment.
            }
        };

        // Prevent leaving the page using other methods (like closing tab/window)
        window.onbeforeunload = function() {
            return "Your payment is not completed. Are you sure you want to leave this page?";
        };
    </script>
</body>
</html>