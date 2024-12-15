<?php
include 'DBconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dateOfReservation = $_POST['dateOfReservation'];

    try{
        $sql = "SELECT timeSlot FROM reservations WHERE dateOfReservation = :dateOfReservation";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':dateOfReservation' => $dateOfReservation]);
        $unavailableTimeSlots = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $allTimeSlots = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
        $availableTimeSlots = array_diff($allTimeSlots, $unavailableTimeSlots);


        echo json_encode($availableTimeSlots);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}