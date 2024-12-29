<?php
include 'DBconnection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'checkAvailability'){

            $dateOfReservation = $_POST['dateOfReservation'];
            if (strtotime($dateOfReservation) < strtotime(date("Y-m-d"))){
                echo "Error: The selected date is in the past. Please choose a valid date.";
                exit();
            }

            try {
                $sql = "SELECT timeSlot FROM reservations WHERE dateOfReservation = :dateOfReservation";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':dateOfReservation' => $dateOfReservation]);
                $unavailableTimeSlots = array_map('trim', $stmt->fetchAll(PDO::FETCH_COLUMN));
                $unavailableTimeSlots = array_map('strval', $unavailableTimeSlots);

                $allTimeSlots = ['09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00'];
                $allTimeSlots = array_map('trim', $allTimeSlots);
                $allTimeSlots = array_map('strval', $allTimeSlots);

                $availableTimeSlots = array_diff($allTimeSlots, $unavailableTimeSlots);


                if (empty($availableTimeSlots)) {
                    session_start();
                    $_SESSION['formData'] = $_POST;
                    header("Location: noTimeSlotsAvailable.php");
                    exit();
                }

                session_start();
                $_SESSION['availableTimeSlots'] = $availableTimeSlots;
                $_SESSION['reservationData'] = $_POST;
                header("Location: selectTimeSlot.php");
                exit();

            } catch (PDOException $e){
                header("Location: error.php");
                exit();
            }

        } elseif ($action === 'handleReservation') {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $emailAddress = $_POST['emailAddress'];
            $numberOfPeople = $_POST['numberOfPeople'];
            $dateOfReservation = $_POST['dateOfReservation'];
            $timeSlot = $_POST['timeSlot'];

            if (empty($firstName) || empty($lastName) || empty($emailAddress) || empty($numberOfPeople) || empty($dateOfReservation)) {
                echo "All fields are required.";
                exit();
            }

            $emailAddress = trim($emailAddress);
            if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format.";
                exit();
            }

            if ($numberOfPeople < 1 || $numberOfPeople > 4) {
                echo "Number of people must be between 1 and 4.";
                exit();
            }

            try {
                $sql = "SELECT COUNT(*) FROM reservations WHERE dateOfReservation = :dateOfReservation AND timeSlot = :timeSlot";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':dateOfReservation' => $dateOfReservation, ':timeSlot' => $timeSlot]);
                $isTimeSlotTaken = $stmt->fetchColumn();

                if ($isTimeSlotTaken) {
                    echo "This time slot is no longer available. Please go back and select a different time slot.";
                    exit();
                }

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

                session_start();
                $_SESSION['reservationData'] = [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'emailAddress' => $emailAddress,
                    'dateOfReservation' => $dateOfReservation,
                    'timeSlot' => $timeSlot,
                ];

                unset($_SESSION['formData']);

                header("Location: confirmation.php");
                exit();

            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    session_start();
                    $_SESSION['formData'] = $_POST;
                    header("Location: duplicateError.php");
                    exit();
                } else {
                    header("Location: error.php");
                    exit();
                }
            }
        } else {
            echo "Invalid action.";
        }
    } else {
        echo "Action not specified.";
    }
}
?>