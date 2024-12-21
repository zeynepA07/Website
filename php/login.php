<?php
include 'DBconnection.php';
session_start();

$_SESSION['timeout'] = time();
$_SESSION['timeout_duration'] = 3600;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staffUsername = $_POST['staffUsername'];
    $staffPassword = $_POST['staffPassword'];

    try{
        $sql = "SELECT * FROM staffAccount WHERE staffUsername = :staffUsername AND staffPassword = :staffPassword";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':staffUsername' => $staffUsername, ':staffPassword' => $staffPassword]);
        $user = $stmt->fetch();

        if($user) {
            $_SESSION['loggedIn'] = true;
            echo "Login succesful.";
        } else{
            echo "Invalid username or password.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
} 
}