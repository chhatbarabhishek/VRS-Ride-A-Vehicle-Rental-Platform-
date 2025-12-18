<!-- Footer -->
<style>
  /* Footer */
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
    font-family: 'Montserrat', sans-serif;
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
    max-width: 200px;
  }

  /* Footer bottom section */
  .footer2 {
    text-align: center;
    padding: 10px;
    font-family: 'Montserrat', sans-serif;
  }
</style>

<footer id="con">
  <div class="footer-top">
    <!-- First column (Brand info) -->
    <div class="footer-column">
      <a class="navbar-brand" href="#" style="color: #F0c540; font-size: 28px; font-weight: bold; font-family: montserrat;">
        VRS Ride
      </a>
      <p class="content1">Best cars at low cost.</p>
    </div>

    <!-- Second column (Contact Info) -->
    <div class="footer-column">
      <h2 style="color:white">Contact US</h2>
      <p>Street Number 1,<br> Shyam nagar,<br> Bharti nagar,<br> Gandhigram ,<br>Rajkot Gujarat,360007</p>
      <a href="mailto:VRSRide@gmail.com">
  <i class="fa fa-envelope" aria-hidden="true">
    <span style="font-family: 'montserrat';">&nbsp;&nbsp;VRSRide@gmail.com</span>
  </i>
</a>
<br>
<a href="tel:+919427288148">
  <i class="fa fa-phone" aria-hidden="true">
    <span style="font-family: 'montserrat';">&nbsp;&nbsp;9427288148</span>
  </i>
</a>
    </div>

    <!-- Third column (Social Media) -->
    <div class="footer-column">
      <h6 class="content2">SOCIAL MEDIA</h6>
      <div class="icons">
        <a class="icon-link" href="https://www.instagram.com/"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        <a class="icon-link" href="https://www.facebook.com/"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        <a class="icon-link" href="https://x.com/"><i class="fa fa-twitter" aria-hidden="true"></i></a>
        <a class="icon-link" href="https://www.linkedin.com/"><i class="fa fa-linkedin" aria-hidden="true"></i></a><br>
      </div>
    </div>

    <!-- Fourth column (Payment methods) -->
    <div class="footer-column">
      <h2 style="color:white">We Accept</h2>
      <h6>Note: Customer needs to enter<br> payment amount manually (can a person<br> from abroad can make payment from<br> it by his / her credit card)</h6>
      <img src="payment.jpg" alt="Payment Methods">
    </div>
  </div>

  <div class="footer2">
    &copy;2025 <span style="font-family: 'montserrat';">VRS Ride.</span> All Rights Reserved.
  </div>
</footer>
