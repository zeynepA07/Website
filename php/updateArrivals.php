<?php
include 'DBconnection.php';
session_start();



//check if the checkbox had been selected, if so, set arrived to true (1)
if(isset($_POST['arrived']) && is_array($_POST['arrived'])){

    
    try {
        $emailAddresses = $_POST['arrived'];
        $placeholders = rtrim(str_repeat('?', count($emailAddresses)), ',');
        $sql = "UPDATE reservations SET arrived = 1 WHERE emailAddress IN ($placeholders)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($emailAddresses);

        header("Location: viewGuestList.php");
        exit();
    }
    


    //error handling.
    catch (PDOException $e) {
        header("Location: errorPages/error.php?error_message=Error updating arrivals.");
        exit();
    }
}



else {
    header("Location: viewGuestList.php");
    exit();
}
?>