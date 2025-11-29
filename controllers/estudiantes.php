<?php
require_once "../config/database.php";
session_start();

// Verificar que el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: /recreo/views/login.php");
    exit;
}

$action = $_GET['action'] ?? 'index';

// --- LISTAR ESTUDIANTES ---
if ($action === 'index') {
    $result = $conn->query("SELECT * FROM estudiantes");
    include "../views/estudiantes/index.php";
}

// --- CREAR ---
if ($action === 'create') {
    include "../views/estudiantes/create.php";
}

if ($action === 'store') {
    // Validar que existen los datos
    if (empty($_POST['nombre']) || empty($_POST['grado'])) {
        die("Todos los campos son obligatorios");
    }
    
    $nombre = $_POST['nombre'];
    $grado = $_POST['grado'];

    // ✅ Usar consultas preparadas (SEGURO)
    $stmt = $conn->prepare("INSERT INTO estudiantes (nombre, grado) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $grado);
    
    if ($stmt->execute()) {
        header("Location: /recreo/controllers/estudiantes.php?action=index");
        exit;
    } else {
        die("Error al crear estudiante");
    }
}

// --- EDITAR ---
if ($action === 'edit') {
    // Validar que existe el ID
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die("ID inválido");
    }
    
    $id = (int)$_GET['id'];
    
    // ✅ Consulta preparada
    $stmt = $conn->prepare("SELECT * FROM estudiantes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $est = $result->fetch_assoc();
    
    if (!$est) {
        die("Estudiante no encontrado");
    }
    
    include "../views/estudiantes/edit.php";
}

if ($action === 'update') {
    // Validar datos
    if (empty($_POST['id']) || empty($_POST['nombre']) || empty($_POST['grado'])) {
        die("Todos los campos son obligatorios");
    }
    
    $id = (int)$_POST['id'];
    $nombre = $_POST['nombre'];
    $grado = $_POST['grado'];

    // ✅ Consulta preparada
    $stmt = $conn->prepare("UPDATE estudiantes SET nombre = ?, grado = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nombre, $grado, $id);
    
    if ($stmt->execute()) {
        header("Location: /recreo/controllers/estudiantes.php?action=index");
        exit;
    } else {
        die("Error al actualizar estudiante");
    }
}

// --- ELIMINAR ---
if ($action === 'delete') {
    // Validar ID
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die("ID inválido");
    }
    
    $id = (int)$_GET['id'];
    
    // ✅ Consulta preparada
    $stmt = $conn->prepare("DELETE FROM estudiantes WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: /recreo/controllers/estudiantes.php?action=index");
        exit;
    } else {
        die("Error al eliminar estudiante");
    }
}
?>