<?php
   include('session.php');
?>
<?php
// Assuming you have established a connection to the database using $db
// session_start(); // Uncomment if you are using sessions

function carbooking($pickLocation, $dropLocation, $pickupDate, $pickupTime, $carModel, $carName, $numOfPeople, $driveType, $db)
{
    // Sanitize input using mysqli_real_escape_string to prevent SQL injection
    $pickLocation = mysqli_real_escape_string($db, $pickLocation);
    $dropLocation = mysqli_real_escape_string($db, $dropLocation);
    $pickupDate = mysqli_real_escape_string($db, $pickupDate);
    $pickupTime = mysqli_real_escape_string($db, $pickupTime);
    $carModel = mysqli_real_escape_string($db, $carModel);
    $carName = mysqli_real_escape_string($db, $carName);
    $numOfPeople = mysqli_real_escape_string($db, $numOfPeople);
    $driveType = mysqli_real_escape_string($db, $driveType);

    // Handle file upload if driveType is selfDrive
    if ($driveType == 'selfDrive' && isset($_FILES['drivingLicense']) && $_FILES['drivingLicense']['error'] == 0) {
        // Get file details
        $fileTmpPath = $_FILES['drivingLicense']['tmp_name'];
        $fileName = $_FILES['drivingLicense']['name'];
        $uploadPath = 'uploads/' . $fileName;

        // Move the uploaded file to the 'uploads' directory
        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            $drivingLicense = $fileName;
        } else {
            return "Error uploading the driving license file.";
        }
    } else {
        $drivingLicense = null; // In case no file is uploaded
    }

    // SQL query to insert booking details, including the uploaded file name if available
    $insertSql = "INSERT INTO booking (pick_location, drop_location, pickup_date, pickup_time, car_model, car_name, num_of_people, drive_type, driving_license)
                  VALUES ('$pickLocation', '$dropLocation', '$pickupDate', '$pickupTime', '$carModel', '$carName', '$numOfPeople', '$driveType', '$drivingLicense')";

    // Execute the query
    if (mysqli_query($db, $insertSql)) {
        return "Your car booking was successful!";
    } else {
        return "Error: " . mysqli_error($db);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['booking'])) {
        // Collecting form data
        $Picklocation = $_POST['Picklocation'];
        $Droplocation = $_POST['Droplocation'];
        $pickupDate = $_POST['pickupDate'];
        $pickupTime = $_POST['pickupTime'];
        $carModel = $_POST['carModel'];
        $carName = $_POST['carName'];
        $numOfPeople = $_POST['numOfPeople'];
        $driveType = $_POST['driveType'];

        // Call the carbooking function and store the return message
        $message = carbooking($Picklocation, $Droplocation, $pickupDate, $pickupTime, $carModel, $carName, $numOfPeople, $driveType, $db);

        // Output the message (e.g., success or error)
        echo $message;
    }
}
?>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the form has a file
    if (isset($_FILES['drivingLicense']) && $_FILES['drivingLicense']['error'] == 0) {
        // Get file details
        $fileTmpPath = $_FILES['drivingLicense']['tmp_name'];
        $fileName = $_FILES['drivingLicense']['name'];
        $fileSize = $_FILES['drivingLicense']['size'];
        $fileType = $_FILES['drivingLicense']['type'];

        // Specify where the file will be stored
        $uploadPath = 'uploads/' . $fileName;

        // Move the file from temporary to permanent location
        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "No file uploaded or there was an error with the file.";
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Open+Sans&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  
  </head>

  <style>

    .h1{
      font-family: 'montserrat';
      position: relative;
      top:10rem;
    }


    .card{
      margin-top: 8rem;
    }

    .card-img-top{
      padding: 25px;
      transition: transform .5s;

    }

    .button{
      float: right;
    }

    .card{
      background-color: #f5f5f5;
      border-style: none !important;
    }

    hr{
      border-color: #dbdbdb;
    }

    .card-text{
      font-weight: bold;
    }

    .card-img-top:hover{
      transform: scale(1.1);
    }

    @media (min-width: 1024px) and (max-width: 2000px){
      .car-section{
        margin: 5rem !important;
      }
    }

    /* Button styling */
    .btn {
        background-color: #f30c0c;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
      }

      .btn:hover {
        opacity: 1;
      }
      .bg-img {
        background-image: url(https://mycar-rental-website.netlify.app/static/media/main-car.9b30faa59387879fa060.png);
        background-size: 700px;
        background-repeat: no-repeat;  /* Prevents repeating */
         /* Center the image */
        height: 400px;
        left:60px;
      }


   
     .popup {
        display: none; 
        position: fixed; 
        z-index: 9999; 
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); 
        overflow: auto;
    }

   
    .popup-content {
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); 
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        width: 90%; 
        max-width: 500px; 
        max-height: 80vh;
        overflow-y: auto; 
    }

    
    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 25px;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

   
    input[type="text"],
    input[type="date"],
    input[type="time"],
    select,
    input[type="number"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
    }


    .btn {
        background-color: #f30c0c;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        border-radius: 5px;
    }

    .btn:hover {
        opacity: 0.9;
    } 


    #selfDriveOptions {
            display: none; /* Hidden by default */
            margin-top: 15px;
            padding: 10px;
            border: 1px solid #eee;
            background-color: #f9f9f9;
        }

  

