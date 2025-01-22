<?php
include 'DBconnection.php';

try{
    $staffUsername = 'Username1';
    $plainPassword = 'ghWj5';

    $checkSql = "SELECT COUNT(*) FROM staffAccount WHERE staffUsername = :staffUsername";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([':staffUsername' => $staffUsername]);
    $exists = $checkStmt->fetchColumn();


    if ($exists>0){
        echo "Error: An account with the username '$staffUsername' already exists.";
    }

    else{
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    $sql = "INSERT INTO staffAccount (staffUsername, staffPassword) VALUES (:staffUsername, :staffPassword)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':staffUsername' => $staffUsername, ':staffPassword' => $hashedPassword]);

    echo "User successfully added.";
    }

}

catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>