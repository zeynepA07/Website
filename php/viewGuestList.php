<?php
include 'DBconnection.php';
session_start();

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    try{
        $sql = "SELECT * FROM reservations WHERE dateOfReservation = CURDATE()";
        $stmt = $conn->query($sql);
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($reservations as $reservation) {
            echo "<p>{$reservation['firstName']} {$reservation['lastName']} - {$reservation['timeSlot']} ({$reservation['numberOfPeople']} people)</p>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else{
    echo "Access denied.";
}
?>