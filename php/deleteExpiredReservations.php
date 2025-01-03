<?php
include 'DBconnection.php';

try{
    $currentDateTime = date('Y-m-d H:i:s');

    $sql = "DELETE FROM reservations
            WHERE CONCAT(dateOfReservation, ' ', timeSlot) <= DATE_SUB(:currentDateTime, INTERVAL 1 HOUR)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([':currentDateTime' => $currentDateTime]);

    $logMessage = "Cleanup ran at $currentDateTime - Deleted expired reservations. \n";
    file_put_contents('C:/xampp/scripts/cleanup_log.txt', $logMessage, FILE_APPEND);
}

    catch(PDOException $e){
        $logMessage = "Cleanup failed at " . date('Y-m-d H:i:s') . " - Error: " . $e->getMessag() . "\n";

        header ("Location: errorPages/error.php?errorMessage=An error occurred.");
        exit();
    }

?>