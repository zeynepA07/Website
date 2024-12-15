<?php
include 'DBconnection.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];
    $numberOfPeople = $_POST['numberOfPeople'];
    $dateOfReservation = $_POST['dateOfReservation'];

    if (empty($firstName) || empty($lastName) || empty($emailAddress) || empty($numberOfPeople) || empty($dateOfReservation)) {
        echo "All fields are required.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    if($numberOfPeople < 1 || $numberOfPeople > 4) {
        echo "Number of people must be between 1 and 4.";
        exit();
    }


    try {
        $sql = "INSERT INTO reservations (firstName, lastName, emailAddress, numberOfPeople, dateOfReservation)
                VALUES (:firstName, :lastName, :emailAddress, :numberOfPeople, :dateOfReservation)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':emailAddress' => $emailAddress,
            ':numberOfPeople' => $numberOfPeople,
            ':dateOfReservation' => $dateOfReservation,
        ]);
        echo "Reservation successful.";}
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>