</style>
  <body>
  

  <?php include("header.php"); ?>

    <h1 class="h1 text-center">Choose the best Car here.</h1>

<div class="row car-section">
    <div class="col-lg-4 mb-5">
        <div class="card shadow rounded">
            <img src="images/img1.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Breeza</h5> <hr>
                <p class="card-text">₹1000/day (If you want to drive)<br><br>
                Seating capacity – 0-4 Passengers<br>
                Rate – 15 Rs/km<br>
                Minimum km – 300 km/day for full day or Outstation<br>
                Driver Allowance – 300 Rs/day<br>
                Toll tax, parking charges, border tax, entry fee etc.. extra if any.<br><button class="button btn btn-dark" data-car-type="suv" data-car-name="Breeza">Book Now</button></p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-5">
        <div class="card shadow rounded">
            <img src="images/img2.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Eco Sports</h5> <hr>
                <p class="card-text">₹800/day (If you want to drive)<br><br>
                Seating capacity – 0-4 Passengers<br>
                Rate – 14 Rs/km<br>
                Minimum km – 300 km/day for full day or Outstation<br>
                Driver Allowance – 300 Rs/day<br>
                Toll tax, parking charges, border tax, entry fee etc.. extra if any.<br><button class="button btn btn-dark" data-car-type="suv" data-car-name="Eco Sports">Book Now</button></p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-5">
        <div class="card shadow rounded">
            <img src="images/img3.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">i20</h5> <hr>
                <p class="card-text">₹500/day (If you want to drive)<br><br>
                Seating capacity – 0-4 Passengers<br>
                Rate – 9 Rs/km<br>
                Minimum km – 300 km/day for full day or Outstation<br>
                Driver Allowance – 300 Rs/day<br>
                Toll tax, parking charges, border tax, entry fee etc.. extra if any.<br><button class="button btn btn-dark" data-car-type="hatchback" data-car-name="i20">Book Now</button></p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-5">
        <div class="card shadow rounded">
          <img src="images/img4.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Swift</h5>
            <hr><p class="card-text">₹500/day (If you want to drive)<br><br>
            Seating capacity – 0-4 Passengers<br>
                Rate – 8 Rs/km<br>
                Minimum km – 300 km/day for full day or Outstation<br>
                Driver Allowance – 300 Rs/day<br>
                Toll tax, parking charges, border tax, entry fee etc.. extra if any.<br><button class="button btn btn-dark" data-car-type="hatchback" data-car-name="Swift">Book Now</button></p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="card shadow rounded">
          <img src="images/img6.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Mahindra Scorpio</h5>
            <hr><p class="card-text">₹3000/day (If you want to drive)<br><br>
            Seating capacity – 0-6 Passengers<br>
                Rate – 35 Rs/km<br>
                Minimum km – 300 km/day for full day or Outstation<br>
                Driver Allowance – 300 Rs/day<br>
                Toll tax, parking charges, border tax, entry fee etc.. extra if any.<br><button class="button btn btn-dark" data-car-type="suv" data-car-name="Mahindra Scorpio">Book Now</button></p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="card shadow rounded">
          <img src="images/img7.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Tata Hexa</h5>
            <hr><p class="card-text">₹3500/day (If you want to drive)<br><br>
            Seating capacity – 0-7 Passengers<br>
                Rate – 30 Rs/km<br>
                Minimum km – 300 km/day for full day or Outstation<br>
                Driver Allowance – 300 Rs/day<br>
                Toll tax, parking charges, border tax, entry fee etc.. extra if any.<br><button class="button btn btn-dark" data-car-type="suv" data-car-name="Tata Hexa">Book Now</button></p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="card shadow rounded">
          <img src="images/img8.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Tata Tiago</h5>
            <hr><p class="card-text">₹600/day (If you want to drive)<br><br>
            Seating capacity – 0-4 Passengers<br>
                Rate – 7 Rs/km<br>
                Minimum km – 300 km/day for full day or Outstation<br>
                Driver Allowance – 300 Rs/day<br>
                Toll tax, parking charges, border tax, entry fee etc.. extra if any.<br><button class="button btn btn-dark" data-car-type="hatchback" data-car-name="Tata Tiago">Book Now</button></p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="card shadow rounded">
          <img src="images/img9.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Baleno</h5>
            <hr><p class="card-text">₹500/day (If you want to drive)<br><br>
            Seating capacity – 0-4 Passengers<br>
                Rate – 8 Rs/km<br>
                Minimum km – 300 km/day for full day or Outstation<br>
                Driver Allowance – 300 Rs/day<br>
                Toll tax, parking charges, border tax, entry fee etc.. extra if any.<br><button class="button btn btn-dark" data-car-type="hatchback" data-car-name="Baleno">Book Now</button></p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="card shadow rounded">
          <img src="images/img10.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Hyundai Creta</h5>
            <hr><p class="card-text">₹1500/day (If you want to drive)<br><br>
                Seating capacity – 0-5 Passengers<br>
                Rate – 23 Rs/km<br>
                Minimum km – 300 km/day for full day or Outstation<br>
                Driver Allowance – 300 Rs/day<br>
                Toll tax, parking charges, border tax, entry fee etc.. extra if any.<br><button class="button btn btn-dark" data-car-type="suv" data-car-name="Creta">Book Now</button></p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="card shadow rounded">
          <img src="images/img11.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Tata Manza</h5>
            <hr><p class="card-text"> ₹500/day (If you want to drive)<br><br>
                Seating capacity – 0-4 Passengers<br>
                Rate – 10 Rs/km<br>
                Minimum km – 300 km/day for full day or Outstation<br>
                Driver Allowance – 300 Rs/day<br>
                Toll tax, parking charges, border tax, entry fee etc.. extra if any.<br><button class="button btn btn-dark" data-car-type="sedan" data-car-name="Tata Manza">Book Now</button></p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
    <div class="card shadow rounded">
        <img src="images/img12.png" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Skoda Superb</h5>
            <hr>
            <p class="card-text">₹1200/day (If you want to drive)<br><br>
            Seating capacity – 0-5 Passengers<br>
                Rate – 15 Rs/km<br>
                Minimum km – 300 km/day for full day or Outstation<br>
                Driver Allowance – 300 Rs/day<br>
                Toll tax, parking charges, border tax, entry fee etc.. extra if any.<br><button class="button btn btn-dark" data-car-type="sedan" data-car-name="Skoda Superb">Book Now</button>
            </p>
        </div>
    </div>

    <!-- Add more cars here similarly -->

  </div>  
  
