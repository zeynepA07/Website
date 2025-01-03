<?php
$host = 'localhost';
$username = 'root';
$password = 'merhaba-ne-yapayim6';
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