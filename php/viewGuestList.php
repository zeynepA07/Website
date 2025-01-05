<?php
include 'DBconnection.php';
session_start();

if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true){
    
    try {
        $sql = "SELECT firstName, lastName, numberOfPeople, timeSlot FROM reservations WHERE dateOfReservation = CURDATE()";
        $stmt = $conn->query($sql);
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($reservations)) {
            echo "<table border='1'>
                    <tr>
                        <th>Name</th>
                        <th>Number of People</th>
                        <th>Time Slot</th>
                    </tr>";

            foreach ($reservations as $reservation) {
                echo "<tr>
                        <td>{$reservation['firstName']} {$reservation['lastName']}</td>
                        <td>{$reservation['numberOfPeople']}</td>
                        <td>{$reservation['timeSlot']}</td>
                      </tr>";
            }
            echo "</table>";

        } 
        else {
            echo "<p>No reservations today.</p>";
        }

    } 
    catch (PDOException $e) {
        header("Location: errorPages/error.php?error_message=A database error occurred.");
        exit();
    }
} 
else {
    header("Location: ../guestListLogin.html");
    exit();
}
?>