<?php
session_start();
if(!isset($_SESSION['reservationData'])){
    echo "No reservation found.";
    exit();
}

$reservationData = $_SESSION['reservationData'];
unset($_SESSION['reservationData']);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reservation Confirmation</title>
        <link rel="stylesheet" href="css/style.css">
        <script src="js/app.js"></script>
    </head>

<body>
    <nav>
        <ul>
            <li><a href="homepage.html">Homepage</a></li>
            <li><a href="tableReservation.html">Table Reservation</a></li>
            <li><a href="guestListLogin.html">Guest List Login</a></li>
        </ul>
    </nav>

    <h1>Reservation Confirmed</h1>
    <p>Your reservation for <?php echo htmlspecialchars($reservationData['dateOfReservation']); ?> at <?php echo htmlspecialchars($reservationData['timeSlot']); ?> has been successfully made.</p>

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