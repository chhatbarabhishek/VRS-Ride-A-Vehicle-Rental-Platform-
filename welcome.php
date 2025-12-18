<?php
   include('session.php');
?>
<html>
<head>
   <title>Welcome </title>
  <style>
    
    
    body {
        font-family: 'Open Sans', sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
      }
    
    .navbar {
        display: flex;
        position: sticky;
        align-items: center;
        justify-content: space-between;
        top: 0px;
        background: #23393d;
        background-blend-mode: darken;
        background-size: cover;
        color: white;
        padding: 10px 20px;
        z-index: 1;
    }

    
    .nav-list {
        display: flex;
        list-style: none;
    }
    
    .nav-list li {
        margin-right: -10px;
    }
    
    .nav-list li:last-child {
        margin-right: 0;
    }
    
    .nav-list li a {
        text-decoration: none;
        color: white;
        font-size: 18px;
        transition: color 0.3s ease-in-out;
    }
    
    .nav-list li a:hover {
        color: #23393d;
    }
        /* Change the color on hover */
    
    .rightNav {
        text-align: right;
    }
    
    #search {
        padding: 8px;
        font-size: 16px;
        border: 2px solid #fff;
        border-radius: 5px;
    }
    
    .btn {
        background-color: #ffd700;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }
    
    
    .nav-link{
      margin-right: 10px;
      color: #fff !important;
    }

    /* Form */
    .bg-image {
        background-image: url('https://mycar-rental-website.netlify.app/static/media/main-car.9b30faa59387879fa060.png');
        background-size: 800px;
        background-position: left;
        background-repeat: no-repeat;
        height: 600px;
        display: flex;
        justify-content: right;
        align-items: center;
        
      }
      .login-container {
        background: rgba(255, 255, 255, 0.8);
        padding: 30px;
        width: 300px;
        border-radius: 8px;
      }
      .login-container h1 {
        text-align: center;
      }
      input[type="text"], input[type="password"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 4px;
        border: 1px solid #ccc;
      }
      

      /* Modal background */
      .modal {
        display: none;  /* Hidden by default */
        position: fixed;  /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4); /* Black with opacity */
      }

      /* Modal content */
      .modal-content {
        background-color: #fefefe;
        margin: 15% auto;  /* Centered vertically and horizontally */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;  /* Adjust the width */
        max-width: 400px; /* Max width for smaller screens */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      }

      /* Close button */
      .close-btn {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 25px;
      }

      .close-btn:hover,
      .close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
      }


      .btn:hover {
        opacity: 1;
        background-color: #d00000;
        /* Change the background color on hover */
        color: #ffd700;
      }
      .bg-img {
        background-image: url(https://mycar-rental-website.netlify.app/static/media/main-car.9b30faa59387879fa060.png);
        background-size: 700px;
        background-repeat: no-repeat;  /* Prevents repeating */
         /* Center the image */
        height: 400px;
        left:60px;
      }


      nav {
            background-color: #333;
            overflow: hidden;
        }
        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        nav .dropdown {
            float: left;
            overflow: hidden;
        }
        nav .dropdown .dropbtn {
            font-size: 16px;
            border: none;
            outline: none;
            color: white;
            padding: 14px 16px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
            cursor: pointer;
        }
        nav a:hover, nav .dropdown:hover .dropbtn {
            background-color: #575757;
        }
        nav .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        nav .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }
        nav .dropdown-content a:hover {
            background-color: #ddd;
        }
        nav .dropdown:hover .dropdown-content {
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
    <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #ffffff; border: 2px solid #23393d;">
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

<!-- Login Form (Initially hidden) -->
<div class="modal" id="loginModal" style="display: none;">
  <div class="modal-content">
      <span class="close-btn" id="closeBtn">&times;</span>
      <h1>Login</h1>
      <form action="" method="post">
          <input type="text" placeholder="Enter Email" name="email" required>
          <input type="password" placeholder="Enter Password" name="pass" required>
          <button type="submit" class="btn" name="login">Login</button>
      </form>
      <br/>
      <h5>Don't you have Account? <a href="#" id="registerLink1">Sign Up</a> here.</h5>
  </div>
</div>

  <!-- Register Modal -->
<div class="modal" id="registerModal" style="display: none;">
  <div class="modal-content">
      <span class="close-btn" id="closeRegisterBtn">&times;</span>
      <h1>Register</h1>  <!-- Changed from Sign Up to Register -->
      <form action="register.php" method="post">
          <input type="text" placeholder="Enter Name" name="name" required>
          <input type="text" placeholder="Enter Email" name="email" required>
          <input type="password" placeholder="Enter Password" name="password" required>
          <input type="text" placeholder="Enter Phone Number" name="phone" required>
          <button type="submit" class="btn">Register</button>  <!-- Changed from Sign Up to Register -->
      </form>
      <br/>
      <h5>If you have already Register then <a href="#" id="call1">LogIn</a></h5>
  </div>
</div>

<script src="assets\Js\jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script>
      // Get the modal
      const modal = document.getElementById("loginModal");
      
      // Get the button that opens the modal
      const loginLink = document.getElementById("call");
      const loginLink1 = document.getElementById("call1");
      
      // Get the <span> element that closes the modal
      const closeBtn = document.getElementById("closeBtn");
    
      // When the user clicks on the login link, open the modal
      loginLink.addEventListener("click", function(e) {
        e.preventDefault();  // Prevent default anchor action
        modal.style.display = "block";  // Show the modal
        registerModal.style.display = "none";
      });

      loginLink1.addEventListener("click", function(e) {
        e.preventDefault();  // Prevent default anchor action
        modal.style.display = "block";  // Show the modal
        registerModal.style.display = "none";
      });
    
      // When the user clicks on <span> (x), close the modal
      closeBtn.addEventListener("click", function() {
        modal.style.display = "none";  // Hide the modal
      });
    
      // When the user clicks anywhere outside the modal, close it
      window.addEventListener("click", function(event) {
        if (event.target === modal) {
          modal.style.display = "none";  // Hide the modal
        }
      });
    
      // Get the modal
      const registerModal = document.getElementById("registerModal");
      
      // Get the button that opens the modal
      const registerLink = document.getElementById("registerLink");  // Changed to registerLink
      const registerLink1 = document.getElementById("registerLink1");
      
      // Get the <span> element that closes the modal
      const closeRegisterBtn = document.getElementById("closeRegisterBtn");  // Changed to closeRegisterBtn
      
      // When the user clicks on the register link, open the modal
      registerLink.addEventListener("click", function(e) {
        
        e.preventDefault();  // Prevent default anchor action
        registerModal.style.display = "block";  // Show the modal
        modal.style.display = "none";
      });

      registerLink1.addEventListener("click", function(e) {
        e.preventDefault();  // Prevent default anchor action
        registerModal.style.display = "block";  // Show the modal
        modal.style.display = "none";
        
      });

      // When the user clicks on <span> (x), close the modal
      closeRegisterBtn.addEventListener("click", function() {
        registerModal.style.display = "none";  // Hide the modal
      });

      // When the user clicks anywhere outside the modal, close it
      window.addEventListener("click", function(event) {
        if (event.target === registerModal) {
          registerModal.style.display = "none";  // Hide the modal
        }
      });
    
</script>

</body>
</html>