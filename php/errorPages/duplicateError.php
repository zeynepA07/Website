<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Duplicate Reservation</title>
        <link rel="stylesheet" href="../../css/style.css">
        <script src="../../js/app.js"></script>
    </head>



<body>
    <nav>
        <ul>
            <li><a href="../../html/homepage.html">Homepage</a></li>
            <li><a href="../tableReservation.php">Table Reservation</a></li>
            <li><a href="../../html/guestListLogin.html">Guest List Login</a></li>
        </ul>
    </nav>



<!-- Inform the user that they cannot proceed with the reservation unless they change the email address or date they've entered. -->
    <h1>Duplicate Reservation</h1>
    <p>There is already a reservation under this email address for this date. Please use a different email or contact us using the details at the end of the page for assistance.</p>
    
<!-- Hyperlink for the user to go back to the form where their details have been stored using a session variables. -->
    <a href="../tableReservation.php">Go back to the form.</a>
    <br><br>

    
    <footer>
        <div class="leftDiv">
            <p><b>Phone Number:</b>
            <br> 0123456789</p>
        </div>

        <div class="rightDiv">
            <p><b>Email Address:</b>
            <br>ZeynepsRestaurant@gmail.com</p>
        </div>
    </footer>

</body>
</html>