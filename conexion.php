<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inte";
// $port = 33065;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