<!-- Popup Form -->
<!-- Popup Form (hidden initially) -->
<div id="bookingPopup" class="popup">
    <div class="popup-content">
        <span id="closeBtn" class="close">&times;</span>
        <h2>Booking Details</h2>
        <form id="bookingForm" name="booking">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br/>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br/>

            <label for="drivingType">Driving Type:</label>
            <select id="drivingType" name="drivingType" required>
                <option value="">Select Driving Type</option>
                <option value="driver">Driver Drive</option>
                <option value="self">Self Drive</option>
            </select><br/>

            <div id="selfDriveOptions">
                <h3>Self Drive Details</h3>
                <label for="drivingLicense">Upload Driving License:</label>
                <input type="file" id="drivingLicense" name="drivingLicense"><br/>
            </div>

            <label for="Picklocation">Pick-up Location:</label>
            <input type="text" id="Picklocation" name="Picklocation" required><br/>
            <label for="Droplocation">Drop Location:</label>
            <input type="text" id="Droplocation" name="Droplocation" required><br/>
            <label for="pickupDate">Pickup Date:</label>
            <input type="date" id="pickupDate" name="pickupDate" required><br/>
            <label for="pickupTime">Pickup Time:</label>
            <input type="time" id="pickupTime" name="pickupTime" required><br/>
            <label for="carModel">Car Model:</label>
            <select id="carModel" name="carModel" required>
                <option value="">Select Car Model</option>
                <option value="sedan">Sedan</option>
                <option value="suv">SUV</option>
                <option value="hatchback">Hatchback</option>
            </select><br/>
            <label for="carName">Car Name:</label>
            <input type="text" id="carName" name="carName" required><br/>
            <label for="numOfPeople">Number of People:</label>
            <input type="number" id="numOfPeople" name="numOfPeople" min="1" required><br/>
            <button type="submit" class="btn">Submit Booking</button>
        </form>
    </div>
