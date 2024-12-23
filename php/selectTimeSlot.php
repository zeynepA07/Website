<?php
session_start();

if (!isset($_SESSION['availableTimeSlots']) || !isset($_SESSION['reservationData'])) {
    echo "No available time slots. Please try again.";
    exit;
}

$availableTimeSlots = $_SESSION['availableTimeSlots'];
$reservationData = $_SESSION['reservationData'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select Time Slot</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/app.js"></script>
</head>

<body>
    <h1>Table Reservation - Selecting a Time Slot</h1>

    <form action="reservationHandler.php" method="POST">
        <input type="hidden" name="action" value="handleReservation">
        <input type="hidden" name="firstName" value="<?php echo htmlspecialchars ($reservationData['firstName']); ?>">
        <input type="hidden" name="lastName" value="<?php echo htmlspecialchars ($reservationData['lastName']); ?>">
        <input type="hidden" name="emailAddress" value="<?php echo htmlspecialchars ($reservationData['emailAddress']); ?>">
        <input type="hidden" name="numberOfPeople" value="<?php echo htmlspecialchars ($reservationData['numberOfPeople']); ?>">
        <input type="hidden" name="dateOfReservation" value="<?php echo htmlspecialchars ($reservationData['dateOfReservation']); ?>">

        <label for="timeSlot">Available tables are at:</label>
        <br>

        <?php foreach ($availableTimeSlots as $timeSlot): ?>
            <input type="radio" id="<?php echo $timeSlot; ?>" name="timeSlot" value="<?php echo $timeSlot; ?>" required>
            <label for="<?php echo $timeSlot; ?>"><?php echo $timeSlot; ?></label>
            <br>
        <?php endforeach; ?>


        <br>
        <input type="checkbox" name="consent" required>
        <label for="consent">I consent to having my details stored until the reservation day.</label>

        <br><br>

        <input type="submit" value="Confirm">
        </form>

</body>
</html>