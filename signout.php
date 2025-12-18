<?php
    session_start();

    if(session_destroy()) {
        echo '<script>alert("Logout successful"); window.location.href = "index1.php";</script>';
    } else {
        echo '<script>alert("Logout failed");</script>';
        // Optionally redirect to an error page
        // header("Location: error.php");
    }
?>