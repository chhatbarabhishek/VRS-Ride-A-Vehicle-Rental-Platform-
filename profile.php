<?php
session_start();
// Assuming you are storing user details in the session after login
if (!isset($_SESSION['login_user'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$userName = $_SESSION['login_user']; // For example, you can fetch the name from the session
$userEmail = $_SESSION['email']; // Assuming you store the email in the session as well
$userPhone = $_SESSION['phone']; // Store phone number in session as well
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="profile-container">
    <h1>Welcome, <?php echo $userName; ?>!</h1>
    <p><strong>Email:</strong> <?php echo $userEmail; ?></p>
    <p><strong>Phone Number:</strong> <?php echo $userPhone; ?></p>

    <a href="edit_profile.php">Edit Profile</a>  <!-- If you want to allow users to edit their profile -->
</div>

</body>
</html>
