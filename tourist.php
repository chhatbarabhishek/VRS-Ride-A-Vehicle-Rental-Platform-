<?php
   include('session.php');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourist Attractions in Gujarat - VRS Ride</title>
    <style>
       /* Reset some default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body and overall page style */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

.container {
    width: 80%;
    margin: 0 auto;
    max-width: 1200px;
    
}

/* Header Section */
.con {
    background-color: #273f44;
    color: white;
    padding: 50px 0;
    text-align: center;
}

.con h1 {
    font-size: 3em;
    margin-bottom: 10px;
}

.con p {
    font-size: 1.2em;
}

/* Tourist Attractions Section */
.tourist-attractions {
    padding: 40px 0;
    background-color: #fff;
}

.tourist-attractions h2 {
    font-size: 2.5em;
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

.attraction {
    display: flex;
    margin-bottom: 30px;
    border-bottom: 2px solid #ddd;
    padding-bottom: 20px;
}

.attraction img {
    width: 40%;
    height: auto;
    border-radius: 10px;
    margin-right: 20px;
}

.attraction-info {
    flex: 1;
}

.attraction-info h3 {
    font-size: 2em;
    margin-bottom: 10px;
}

.attraction-info p {
    font-size: 1.1em;
    margin-bottom: 20px;
}

.btn {
    background-color: #ffd700;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    font-size: 1em;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color:red;
}


footer {
    background-color: #273f44;
    color: white;
    padding: 20px 0;
    text-align: center;
    font-size: 14px;
  }

  .footer-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 0 20px;
    flex-wrap: wrap; /* Allows for wrapping on smaller screens */
  }

  /* Individual columns in the footer */
  .footer-column {
    flex: 1 1 22%; /* Each column takes up around 22% of the width */
    margin: 10px;
  }

  .footer-column h2, .footer-column h6 {
    font-family: 'Open Sans', sans-serif;
  }

  .footer-column .content1, .footer-column .content2 {
    font-size: 16px;
  }

  /* Styling for social media icons */
  .icons a {
    margin: 0 10px;
    color: white;
    text-decoration: none;
    font-size: 24px;
  }

  .icons a:hover {
    color: #F0c540;
  }

  /* Payment image styling */
  .footer-column img {
    width: 100%;
    max-width: 100%;
  }

  /* Footer bottom section */
  .footer2 {
    text-align: center;
    padding: 10px;
    font-family: 'Open Sans', sans-serif;
  }


/* Modal Styles */
.modal {
  display: none; /* Hidden by default */
  position: fixed;
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scrolling if needed */
  background-color: rgb(0, 0, 0); /* Fallback color */
  background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}

.modal-content {
  background-color: white;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 40%; /* Could be more or less, depending on screen size */
}

.close-btn {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close-btn:hover,
.close-btn:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

/* Form Styling */
form {
  display: flex;
  flex-direction: column;
}

form label {
  margin-top: 10px;
}

form input, form textarea {
  padding: 8px;
  margin: 5px 0;
}

form button {
  padding: 10px;
  background-color: #4CAF50;
  color: white;
  border: none;
  cursor: pointer;
}

form button:hover {
  background-color: #45a049;
}


/* General body setup */
body {
    font-family: 'Open Sans', sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}




/* Navbar container */
.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    background: #23393d;
    color: white;
    padding: 25px 50px;
    z-index: 1000;
}

/* Navbar brand title */
.navbar-brand {
    font-size: 28px;
    font-weight: bold;
    color: #F0c540;
    text-decoration: none;
}

/* Nav list container */
.nav-list {
    display: flex;
    list-style: none;
    gap: 40px; /* better spacing */
    margin: 0;
    padding: 0;
    flex-wrap: wrap;
}

/* Individual nav item */
.nav-item {
    position: relative;
}

/* Nav links */
.nav-link {
    color: white;
    font-size: 18px;
    text-decoration: none;
    transition: color 0.3s ease-in-out;
}

/* Hover effect for nav links */
.nav-link:hover {
    color: #ffd700;
}

/* Welcome user text */
.nav-item span.nav-link {
    font-weight: bold;
    font-size: 25px;
    color: #ffd700;
    line-height: 1.2;
    padding-left: 5px;
}

/* Dropdown content */
.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background-color: #ffffff;
    border: 1px solid #23393d;
    display: none;
    flex-direction: column;
    min-width: 140px;
}

/* Show dropdown on hover */
.nav-item.dropdown:hover .dropdown-menu {
    display: flex;
}

/* Dropdown items */
.dropdown-item {
    color: #23393d;
    background-color: #ffffff;
    padding: 10px 20px;
    font-size: 10px;
    text-decoration: none;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background-color: #23393d;
    color: #ffffff;
}

