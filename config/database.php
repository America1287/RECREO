<?php

$host = "localhost";
$port = 3307;
$user = "root";
$pass = "";
$db   = "recreo";

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Lo sentimos, hay un problema con el servicio. Intente más tarde. " . $conn->connect_error);
}
?>
