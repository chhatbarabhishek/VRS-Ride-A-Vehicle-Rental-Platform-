<?php
   include("Config.php");
   session_start();
   $error='';


   function loginUser($email, $password) {
      global $db;
      $myusername = mysqli_real_escape_string($db,$email);
      $mypassword = mysqli_real_escape_string($db,$password); 

      $sql = "SELECT * FROM Users WHERE Email = '$myusername' and Password = '$mypassword'";

      $result = mysqli_query($db,$sql);      
      $row = mysqli_num_rows($result);      
      $count = mysqli_num_rows($result);

      if($count == 1) {
      
         // session_register("myusername");
         $_SESSION['login_user'] = $myusername;
        //  $_SESSION['username'] = $result['username']; // Assuming $user['name'] contains the user's name
        echo '<script>alert("Login Successful ");</script>';
        //  header("location: index1.php");
      } else {
         $error = "Your Login Name or Password is invalid";
         echo '<script>alert("Login failed!   Invalid Password");</script>';
      }
   }

   function registerUser($username, $email, $password, $mobile) {
    global $db;
    $username = mysqli_real_escape_string($db,$username);
    $email = mysqli_real_escape_string($db,$email);
    $password = mysqli_real_escape_string($db,$password);
    $mobile = mysqli_real_escape_string($db,$mobile);

    // Check if email already exists
    $sql = "SELECT Email FROM Users WHERE Email = '$email'";
    $result = mysqli_query($db,$sql); 
    if (mysqli_num_rows($result) > 0) {
        return "Email ID already exists!";
    }

    $insertSql = "INSERT INTO Users (username, email, password, mobile) VALUES ('$username', '$email', '$password', '$mobile')";
    if (mysqli_query($db, $insertSql)) {
        return "Account created successfully!";
    } else {
        return "Error: " . mysqli_error($db);
    }

    // if ($count > 0) {
    //     $message = "Email ID already exists";
    //     $toastClass = "#007bff"; // Primary color
    // } else {
    //     // Prepare and bind
    //     $stmt = "INSERT INTO Users (username, email, password, mobile) VALUES ('$username', '$email', '$password', '$mobile')";

    //     if ($stmt->execute()) {
    //         $message = "Account created successfully";
    //         $toastClass = "#28a745"; // Success color
    //     } else {
    //         $message = "Error: " . $stmt->error;
    //         $toastClass = "#dc3545"; // Danger color
    //     }

    //     $stmt->close();
    // }

   }

  if($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (isset($_POST['register'])) {
      $username = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $mobile = $_POST['phone'];
      
      $message = registerUser($username, $email, $password, $mobile);
    } 

    if (isset($_POST['login'])) {
      $email = $_POST['email'];
      $password = $_POST['pass'];
      
      $message = loginUser($email, $password);
    }
    
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rent</title>
    
    <!-- Bootstrap and Font-Awesome for styles -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
      body {
        font-family: 'Open Sans', sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
      }
      

      /* About Section Images */
      .about-images {
          display: flex;
          justify-content: space-between; /* To place images side-by-side with space */
          gap: 20px; /* Space between images */
          padding: 20px;
      }

      .about-img {
          width: 48%; /* Adjust the size of the images */
          border: 3px solid #273f44; /* Border color */
          border-radius: 8px; /* Optional: Adds rounded corners */
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: Adds shadow to images */
          object-fit: cover;
          transition: transform 0.3s ease-in-out; /* Ensures images are contained without stretching */
      }

      /* Optional: Additional styling for the about section text */
      .about-txt {
          text-align: center;
          margin-top: 20px;
          font-size: larger;
          font-family:Verdana, Geneva, Tahoma, sans-serif;
      }
      .about-img:hover {
        transform: scale(1.1); /* Zoom effect when the user hovers */
      }
      .map-container {
            width: 100%;
            height: 400px;
            margin: 20px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        video {
      width: 100%; /* Set video width */ /* Max width for the video */
      margin: 20px 0; /* Space around the video */
    }

    .container {
      display: flex;
      flex-wrap: wrap; /* Ensures content wraps on small screens */
      align-items: center; /* Vertically align items to the center */
      justify-content: space-between; /* Space between the items */
      margin: 20px;
    }

    .bg-image {
      flex: 1.5; /* The image will take up the available space */
      margin-right: 20px; /* Space between the image and text */
    }

    .bg-image img {
      width: 100%; /* Make sure the image is responsive */
      max-width: 400px; /* Limit image size */
      height: auto; /* Maintain aspect ratio */
    }

    .text {
      font-weight:bold;
      flex: 0.7; /* Text will take twice the space as the image */
    }

    /* Optional: For responsiveness */
    @media (max-width: 600px) {
      .container {
        flex-direction: column; /* Stack elements vertically on small screens */
        align-items: center;
      }
      
      .bg-image {
        margin-right: 0;
        margin-bottom: 20px; /* Add space between the image and text */
      }
    }

    /* Feedback Form Styling */
.feedback-form {
    width: 100%;
    max-width: 600px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Form Header */
h2 {
    font-family: Arial, sans-serif;
    font-size: 24px;
    color: #444;
    margin-bottom: 20px;
}

/* Form Group */
.form-group {
    margin-bottom: 15px;
}

/* Labels */
.form-group label {
    font-family: Arial, sans-serif;
    font-size: 16px;
    color: #555;
    display: block;
    margin-bottom: 5px;
}

/* Input and Textarea */
.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #F0c540;
}

/* Submit Button */
.form-group button {
    width: 100%;
    padding: 10px;
    background-color: #F0c540;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.form-group button:hover {
    background-color:rgb(92, 92, 92);
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .feedback-form {
        padding: 15px;
        margin: 20px auto;
    }

    h2 {
        font-size: 20px;
    }
}


/* reviews section */
.customer-reviews {
  padding: 60px 0;
  background-color: #f8f9fa; /* Light gray background */
  text-align: center;
}

.customer-reviews .container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 0 20px;
}

.customer-reviews h2 {
  margin-bottom: 30px;
  color: #343a40; /* Dark gray heading */
  font-size: 2.5rem;
  font-weight: 700;
}

.review-carousel-wrapper {
  position: relative;
  overflow: hidden;
}

.review-carousel {
  display: flex;
  transition: transform 0.6s ease-in-out; /* Slightly smoother transition */
}

.review-slide {
  flex: 0 0 100%;
  padding: 20px;
  box-sizing: border-box;
}

.review-card {
  background-color: #fff;
  border: 1px solid #dee2e6; /* Light border */
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Softer shadow */
  text-align: left;
}

.review-card p {
  margin-bottom: 20px;
  color: #495057; /* Slightly darker text */
  line-height: 1.7;
  font-size: 1.1rem;
}

.reviewer-info {
  display: flex;
  align-items: center;
  gap: 15px; /* Using gap for spacing */
}

.reviewer-info img {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover; /* Ensures the image fills the circle without distortion */
}

.reviewer-info span {
  font-weight: 600;
  color: #212529; /* Darker name */
  font-size: 1.1rem;
}

.carousel-controls {
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  transform: translateY(-50%);
  display: flex;
  justify-content: space-between;
  padding: 0 20px;
  pointer-events: none; /* Allows interaction with slides when buttons overlap */
}

.carousel-controls button {
  background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
  color: #fff;
  border: none;
  padding: 12px 20px;
  font-size: 1.5rem;
  cursor: pointer;
  border-radius: 8px;
  opacity: 0.7;
  transition: opacity 0.3s ease;
  pointer-events: auto; /* Make buttons interactive */
}

.carousel-controls button:hover {
  opacity: 0.9;
}

/* Responsive Design */
@media (max-width: 768px) {
  .customer-reviews {
    padding: 40px 0;
  }
  .customer-reviews h2 {
    font-size: 2rem;
    margin-bottom: 20px;
  }
  .review-slide {
    padding: 15px;
  }
  .review-card {
    padding: 20px;
  }
  .review-card p {
    font-size: 1rem;
    margin-bottom: 15px;
  }
  .reviewer-info {
    gap: 10px;
  }
  .reviewer-info img {
    width: 40px;
    height: 40px;
  }
  .reviewer-info span {
    font-size: 1rem;
  }
  .carousel-controls button {
    font-size: 1.2rem;
    padding: 10px 15px;
  }
}
    </style>
  </head>
  <body>
      <div style="text-align:center; color: #273f44;">
        <marquee direction="left" loop=""><h2><b><i><u>Experience a hassle-free rental process with VRS Ride</i></u></b></h2></marquee>
      </div>
    <?php include("header.php"); ?>
    <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
      <!-- First slide with video -->
      <div class="carousel-item active">
        <video class="d-block w-100" controls autoplay muted loop>
          <source src="video2.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>

      <!-- Second slide with image -->
      <div class="carousel-item">
        <img src="images/mahindra1.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="images/Screenshot.jpg" alt="...">
      </div>
      <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

    <div class="container">
    <div class="bg-image">
      <!-- <img src="https://via.placeholder.com/400" alt="Car Image"> -->
    </div>
    <div class="text">
      <p>VRS Ride – is Rajkot based Rent-A-Cab service Provider Company. The company has begun the service in the year 2001. Since then its mission is to provide the world class car rental service across Gujarat with the best quality at such a competitive price. We are working with professionalism, productivity, pleasure, and punctuality. We provide the service in many major cities of Gujarat like Ahmedabad, Rajkot, Jamnagar, Dwarka, Porbandar, Somnath, Diu, Baroda, Bhuj etc. We provide the service for Airport / Hotel transfer, Local city tour and also for Outstation. We provide all types of vehicles like Sedan cars / SUVs / Luxurious cars / Tempo Traveler / Bus etc… Many Tourists, Corporate Companies, Colleges, Institutions, Exhibitors, are using our service regularly and are satisfied & impressed with the Quality of our service. We look forward to providing the same to you in near future.</p>
    </div>
  </div>


    <!-- About Section -->
    <div class="about-div" id="abo">
      <div class="blog-txt">
          <center><strong><h1 style="color: rgb(5, 0, 10);">About Us</h1></strong></center>
          <div class="blog-line"></div>
      </div>
      <div class="about-images">
          <img src="images/ElectricCar.jpg" class="about-img">
          <img src="images/rear.jpg" class="about-img">
      </div>
        <div>
          <img src="images/Screenshot.jpg" alt="Screenshot image not found">
        </div>

      <br>
      <br>
      <div class="about-txt">
          <strong><p style="color: black; ">
            <b>VRS Ride – Your Trusted Partner for Convenient Car Rentals<b><br><br>
            
            At VRS Ride, we provide seamless car rental solutions that put your comfort, convenience, and safety first. Whether you're looking for a sleek sedan, a spacious SUV, or a luxury ride for a special occasion, we offer a wide range of vehicles to meet your needs. With a simple booking process, flexible rental options, and competitive pricing, we make it easy for you to get on the road. <br>
            
            Experience a hassle-free rental process with VRS Ride, where exceptional service, top-quality vehicles, and customer satisfaction are always our priority. Whether you're planning a weekend getaway, a business trip, or a road adventure, we’ve got the perfect vehicle for you.<br><br>
            
            Why Choose VRS Ride?<br><br>
            -> Wide Vehicle Selection: From compact cars to family SUVs, find the perfect ride for every journey.<br>
            -> Affordable Pricing: Get unbeatable value without compromising on quality or comfort.<br>
            -> 24/7 Support: Our dedicated team is available round the clock to assist with your booking or any questions you may have.<br>
            -> Reliable & Safe: All our vehicles undergo regular maintenance, ensuring they are safe, clean, and ready for the road.<br>
            -> Flexible Rental Terms: We offer daily, weekly, or long-term rental options to suit your travel needs.<br><br><br>
            
            Book your next ride with VRS Ride today and experience the difference!<br><br><br>
            Feel free to adjust any parts according to your brand tone or any specific services you might offer!. <br><br>
          </p></strong>
      </div>
    </div>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <h2 style="text-align: center;"><b>We Value Your Feedback!</b></h2>

<form action="submit_feedback.php" method="POST" class="feedback-form">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    
    <div class="form-group">
        <label for="feedback">Feedback:</label>
        <textarea id="feedback" name="feedback" rows="4" required></textarea>
    </div>
    
    <div class="form-group">
        <button type="submit" name="submit">Submit Feedback</button>
    </div>
</form><br>

<section class="customer-reviews">
  <div class="container">
    <h3><b>What Our Customers Say</b></h3>
    <div class="review-carousel-wrapper">
      <div class="review-carousel">
        <div class="review-slide">
          <div class="review-card">
            <p>"The vehicle was in excellent condition, and the booking process was seamless. Highly recommended for anyone needing reliable transportation in the area!"</p>
            <div class="reviewer-info">
              <img src="images/ghibli1.jpeg" alt="Customer 1 Avatar" loading="lazy">
              <span>Pinak Dave</span>
            </div>
          </div>
        </div>
        <div class="review-slide">
          <div class="review-card">
            <p>"Great service! The staff was friendly and helpful, and the vehicle was perfect for our trip. Will definitely use VRS Ride again."</p>
            <div class="reviewer-info">
              <img src="images/ghibli2.jpg" alt="Customer 2 Avatar" loading="lazy">
              <span>Paramveersinh Jadeja</span>
            </div>
          </div>
        </div>
        <div class="review-slide">
          <div class="review-card">
            <p>"Affordable rates and a wide selection of vehicles. I found exactly what I needed for my business trip. A very positive experience overall."</p>
            <div class="reviewer-info">
              <img src="images/pm.jpg" alt="Customer 3 Avatar" loading="lazy">
              <span>Ved Yogi</span>
            </div>
          </div>
        </div>
        </div>
      <div class="carousel-controls">
        <button class="prev-button" aria-label="Previous Review">&lt;</button>
        <button class="next-button" aria-label="Next Review">&gt;</button>
      </div>
    </div>
  </div>
</section>


<div id="con" style="width:100%; background-color:#F0c540; text-align:center; display:flex; flex-direction:column; justify-content:center; align-items:center; font-family: 'Open Sans', sans-serif; padding:10px 0;">
  <h1 style="margin:10px; padding-bottom:5px;">Call Today For Booking Your Next Ride</h1>
  <h2 style="margin:0;">
    <a href="tel:+91-9427288148" style="color:black; text-decoration:none; background-color:white; padding:10px 20px; border-radius:25px; transition: all 0.3s;" onmouseover="this.style.backgroundColor='blue'; this.style.color='white'" onmouseout="this.style.backgroundColor='white'; this.style.color='black'">+91-9427288148</a>
  </h2>
</div>

<br><br><br>

    <div>
      <img src="Sc.jpg">
    </div>
    


    <div style="display:flex; justify-content:center; ">
    <h1><b>Find Us</b><br></h1>
    <!-- <p>Find us at the following location on the map:</p> -->
    </div>
    <!-- Google Map iframe -->
    <div class="map-container">
    
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14764.469117167355!2d70.75165428715819!3d22.311403899999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959c99b93dd65c7%3A0x3f5cf0919b22e8c!2sCar%20rental%20in%20rajkot%20(Comfort%20Trip)!5e0!3m2!1sen!2sin!4v1742650319610!5m2!1sen!2sin" 
            width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
        </iframe>
    </div>
    <?php include("footer.php"); ?>
    <script>
     document.addEventListener('DOMContentLoaded', function() {
  const carouselWrapper = document.querySelector('.review-carousel-wrapper');
  const carousel = document.querySelector('.review-carousel');
  const slides = document.querySelectorAll('.review-slide');
  const prevButton = document.querySelector('.prev-button');
  const nextButton = document.querySelector('.next-button');

  let currentIndex = 0;
  let slideWidth;
  let autoSlideInterval;
  const autoSlideDelay = 3000; // Change slide every 5 seconds

  function updateSlideWidth() {
    if (slides.length > 0) {
      slideWidth = slides[0].offsetWidth;
    }
  }

  function updateCarousel() {
    updateSlideWidth(); // Ensure slideWidth is up-to-date
    const translateX = -currentIndex * slideWidth;
    carousel.style.transform = `translateX(${translateX}px)`;
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    updateCarousel();
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    updateCarousel();
  }

  function startAutoSlide() {
    autoSlideInterval = setInterval(nextSlide, autoSlideDelay);
  }

  function stopAutoSlide() {
    clearInterval(autoSlideInterval);
  }

  if (nextButton && prevButton) {
    nextButton.addEventListener('click', () => {
      stopAutoSlide(); // Stop auto-sliding on manual navigation
      nextSlide();
      startAutoSlide(); // Restart auto-sliding after manual navigation
    });
    prevButton.addEventListener('click', () => {
      stopAutoSlide(); // Stop auto-sliding on manual navigation
      prevSlide();
      startAutoSlide(); // Restart auto-sliding after manual navigation
    });
  }

  // Automatic Sliding
  startAutoSlide();

  // Pause on hover
  if (carouselWrapper) {
    carouselWrapper.addEventListener('mouseenter', stopAutoSlide);
    carouselWrapper.addEventListener('mouseleave', startAutoSlide);
  }

  // Initial update and on resize
  window.addEventListener('resize', () => {
    updateCarousel();
  });

  updateCarousel(); // Initialize the carousel
});
      </script>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>