</style>
</head>
<body>
 <nav class="navbar">
  <a class="navbar-brand" href="#" style="color: #F0c540; font-size: 28px; font-weight: bold;">VRS Ride</a>
  
  <ul class="nav-list">
      <li class="nav-item"><a class="nav-link" href="index1.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="book.php">Book Now</a></li>
      <li class="nav-item"><a class="nav-link" href="index1.php#abo">About Us</a></li>
      <li class="nav-item"><a class="nav-link" href="#con">Contact Us</a></li>
      <li class="nav-item"><a class="nav-link" href="tourist.php">Tourist</a></li>
      <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
        Your Bookings
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #ffffff; border: 1px solid #23393d;">
        <a class="dropdown-item" href="car_bookings.php" 
           style="color: #23393d; background-color: #ffffff; padding: 10px 20px; font-size: 16px; border-bottom: 1px solid #f0f0f0;"
           onmouseover="this.style.backgroundColor='#23393d'; this.style.color='#ffffff';"
           onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#23393d';">
            Car Bookings
        </a>
        <a class="dropdown-item" href="tourist_bookings.php" 
           style="color: #23393d; background-color: #ffffff; padding: 10px 20px; font-size: 16px; border-bottom: 1px solid #f0f0f0;"
           onmouseover="this.style.backgroundColor='#23393d'; this.style.color='#ffffff';"
           onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#23393d';">
            Trip Bookings
        </a>
    </div>
</li>

      <li class="nav-item"><a href = "signout.php">Sign Out</a></li>
      
  </ul>
</nav>
    <!-- <header> -->
        <div class="con">
            <h1>Explore Gujarat: Tourist Attractions</h1>
            <p>Discover the beauty and culture of Gujarat with VRS Ride. Book your car rental today!</p>
        </div>
    <!-- </header> -->

    <section class="tourist-attractions">
        <div class="container">
            <h2>Top Tourist Destinations</h2>

           <!-- Modal (Booking Form) -->
<!-- Modal (Booking Form) -->
<div id="bookingModal" class="modal" style="display: none;">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2>Book Your Trip to <span id="trip-name"></span></h2>
    <form id="bookingForm" action="submit_booking.php" method="POST">
      <input type="hidden" id="trip-name-input" name="trip_name">
      
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" required>

      <label for="phone">Phone Number</label>
      <input type="text" id="phone" name="phone" required>

      <label for="date">Travel Date</label>
      <input type="date" id="date" name="date" required>

      <!-- Replacing Additional Comments with Pick Up Time -->
      <label for="pickup-time">Pick Up Time</label>
      <input type="time" id="pickup-time" name="pickup_time" required>

      <button type="submit" class="btn">Submit Booking</button>
    </form>
  </div>
</div>

<!-- Add similar structures for other attractions (Somnath, Dwarka, Statue of Unity) -->


<!-- Attractions Section -->
<div class="attraction">
  <img src="images/sasan-gir.jpg" alt="Sasan Gir">
  <div class="attraction-info">
    <h3>Sasan Gir</h3>
    <p>Visit the famous Gir National Park, home to the Asiatic lion. Enjoy a safari through the park and explore its rich wildlife.</p>
    <a href="javascript:void(0)" class="btn" onclick="openModal('Sasan Gir')">Book Now</a>
  </div>
</div>

<div class="attraction">
  <img src="images/R.jpg" alt="Somnath">
  <div class="attraction-info">
    <h3>Somnath</h3>
    <p>Explore the Somnath Temple, one of the 12 Jyotirlingas, and the serene beaches of Somnath.</p>
    <a href="javascript:void(0)" class="btn" onclick="openModal('Somnath')">Book Now</a>
  </div>
</div>

<div class="attraction">
  <img src="images/OIP.jpg" alt="Dwarka">
  <div class="attraction-info">
    <h3>Dwarka</h3>
    <p>Visit the Dwarkadhish Temple and take a boat ride to Bet Dwarka, the ancient city of Lord Krishna.</p>
    <a href="javascript:void(0)" class="btn" onclick="openModal('Dwarka')">Book Now</a>
  </div>
</div>

<div class="attraction">
  <img src="images/Statue-of-unity.jpg" alt="Statue of Unity">
  <div class="attraction-info">
    <h3>Statue of Unity</h3>
    <p>Marvel at the world's tallest statue and visit the surrounding attractions such as the Sardar Sarovar Dam and the Jungle Safari.</p>
    <a href="javascript:void(0)" class="btn" onclick="openModal('Statue of Unity')">Book Now</a>
  </div>
</div>




    <?php include("footer.php"); ?>
    <script>
      // Open the modal and populate the trip name


function openModal(tripName) {
    document.getElementById('trip-name').innerText = tripName;
    document.getElementById('trip-name-input').value = tripName;
    document.getElementById('bookingModal').style.display = "block";
  }

  // Close the modal
  function closeModal() {
    document.getElementById('bookingModal').style.display = "none";
  }

  // Close the modal if the user clicks outside of the modal content
  window.onclick = function(event) {
    if (event.target == document.getElementById('bookingModal')) {
      closeModal();
    }
  }

    </script>
    <script src="assets\Js\jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>