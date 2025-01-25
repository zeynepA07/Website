<?php
session_start();
$formData = isset($_SESSION['formData']) ? $_SESSION['formData'] : [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Zeynep's Restaurant</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/app.js"></script>
</head>

<body>

    <nav>
        <ul>
            <li><a href="../html/homepage.html">Homepage</a></li>
            <li><a class="activePage" href="tableReservation.php">Table Reservation</a></li>
            <li><a href="../html/guestListLogin.html">Guest List Login</a></li>
        </ul>
    </nav>

    <h1>Table Reservation - Form</h1>

    <form action="reservationHandler.php" method="POST">
        <input type="hidden" name="action" value="checkAvailability">

        <label for="firstName">First Name*:</label>
        <input 
        type="text" 
        id="firstName" 
        name="firstName" 
        maxlength="30" 
        value="<?= htmlspecialchars($formData['firstName'] ?? '') ?>" 
        required>
        
        <br><br>

        <label for="lastName">Last Name*:</label>
        <input 
        type="text" 
        id="lastName" 
        name="lastName" 
        maxlength="30" 
        value="<?= htmlspecialchars($formData['lastName'] ?? '') ?>"
        required>

        <br><br>

        <label for="emailAddress">Email Address*:</label>
        <input 
        type="'email" 
        id="emailAddress" 
        name="emailAddress" 
        maxlength="320" 
        value="<?= htmlspecialchars($formData['emailAddress'] ?? '') ?>"
        required>

        <br><br>

        <label for="numberOfPeople">Number of People*:</label>
        <input 
        type="number" 
        id="numberOfPeople" 
        name="numberOfPeople" 
        min="1" 
        max="4" 
        value="<?= htmlspecialchars($formData['numberOfPeople'] ?? '') ?>"
        required>

        <br><br>

        <label for="dateOfReservation">Date*:</label>
        <input 
        type="date" 
        id="dateOfReservation" 
        name="dateOfReservation" 
        value="<?= htmlspecialchars($formData['dateOfReservation'] ?? '') ?>"
        required>

        <br><br>

        <input type="submit" value="Check Availability">
        <br><br>
    </form>

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