<?php
// db_connection.php
$db = mysqli_connect("localhost", "root", "", "vrsride");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
