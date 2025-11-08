<?php
$servername = getenv('MYSQL_HOST') ?: 'mysql';
$username = getenv('MYSQL_USER') ?: 'root';
$password = getenv('MYSQL_PASSWORD') ?: 'root';
$dbname = getenv('MYSQL_DB') ?: 'studentresultdb';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
