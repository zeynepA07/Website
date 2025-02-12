<?php
include 'DBconnection.php';

try{
    //define the username and password.
    $staffUsername = 'Username1';
    $plainPassword = 'ghWj5';

    
    //check if the username exists
    $checkSql = "SELECT COUNT(*) FROM staffAccount WHERE staffUsername = :staffUsername";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([':staffUsername' => $staffUsername]);
    $exists = $checkStmt->fetchColumn();


    //if the username already exists, display error message.
    if ($exists>0){
        echo "Error: An account with the username '$staffUsername' already exists.";
    }

    //if the username doesn't already exist, hash the password and insert it into the database table.
    else{
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);


    $sql = "INSERT INTO staffAccount (staffUsername, staffPassword) VALUES (:staffUsername, :staffPassword)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':staffUsername' => $staffUsername, ':staffPassword' => $hashedPassword]);

    //display a message, stating that a new user has been created.
    echo "User successfully added.";
    }
}



//error handling
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>