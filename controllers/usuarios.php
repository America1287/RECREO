<?php
// ====================================================
//  CONTROLADOR DE USUARIOS - SISTEMA RECREO
// ====================================================
session_start();

// ✅ Verificar que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: /recreo/views/login.php");
    exit;
}

// ✅ Solo Admin (rol_id = 1) puede acceder
if ($_SESSION['rol_id'] != 1) {
    die("Acceso denegado. Solo administradores pueden gestionar usuarios.");
}

require_once "../config/database.php";
require_once "../models/UsuarioModel.php";

$model = new UsuarioModel($conn);
$action = $_GET['action'] ?? 'index';

// =====================================================
// LISTAR USUARIOS
// =====================================================
if ($action === 'index') {
    $usuarios = $model->obtenerTodos();
    include "../views/usuarios/index.php";
    exit;
}

// =====================================================
// FORMULARIO CREAR
// =====================================================
if ($action === 'create') {
    $roles = $model->obtenerRoles();
    include "../views/usuarios/create.php";
    exit;
}

// =====================================================
// GUARDAR NUEVO USUARIO
// =====================================================
if ($action === 'store') {
    
    // Validar datos
    if (empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['rol_id'])) {
        die("Todos los campos son obligatorios");
    }
    
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol_id = (int)$_POST['rol_id'];
    
    // ✅ Validar que el email no exista
    if ($model->emailExiste($email)) {
        die("El email ya está registrado. <a href='/recreo/controllers/usuarios.php?action=create'>Volver</a>");
    }
    
    // ✅ Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email inválido. <a href='/recreo/controllers/usuarios.php?action=create'>Volver</a>");
    }
    
    // Crear usuario
    if ($model->crear($nombre, $email, $password, $rol_id)) {
        header("Location: /recreo/controllers/usuarios.php?action=index");
        exit;
    } else {
        die("Error al crear usuario");
    }
}

// =====================================================
// FORMULARIO EDITAR
// =====================================================
if ($action === 'edit') {
    
    // Validar ID
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die("ID inválido");
    }
    
    $id = (int)$_GET['id'];
    $roles = $model->obtenerRoles();
    $usuario = $model->obtenerPorId($id);
    
    if (!$usuario) {
        die("Usuario no encontrado");
    }
    
    include "../views/usuarios/edit.php";
    exit;
}

// =====================================================
// ACTUALIZAR USUARIO
// =====================================================
if ($action === 'update') {
    
    // Validar datos
    if (empty($_POST['id']) || empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['rol_id'])) {
        die("Todos los campos son obligatorios");
    }
    
    $id = (int)$_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rol_id = (int)$_POST['rol_id'];
    
    // ✅ Validar que el email no exista (excepto para este usuario)
    if ($model->emailExiste($email, $id)) {
        die("El email ya está registrado por otro usuario. <a href='/recreo/controllers/usuarios.php?action=edit&id=$id'>Volver</a>");
    }
    
    // ✅ Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email inválido. <a href='/recreo/controllers/usuarios.php?action=edit&id=$id'>Volver</a>");
    }
    
    // Actualizar datos básicos
    $model->editar($id, $nombre, $email, $rol_id);
    
    // ✅ Cambiar password solo si escribió algo
    if (!empty($_POST['password'])) {
        $model->actualizarPassword($id, $_POST['password']);
    }
    
    header("Location: /recreo/controllers/usuarios.php?action=index");
    exit;
}

// =====================================================
// ELIMINAR USUARIO
// =====================================================
if ($action === 'delete') {
    
    // Validar ID
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die("ID inválido");
    }
    
    $id = (int)$_GET['id'];
    
    // ✅ No permitir que se elimine a sí mismo
    if ($id == $_SESSION['user_id']) {
        die("No puedes eliminar tu propia cuenta. <a href='/recreo/controllers/usuarios.php?action=index'>Volver</a>");
    }
    
    if ($model->eliminar($id)) {
        header("Location: /recreo/controllers/usuarios.php?action=index");
        exit;
    } else {
        die("Error al eliminar usuario");
    }
}

?>