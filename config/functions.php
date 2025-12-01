<?php
// ====================================================
//  FUNCIONES REUTILIZABLES - SISTEMA RECREO
// ====================================================

/**
 * Obtener alertas con filtro opcional por tipo
 * @param mysqli $conn Conexión a la base de datos
 * @param string $tipo Tipo de falta para filtrar (opcional)
 * @return mysqli_result Resultado de la consulta
 */
function getAlertas($conn, $tipo = '')
{

    if ($tipo != '') {
        // Con filtro - Consulta preparada
        $stmt = $conn->prepare("
            SELECT alertas.*, estudiantes.nombre, estudiantes.apellido 
            FROM alertas
            INNER JOIN estudiantes ON alertas.estudiante_id = estudiantes.id
            WHERE alertas.tipo = ?
            ORDER BY alertas.fecha DESC
        ");
        $stmt->bind_param("s", $tipo);
        $stmt->execute();
        return $stmt->get_result();
    } else {
        // Sin filtro - Todas las alertas
        return $conn->query("
            SELECT alertas.*, estudiantes.nombre, estudiantes.apellido 
            FROM alertas
            INNER JOIN estudiantes ON alertas.estudiante_id = estudiantes.id
            ORDER BY alertas.fecha DESC
        ");
    }
}

/**
 * ✅ Obtener alertas con filtros múltiples (tipo y rango de fechas)
 * Versión SEGURA con consultas preparadas
 * 
 * @param mysqli $conn Conexión a la base de datos
 * @param string|null $tipo Tipo de falta para filtrar
 * @param string|null $fecha_inicio Fecha de inicio (formato: YYYY-MM-DD)
 * @param string|null $fecha_fin Fecha de fin (formato: YYYY-MM-DD)
 * @return mysqli_result Resultado de la consulta
 */
function getAlertasPorFiltro($conn, $tipo = null, $fecha_inicio = null, $fecha_fin = null)
{

    $sql = "SELECT a.*, e.nombre, e.apellido 
            FROM alertas a
            JOIN estudiantes e ON a.estudiante_id = e.id
            WHERE 1=1";

    $types = "";
    $params = [];

    // Filtro por tipo
    if ($tipo && $tipo != '') {
        $sql .= " AND a.tipo = ?";
        $types .= "s";
        $params[] = $tipo;
    }

    // Filtro por fecha de inicio
    if (!empty($fecha_inicio)) {
        $sql .= " AND DATE(a.fecha) >= ?";
        $types .= "s";
        $params[] = $fecha_inicio;
    }

    // Filtro por fecha de fin
    if (!empty($fecha_fin)) {
        $sql .= " AND DATE(a.fecha) <= ?";
        $types .= "s";
        $params[] = $fecha_fin;
    }

    $sql .= " ORDER BY a.fecha DESC";

    // ✅ Si no hay filtros, ejecutar consulta directa
    if (empty($params)) {
        return $conn->query($sql);
    }

    // ✅ Si hay filtros, usar consulta preparada
    $stmt = $conn->prepare($sql);

    if ($types) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt->get_result();
}

/**
 * Obtener estudiantes ordenados por nombre
 * @param mysqli $conn Conexión a la base de datos
 * @return mysqli_result Resultado de la consulta
 */
function getEstudiantes($conn)
{
    return $conn->query("SELECT * FROM estudiantes ORDER BY nombre ASC");
}

/**
 * Obtener faltas con filtro opcional por tipo
 * @param mysqli $conn Conexión a la base de datos
 * @param string $tipo Tipo de falta para filtrar (opcional)
 * @return mysqli_result Resultado de la consulta
 */
function getFaltas($conn, $tipo = '')
{

    if ($tipo != '') {
        $stmt = $conn->prepare("
            SELECT f.*, e.nombre AS estudiante_nombre, e.apellido AS estudiante_apellido 
            FROM faltas f 
            JOIN estudiantes e ON f.estudiante_id = e.id 
            WHERE f.tipo = ?
            ORDER BY f.fecha DESC
        ");
        $stmt->bind_param("s", $tipo);
        $stmt->execute();
        return $stmt->get_result();
    } else {
        return $conn->query("
            SELECT f.*, e.nombre AS estudiante_nombre, e.apellido AS estudiante_apellido 
            FROM faltas f 
            JOIN estudiantes e ON f.estudiante_id = e.id
            ORDER BY f.fecha DESC
        ");
    }
}

/**
 * ✅ Obtener faltas con filtros múltiples (tipo y rango de fechas)
 * Versión SEGURA con consultas preparadas
 * 
 * @param mysqli $conn Conexión a la base de datos
 * @param string|null $tipo Tipo de falta para filtrar
 * @param string|null $fecha_inicio Fecha de inicio (formato: YYYY-MM-DD)
 * @param string|null $fecha_fin Fecha de fin (formato: YYYY-MM-DD)
 * @return mysqli_result Resultado de la consulta
 */
function getFaltasPorFiltro($conn, $tipo = null, $fecha_inicio = null, $fecha_fin = null)
{

    $sql = "SELECT f.*, e.nombre AS estudiante_nombre, e.apellido AS estudiante_apellido 
            FROM faltas f 
            JOIN estudiantes e ON f.estudiante_id = e.id 
            WHERE 1=1";

    $types = "";
    $params = [];

    // Filtro por tipo
    if ($tipo && $tipo != '') {
        $sql .= " AND f.tipo = ?";
        $types .= "s";
        $params[] = $tipo;
    }

    // Filtro por fecha de inicio
    if (!empty($fecha_inicio)) {
        $sql .= " AND DATE(f.fecha) >= ?";
        $types .= "s";
        $params[] = $fecha_inicio;
    }

    // Filtro por fecha de fin
    if (!empty($fecha_fin)) {
        $sql .= " AND DATE(f.fecha) <= ?";
        $types .= "s";
        $params[] = $fecha_fin;
    }

    $sql .= " ORDER BY f.fecha DESC";

    // ✅ Si no hay filtros, ejecutar consulta directa
    if (empty($params)) {
        return $conn->query($sql);
    }

    // ✅ Si hay filtros, usar consulta preparada
    $stmt = $conn->prepare($sql);

    if ($types) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt->get_result();
}

/**
 * ✅ FUNCIONES ADICIONALES DE SEGURIDAD Y UTILIDAD
 */

/**
 * Verificar que el usuario tenga uno de los roles permitidos
 * @param array $roles_permitidos Array de IDs de roles permitidos
 * @return bool True si tiene permiso
 */
function verificarRol($roles_permitidos)
{
    if (!isset($_SESSION['rol_id']) || !in_array($_SESSION['rol_id'], $roles_permitidos)) {
        return false;
    }
    return true;
}

/**
 * Sanitizar entrada de texto
 * @param string $data Texto a sanitizar
 * @return string Texto sanitizado
 */
function limpiarTexto($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Generar token CSRF
 * @return string Token generado
 */
function generarCSRFToken()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verificar token CSRF
 * @param string $token Token a verificar
 * @return bool True si es válido
 */
function verificarCSRFToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Registrar actividad en log (si implementas tabla logs)
 * @param mysqli $conn Conexión a la base de datos
 * @param int $usuario_id ID del usuario
 * @param string $accion Descripción de la acción
 * @param string|null $tabla Tabla afectada
 * @param int|null $registro_id ID del registro afectado
 * @return bool True si se registró correctamente
 */
function logActividad($conn, $usuario_id, $accion, $tabla = null, $registro_id = null)
{
    $stmt = $conn->prepare("INSERT INTO logs (usuario_id, accion, tabla, registro_id) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        return false; // Tabla logs no existe aún
    }

    $stmt->bind_param("issi", $usuario_id, $accion, $tabla, $registro_id);
    return $stmt->execute();
}

/**
 * Validar formato de fecha
 * @param string $fecha Fecha a validar (YYYY-MM-DD)
 * @return bool True si es válida
 */
function validarFecha($fecha)
{
    $d = DateTime::createFromFormat('Y-m-d', $fecha);
    return $d && $d->format('Y-m-d') === $fecha;
}

/**
 * Formatear fecha para mostrar (DD/MM/YYYY)
 * @param string $fecha Fecha en formato YYYY-MM-DD
 * @return string Fecha formateada
 */
function formatearFecha($fecha)
{
    $d = DateTime::createFromFormat('Y-m-d', $fecha);
    return $d ? $d->format('d/m/Y') : $fecha;
}
