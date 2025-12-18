<!-- HTML for Countdown with styling -->
<div style="display: flex; justify-content: center; align-items: center; height: 100vh; text-align: center; margin: 0;">
    <div>
        <p>Redirecting to the payment gateway...</p>
        <h1>Payment Page</h1>
        <h2>Please wait, you will be redirected shortly...</h2>
        <div id="countdown-container" style="width: 100px; height: 100px; 
            background-color: #F0c540; color: black; border-radius: 50%; 
            display: flex; justify-content: center; align-items: center; font-size: 30px; font-weight: bold;">
            <span id="countdown">3</span>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Countdown timer
    var countdownElement = document.getElementById('countdown');
    var countdown = 3; // Starting from 3 seconds

    // Function to update the countdown and redirect after time is up
    var timer = setInterval(function() {
        countdown--; // Decrease the countdown by 1
        countdownElement.textContent = countdown; // Update the countdown display
        
        if (countdown <= 0) {
            clearInterval(timer); // Clear the interval once the countdown reaches 0
            window.location.href = 'payment.php'; // Redirect to payment.php
        }
    }, 1000); // Update every 1 second
</script>
