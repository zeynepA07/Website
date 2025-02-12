<?php
session_start();

//check if reservationData exists, if not, display error message
if(!isset($_SESSION['reservationData'])){
    echo "No reservation found.";
    exit();
}

//retrieve reservation data
$reservationData = $_SESSION['reservationData'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reservation Confirmation</title>
        <link rel="stylesheet" href="../css/style.css">
        <script src="../js/app.js"></script>
    </head>



<body>
    <nav>
        <ul>
            <li><a href="../html/homepage.html">Homepage</a></li>
            <li><a href="tableReservation.php">Table Reservation</a></li>
            <li><a href="../html/guestListLogin.html">Guest List Login</a></li>
        </ul>
    </nav>



    <!-- Display the reservation id, date, and time slot of the reservation. -->
    <h1>Table Reservation - Confirmation</h1>
    <p>Your reservation (Booking ID: <?php echo $reservationData['reservationID']; ?>) for
    <?php echo $reservationData['dateOfReservation']; ?> at 
    <?php echo substr($reservationData['timeSlot'], 0, 5); ?> has been successfully made.</p>


    
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