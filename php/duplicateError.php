<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Duplicate Reservation</title>
        <link rel="stylesheet" href="../css/style.css">
        <script src="../js/app.js"></script>
    </head>

<body>
    <nav>
        <ul>
            <li><a href="../homepage.html">Homepage</a></li>
            <li><a href="tableReservation.php">Table Reservation</a></li>
            <li><a href="../guestListLogin.html">Guest List Login</a></li>
        </ul>
    </nav>

    <h1>Duplicate Reservation</h1>
    <p>There is already a reservation under this email address. Please use a different email or contact us using the details at the end of the page for assistance.</p>
    <a href="tableReservation.php">Go back to the form.</a>

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