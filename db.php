<?php
$servername = "mysql";  // 👈 this matches the service name in docker-compose
$username = "root";
$password = "root";     // 👈 from your docker-compose environment
$dbname = "studentresultdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
