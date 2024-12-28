<?php
session_start();

if (!isset($_SESSION['availableTimeSlots']) || !isset($_SESSION['reservationData'])) {
    echo "No available time slots. Please try again.";
    exit();
}

$availableTimeSlots = $_SESSION['availableTimeSlots'];
$reservationData = $_SESSION['reservationData'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select Time Slot</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/app.js"></script>
</head>

<body>
    <h1>Table Reservation - Selecting a Time Slot</h1>

    <form action="reservationHandler.php" method="POST">
        <input type="hidden" name="action" value="handleReservation">
        <input type="hidden" name="firstName" value="<?= htmlspecialchars($reservationData['firstName']) ?>">
        <input type="hidden" name="lastName" value="<?= htmlspecialchars($reservationData['lastName']) ?>">
        <input type="hidden" name="emailAddress" value="<?= htmlspecialchars($reservationData['emailAddress']) ?>">
        <input type="hidden" name="numberOfPeople" value="<?= htmlspecialchars($reservationData['numberOfPeople']) ?>">
        <input type="hidden" name="dateOfReservation" value="<?= htmlspecialchars($reservationData['dateOfReservation']) ?>">

        <label for="timeSlot">Available tables are at:</label><br>
        <?php foreach ($availableTimeSlots as $timeSlot): ?>
            <?php $formattedTime = substr($timeSlot, 0, 5); ?>
            <input type="radio" id="<?= $formattedTime ?>" name="timeSlot" value="<?= $timeSlot ?>" required>
            <label for="<?= $formattedTime ?>"><?= $formattedTime ?></label><br>
        <?php endforeach; ?>

        <br><br>
        <input type="checkbox" name="consent" required>
        <label for="consent">I consent to having my details stored until the reservation day.</label><br><br>

        <input type="submit" value="Confirm">
        <br><br>

    </form>

    <footer>
        <div class="leftDiv">
            <p><b>Phone Number:</b><br>0123456789</p>
        </div>

        <div class="rightDiv">
            <p><b>Email Address:</b><br>ZeynepsRestaurant@gmail.com</p>
        </div>
    </footer>

</body>
</html>