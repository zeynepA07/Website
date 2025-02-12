<?php
//connect to database
$servername = "127.0.0.1";
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = "restaurantDB";


//set timezone
date_default_timezone_set('Europe/London');



try{
    //create php data object connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Database connection successful.";
} 



//error handling
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>