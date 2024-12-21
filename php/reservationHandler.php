<?php
include 'DBconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'checkAvailability') {
    
            $dateOfReservation = $_POST['dateOfReservation'];

            try {
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
        } elseif ($action === 'handleReservation') {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $emailAddress = $_POST['emailAddress'];
            $numberOfPeople = $_POST['numberOfPeople'];
            $dateOfReservation = $_POST['dateOfReservation'];
            $timeSlot = $_POST['timeSlot'];

            if (empty($firstName) || empty($lastName) || empty($emailAddress) || empty($numberOfPeople) || empty($dateOfReservation) || empty($timeSlot)) {
                echo "All fields are required.";
                exit();
            }

            if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format.";
                exit();
            }

            if ($numberOfPeople < 1 || $numberOfPeople > 4) {
                echo "Number of people must be between 1 and 4.";
                exit();
            }

            try {
                $sql = "INSERT INTO reservations (firstName, lastName, emailAddress, numberOfPeople, dateOfReservation, timeSlot)
                        VALUES (:firstName, :lastName, :emailAddress, :numberOfPeople, :dateOfReservation, :timeSlot)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':firstName' => $firstName,
                    ':lastName' => $lastName,
                    ':emailAddress' => $emailAddress,
                    ':numberOfPeople' => $numberOfPeople,
                    ':dateOfReservation' => $dateOfReservation,
                    ':timeSlot' => $timeSlot,
                ]);
                echo "Reservation successful.";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Invalid action.";
        }
    } else {
        echo "Action not specified.";
    }
}
?>
