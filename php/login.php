<?php
include 'DBconnection.php';
session_start();

$_SESSION['timeout'] = time();
$_SESSION['timeoutDuration'] = 3600;

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $staffUsername = trim($_POST['staffUsername']);
    $staffPassword = trim($_POST['staffPassword']);

    if (empty($staffUsername) || empty($staffPassword)) {
        header("Location: errorPages/error.php?error_message=All fields are required.");
        exit();
    }

    try {
        $sql = "SELECT staffPassword FROM staffAccount WHERE staffUsername = :staffUsername";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':staffUsername' => $staffUsername]);
        $user = $stmt->fetch();

        if($user && password_verify($staffPassword, $user['staffPassword'])) {
            $_SESSION['loggedIn'] = true;
            header("Location: viewGuestList.php");
            exit();
        }

        else{
            header("Location: errorPages/error.php?error_message=Invalid username or password.");
            exit();
        }
    } 

    catch (PDOException $e) {
        header("Location: errorPages/error.php?error_message=A database error occurred.");
        exit();
    }
} 
else {
    header("Location: ../html/guestListLogin.html");
    exit();
}
?>