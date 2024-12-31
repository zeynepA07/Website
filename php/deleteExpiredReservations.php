<?php
include 'DBconnection.php';

try{
    $currentDateTime = date('Y-m-d H:i:s');

    $sql = "DELETE FROM reservations
            WHERE CONCAT(dateOfReservation, ' ', timeSlot) <= DATE_SUB(:currentDateTime, INTERVAL 1 HOUR)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([':currentDateTime' => $currentDateTime]);

    file_put_contents('cleanup_log.txt', date('Y-m-d H:i:s') . " - Cleanup succesful.\n", FILE_APPEND);
}
catch (PDOException $e){

    file_put_contents('cleanup_log.txt', date('Y-m-d H:i:s') . " - Error: " . $e->getMessage() . "\n", FILE_APPEND);

}
?>