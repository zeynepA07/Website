<?php
$servername = "127.0.0.1";
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = "restaurantDB";

date_default_timezone_set('Europe/London');

try{
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection successful.";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>