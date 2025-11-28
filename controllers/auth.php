<?php
session_start();
require_once "../config/database.php";

$email = $_POST['email'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM usuarios WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['rol_id'] = $user['rol_id'];
    $_SESSION['nombre'] = $user['nombre'];

    header("Location: ../index.php");
} else {
    echo "Credenciales incorrectas";
}
?>
