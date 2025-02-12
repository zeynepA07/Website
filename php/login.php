<?php
include 'DBconnection.php';
session_start();

//store the time and set a timeout duration
$_SESSION['timeout'] = time();
$_SESSION['timeoutDuration'] = 3600;



//checks if the submission of form was made using the POST method so that it is only run when it's post.
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    //remove extra space from the user input
    $staffUsername = trim($_POST['staffUsername']);
    $staffPassword = trim($_POST['staffPassword']);


    
    //server-side validation to check if any of the fields are empty.
    if (empty($staffUsername) || empty($staffPassword)) {
        header("Location: errorPages/error.php?error_message=All fields are required.");
        exit();
    }

    try {
        //fetch the hashed password corresponding to the username entered.
        $sql = "SELECT staffPassword FROM staffAccount WHERE staffUsername = :staffUsername";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':staffUsername' => $staffUsername]);
        $user = $stmt->fetch();



        //checks if the password entered by the user matches the hashed password in the database
        if($user && password_verify($staffPassword, $user['staffPassword'])) {

            //if the password does match the hashed password, then the user is taken to the viewGuestList page.
            $_SESSION['loggedIn'] = true;
            header("Location: viewGuestList.php");
            exit();
        }

        //if the password or username is incorrect, the user is taken to the error page.
        else{
            header("Location: errorPages/error.php?error_message=Invalid username or password.");
            exit();
        }
    } 



    //error handling
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