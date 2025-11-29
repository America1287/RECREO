<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol_id'];
?>

<h2>Bienvenido, <?= $nombre ?></h2>
<p>Rol: 
    <?php
        if ($rol == 1) echo "Administrador";
        elseif ($rol == 2) echo "Docente";
        elseif ($rol == 3) echo "Director";
        elseif ($rol == 4) echo "Estudiante";
    ?>
</p>

<hr>

<!-- MENÚ DINÁMICO SEGÚN ROL -->
<?php if ($rol == 1): ?>
    <h3>Menú Administrador</h3>
    <a href="../controllers/estudiantes.php?action=index">Gestionar Estudiantes</a><br>
    <a href="#">Gestionar Usuarios (próximamente)</a><br>
    <a href="/recreo/controllers/faltas.php?action=index">Gestionar Faltas (próximamente)</a><br>
    <a href="../controllers/alertas.php?action=index">Ver Alertas</a><br>

<?php elseif ($rol == 2): ?>
    <h3>Menú Docente</h3>
    <a href="../controllers/estudiantes.php?action=index">Ver Estudiantes</a><br>
    <a href="#">Registrar Faltas (próximamente)</a><br>
    <a href="../controllers/alertas.php?action=index">Ver Alertas</a><br>

<?php elseif ($rol == 3): ?>
    <h3>Menú Director</h3>
    <a href="../controllers/estudiantes.php?action=index">Ver Estudiantes</a><br>
    <a href="#">Reportes de Faltas (próximamente)</a><br>

<?php elseif ($rol == 4): ?>
    <h3>Menú Estudiante</h3>
    <a href="#">Mi historial de faltas (próximamente)</a><br>

<?php endif; ?>

<?php if ($_SESSION['rol_id'] == 1 || $_SESSION['rol_id'] == 2 || $_SESSION['rol_id'] == 3): ?>

<h2>Alertas Generadas</h2>

<?php
require_once "../config/database.php";

$alertas = $conn->query("
    SELECT alertas.*, estudiantes.nombre 
    FROM alertas
    INNER JOIN estudiantes ON alertas.estudiante_id = estudiantes.id
    ORDER BY alertas.fecha DESC
");

if ($alertas->num_rows > 0):
?>
    <table border="1" cellspacing="0" cellpadding="5">
        <tr>
            <th>Estudiante</th>
            <th>Tipo</th>
            <th>Mensaje</th>
            <th>Fecha</th>
        </tr>

        <?php while($a = $alertas->fetch_assoc()): ?>
            <tr>
                <td><?php echo $a['nombre']; ?></td>
                <td><?php echo $a['tipo']; ?></td>
                <td><?php echo $a['mensaje']; ?></td>
                <td><?php echo $a['fecha']; ?></td>
            </tr>
        <?php endwhile; ?>

    </table>

<?php else: ?>
    <p>No hay alertas generadas.</p>
<?php endif; ?>

<?php endif; ?>

<br>
<a href="../controllers/logout.php">Cerrar sesión</a>