</div>
   

    
  </div>

    <?php include("footer.php"); ?>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    



<script>

    document.addEventListener("DOMContentLoaded", function () {
            const bookNowButtons = document.querySelectorAll('.button');
            const bookingPopup = document.getElementById('bookingPopup');
            const closeButton = document.getElementById('closeBtn');
            
            // Loop through each button and add click event listener
            bookNowButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    const carName = event.target.getAttribute('data-car-name');
                    const carType = event.target.getAttribute('data-car-type');
                    
                    // Populate the form fields
                    document.getElementById('carName').value = carName;
                    document.getElementById('carModel').value = carType;
                    
                    // Show the popup form
                    bookingPopup.style.display = 'block';
                });
            });

            // Close the popup when clicking on the close button
            closeButton.addEventListener('click', function() {
                bookingPopup.style.display = 'none';
            });

            // Optional: Close the popup when clicking anywhere outside the popup content
            window.addEventListener('click', function(event) {
                if (event.target === bookingPopup) {
                    bookingPopup.style.display = 'none';
                }
            });
        });




        document.addEventListener("DOMContentLoaded", function () {
    const bookNowButtons = document.querySelectorAll('.button');
    const bookingPopup = document.getElementById('bookingPopup');
    const closeButton = document.getElementById('closeBtn');
    const bookingForm = document.getElementById('bookingForm');
    const drivingTypeSelect = document.getElementById('drivingType');
    const selfDriveOptionsDiv = document.getElementById('selfDriveOptions');
    const drivingLicenseInput = document.getElementById('drivingLicense');

    // Loop through each "Book Now" button and add click event listener
    bookNowButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            const carName = event.target.getAttribute('data-car-name');
            const carType = event.target.getAttribute('data-car-type');

            document.getElementById('carName').value = carName;
            document.getElementById('carModel').value = carType;

            bookingPopup.style.display = 'block';
        });
    });

    // Close the popup when clicking on the close button
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            bookingPopup.style.display = 'none';
        });
    }

    // Optional: Close the popup when clicking anywhere outside the popup content
    window.addEventListener('click', function(event) {
        if (event.target === bookingPopup) {
            bookingPopup.style.display = 'none';
        }
    });

    // Show/hide driving license upload based on driving type selection
    if (drivingTypeSelect) {
        drivingTypeSelect.addEventListener('change', function() {
            if (this.value === 'self') {
                selfDriveOptionsDiv.style.display = 'block';
                drivingLicenseInput.setAttribute('required', 'required'); // Make it required for self-drive
            } else {
                selfDriveOptionsDiv.style.display = 'none';
                drivingLicenseInput.removeAttribute('required'); // Remove requirement for driver-drive
            }
        });
    }

    // Handle the form submission using AJAX
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(bookingForm);

            fetch('insert_booking.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'Booking successful!'); // Display message if provided
                    bookingPopup.style.display = 'none'; // Close the popup
                    if (data.redirect) {
                        window.location.href = data.redirect; // Redirect to the specified page
                    }
                } else {
                    alert(data.message); // Display error message in an alert
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred.');
            });
        });
    }
});

    </script>


  </body>
</html>