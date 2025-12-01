<?php
// ====================================================
//  MODELO DE USUARIOS - SISTEMA RECREO
//  ✅ Versión segura con consultas preparadas
// ====================================================

class UsuarioModel {

    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    /**
     * Obtener todos los usuarios con sus roles
     * @return array Lista de usuarios
     */
    public function obtenerTodos() {
        $sql = "SELECT usuarios.*, roles.nombre AS rol_nombre 
                FROM usuarios 
                LEFT JOIN roles ON usuarios.rol_id = roles.id
                ORDER BY usuarios.nombre ASC";
        
        $res = $this->conn->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Obtener todos los roles disponibles
     * @return array Lista de roles
     */
    public function obtenerRoles() {
        $sql = "SELECT * FROM roles ORDER BY nombre ASC";
        $res = $this->conn->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * ✅ Crear nuevo usuario (CONSULTA PREPARADA)
     * @param string $nombre Nombre del usuario
     * @param string $email Email del usuario
     * @param string $password Contraseña sin encriptar
     * @param int $rol_id ID del rol
     * @return bool True si se creó correctamente
     */
    public function crear($nombre, $email, $password, $rol_id) {
        // Encriptar contraseña
        $passHash = password_hash($password, PASSWORD_DEFAULT);
        
        // ✅ Consulta preparada
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, email, password, rol_id) 
                                       VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $email, $passHash, $rol_id);
        
        return $stmt->execute();
    }

    /**
     * ✅ Obtener usuario por ID (CONSULTA PREPARADA)
     * @param int $id ID del usuario
     * @return array|null Datos del usuario o null
     */
    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    /**
     * ✅ Editar usuario (CONSULTA PREPARADA)
     * @param int $id ID del usuario
     * @param string $nombre Nuevo nombre
     * @param string $email Nuevo email
     * @param int $rol_id Nuevo rol
     * @return bool True si se actualizó correctamente
     */
    public function editar($id, $nombre, $email, $rol_id) {
        $stmt = $this->conn->prepare("UPDATE usuarios 
                                       SET nombre = ?, email = ?, rol_id = ?
                                       WHERE id = ?");
        $stmt->bind_param("ssii", $nombre, $email, $rol_id, $id);
        
        return $stmt->execute();
    }

    /**
     * ✅ Actualizar contraseña (CONSULTA PREPARADA)
     * @param int $id ID del usuario
     * @param string $password Nueva contraseña sin encriptar
     * @return bool True si se actualizó correctamente
     */
    public function actualizarPassword($id, $password) {
        $passHash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->conn->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $passHash, $id);
        
        return $stmt->execute();
    }

    /**
     * ✅ Eliminar usuario (CONSULTA PREPARADA)
     * @param int $id ID del usuario a eliminar
     * @return bool True si se eliminó correctamente
     */
    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }

    /**
     * ✅ Verificar si un email ya existe
     * @param string $email Email a verificar
     * @param int|null $excluir_id ID a excluir de la búsqueda (para editar)
     * @return bool True si el email ya existe
     */
    public function emailExiste($email, $excluir_id = null) {
        if ($excluir_id) {
            $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
            $stmt->bind_param("si", $email, $excluir_id);
        } else {
            $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
        }
        
        $stmt->execute();
        $res = $stmt->get_result();
        
        return $res->num_rows > 0;
    }
}
?>