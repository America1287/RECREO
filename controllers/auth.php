<?php
// ====================================================
//  AUTENTICACIÓN - SISTEMA RECREO
//  ✅ Versión segura con password_verify()
// ====================================================
session_start();
require_once "../config/database.php";

// Validar que se recibieron los datos
if (empty($_POST['email']) || empty($_POST['password'])) {
    die("Todos los campos son obligatorios. <a href='/recreo/views/login.php'>Volver</a>");
}

$email = $_POST['email'];
$password = $_POST['password'];

// ✅ Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Email inválido. <a href='/recreo/views/login.php'>Volver</a>");
}

// ✅ Consulta preparada para obtener el usuario
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // ✅ Verificar contraseña con password_verify()
    if (password_verify($password, $user['password'])) {
        
        // ✅ Contraseña correcta - Iniciar sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['rol_id'] = $user['rol_id'];
        $_SESSION['nombre'] = $user['nombre'];
        
        // Regenerar ID de sesión por seguridad
        session_regenerate_id(true);
        
        header("Location: ../views/dashboard.php");
        exit;
        
    } else {
        // Contraseña incorrecta
        echo "Credenciales incorrectas. <a href='/recreo/views/login.php'>Volver</a>";
    }
} else {
    // Usuario no encontrado
    echo "Credenciales incorrectas. <a href='/recreo/views/login.php'>Volver</a>";
}
?>