<?php
include 'DBconnection.php';

session_start();

//checks if the submission of form was made using the POST method so that it is only run when it's post.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'checkAvailability'){

            $dateOfReservation = $_POST['dateOfReservation'];
            //in case the user is somehow able to enter a date in the past, they're taken to the error page.
            if (strtotime($dateOfReservation) < strtotime(date("Y-m-d"))){
                header("Location: errorPages/error.php?errorMessage=The selected date is in the past.");
                exit();
            }

            //fetches booked time slots from the database table on the date selected.
            try {
                $sql = "SELECT timeSlot FROM reservations WHERE dateOfReservation = :dateOfReservation";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':dateOfReservation' => $dateOfReservation]);
                $unavailableTimeSlots = array_map('trim', $stmt->fetchAll(PDO::FETCH_COLUMN));
                $unavailableTimeSlots = array_map('strval', $unavailableTimeSlots);

                $allTimeSlots = ['09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00'];
                $allTimeSlots = array_map('trim', $allTimeSlots);
                $allTimeSlots = array_map('strval', $allTimeSlots);
                
                $currentDate = date("Y-m-d");
                $currentTime = date("H:i:s");

                //filters the available time slots from the unavailable slots.
                $availableTimeSlots = array_diff($allTimeSlots, $unavailableTimeSlots);


                if($dateOfReservation === $currentDate) {
                    $availableTimeSlots = array_filter($availableTimeSlots, function($timeSlot) use ($currentTime){
                        return $timeSlot >= $currentTime;
                    });
                }

                //if there are no available time slots, the data in the form is stored so that when the user returns to the form, their detials are prefilled.
                if (empty($availableTimeSlots)) {
                    session_start();
                    $_SESSION['formData'] = $_POST;
                    header("Location: ../html/errorPages/noTimeSlotsAvailable.html");
                    exit();
                }

                //details are stored and the user is sent to select an available time slot
                session_start();
                $_SESSION['availableTimeSlots'] = $availableTimeSlots;
                $_SESSION['reservationData'] = $_POST;
                header("Location: selectTimeSlot.php");
                exit();


                
                //errror handling
            } catch (PDOException $e){
                header("Location: errorPages/error.php?errorMessage=A database error occurred.");
                exit();
            }


            //store the user information in session variables.
        } elseif ($action === 'handleReservation') {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $emailAddress = $_POST['emailAddress'];
            $numberOfPeople = $_POST['numberOfPeople'];
            $dateOfReservation = $_POST['dateOfReservation'];
            $timeSlot = $_POST['timeSlot'];

            //server-side input validation.
            if (empty($firstName) || empty($lastName) || empty($emailAddress) || empty($numberOfPeople) || empty($dateOfReservation)) {
                header("Location: errorPages/error.php?errorMessage=All fields are required.");
                exit();
            }

            $emailAddress = trim($emailAddress);
            if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
                header("Location: errorPages/error.php?errorMessage=Invalid email format.");
                exit();
            }

            if ($numberOfPeople < 1 || $numberOfPeople > 4) {
                header("Location: errorPages/error.php?errorMessage=The number of people must be between 1 and 4.");
                exit();
            }



            try {
                //ensures that there can't be two reservations under the same email address on the same day.
                $sql = "SELECT COUNT(*) FROM reservations WHERE dateOfReservation = :dateOfReservation AND emailAddress = :emailAddress";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':dateOfReservation' => $dateOfReservation, ':emailAddress' => $emailAddress]);
                $existingReservations = $stmt->fetchColumn();

                //if there is a duplicate, the user is taken to the error page.
                if ($existingReservations > 0){
                    session_start();
                    $_SESSION['formData'] = $_POST;
                    header("Location: errorPages/duplicateError.php");
                    exit();
                }



                //when there all of the inputs are valid, the details are stored in the database.
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

                //retrieves the reservationID so that it can be displayed on the confirmation page.
                $lastInsertID = $conn->lastInsertID();


                //store details of reservation in a session variable so that it can be displayed on the confirmation page.
                session_start();
                $_SESSION['reservationData'] = [
                    'reservationID' => $lastInsertID,
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'emailAddress' => $emailAddress,
                    'dateOfReservation' => $dateOfReservation,
                    'timeSlot' => $timeSlot,
                ];

                unset($_SESSION['formData']);

                header("Location: confirmation.php");
                exit();



                //error handling
            } catch (PDOException $e) {
                header("Location: errorPages/error.php?errorMessage=Database error occurred.");
                exit();
            }
        } else {
            header("Location: errorPages/error.php?errorMessage=Invalid action.");
        }
    } else {
        header("Location: errorPages/error.php?errorMessage=Action not specified.");
    }
}
?>