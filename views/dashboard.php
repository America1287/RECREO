<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol_id'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Sistema Recreo</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>

    <header class="encabezado">
        <p>
        <h1>Bienvenido, <?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?></h1>
        </p>
        <div>
            <p>Rol:
                <?php
                if ($rol == 1) echo "Administrador";
                elseif ($rol == 2) echo "Docente";
                elseif ($rol == 3) echo "Director";
                elseif ($rol == 4) echo "Estudiante";
                ?>
            </p>
        </div>
    </header>

    <section id="contenedor2">
        <div class="alineacion2" id="lado1">
            <!-- MENÚ DINÁMICO SEGÚN ROL -->
            <?php if ($rol == 1): ?>
                <h3>Menú Administrador</h3>
                <div class="organizacion">
                    <a href="../controllers/estudiantes.php"><button class="submenu"><img src="../imagenes/student (1).svg" alt="Gestionar estudiantes" width="50px"></button></a>
                    <p>Gestionar<br> Estudiantes</p>
                    <br>
                </div>
                <div class="organizacion">
                    <a href="/recreo/controllers/usuarios.php?action=index"><button class="submenu"><img src="../imagenes/user-switch.svg" alt="Gestionar estudiantes" width="50px"></button></a>
                    <p>Gestionar<br> Usuarios</p>
                    <br>
                </div>
                <div class="organizacion">
                    <a href="/recreo/controllers/faltas.php?action=index"><button class="submenu"><img src="../imagenes/note-pencil.svg" alt="Gestionar estudiantes" width="50px"></button></a>
                    <p>Gestionar<br> Faltas</p>
                    <br>
                </div>
                <div class="organizacion">
                    <a href="/recreo/controllers/alertas.php?action=index"><button class="submenu"><img src="../imagenes/file-magnifying-glass.svg" alt="Gestionar estudiantes" width="50px"></button></a>
                    <p>Ver<br> Alertas</p>
                    <br>
                </div>

            <?php elseif ($rol == 2): ?>
                <h3>Menú Docente</h3>
                <div class="organizacion">
                    <a href="/recreo/controllers/estudiantes.php?action=index"><button class="submenu"><img src="../imagenes/student (1).svg" alt="Gestionar estudiantes" width="50px"></button></a>
                    <p>Ver<br> Estudiantes</p>
                    <br>
                </div>
                <div class="organizacion">
                    <a href="/recreo/controllers/faltas.php?action=index"><button class="submenu"><img src="../imagenes/student (1).svg" alt="Gestionar estudiantes" width="50px"></button></a>
                    <p>Registrar<br> Faltas</p>
                    <br>
                </div>
                <div class="organizacion">
                    <a href="/recreo/controllers/alertas.php?action=index"><button class="submenu"><img src="../imagenes/student (1).svg" alt="Gestionar estudiantes" width="50px"></button></a>
                    <p>Ver<br> Alertas</p>
                    <br>
                </div>

            <?php elseif ($rol == 3): ?>
                <h3>Menú Director</h3>
                <div class="organizacion">
                    <a href="/recreo/controllers/estudiantes.php?action=index"><button class="submenu"><img src="../imagenes/student (1).svg" alt="Gestionar estudiantes" width="50px"></button></a>
                    <p>Ver<br> Estudiantes</p>
                    <br>
                </div>
                <div class="organizacion">
                    <a href="/recreo/controllers/faltas.php?action=index"><button class="submenu"><img src="../imagenes/student (1).svg" alt="Gestionar estudiantes" width="50px"></button></a>
                    <p>Ver<br> Faltas</p>
                    <br>
                </div>
                <div class="organizacion">
                    <a href="/recreo/controllers/alertas.php?action=index"><button class="submenu"><img src="../imagenes/student (1).svg" alt="Gestionar estudiantes" width="50px"></button></a>
                    <p>Ver<br> Alertas</p>
                    <br>
                </div>

            <?php elseif ($rol == 4): ?>
                <h3>Menú Estudiante</h3>
                <div class="organizacion">
                    <a href="#"><button class="submenu"><img src="../imagenes/student (1).svg" alt="Gestionar estudiantes" width="50px"></button></a>
                    <p>Mi historial de faltas</p>
                    <br>
                </div>

            <?php endif; ?>
            <br><br>
            <a class="boton" href="/recreo/controllers/logout.php">Cerrar sesión</a>
        </div>

        <div class="alineacion2" id="central">

            <!-- SECCIÓN DE ALERTAS (Solo para Admin, Docente y Director) -->
            <?php if (in_array($_SESSION['rol_id'], [1, 2, 3])): ?>

                <h3>Alertas Generadas</h3>

                <div class="container">

                    <!-- ✅ FILTRO POR CATEGORÍA Y FECHAS -->
                    <form method="GET" action="" style="font-size: small; text-align: left;">
                        <label>Tipo:</label>
                        <select name="tipo">
                            <option value="">Todos</option>
                            <option value="Tipo 1" <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'Tipo 1') ? 'selected' : '' ?>>Tipo 1</option>
                            <option value="Tipo 2" <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'Tipo 2') ? 'selected' : '' ?>>Tipo 2</option>
                            <option value="Tipo 3" <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'Tipo 3') ? 'selected' : '' ?>>Tipo 3</option>
                        </select>

                        <label>Desde:</label>
                        <input type="date" name="fecha_inicio" value="<?= $_GET['fecha_inicio'] ?? '' ?>">

                        <label>Hasta:</label>
                        <input type="date" name="fecha_fin" value="<?= $_GET['fecha_fin'] ?? '' ?>">

                        <button type="submit">Filtrar</button>
                        <a href="dashboard.php">Limpiar filtros</a>
                    </form>

                </div>

                <br>

                <?php
                // ✅ Cargar conexión y funciones
                require_once "../config/database.php";
                require_once "../config/functions.php";

                // ✅ Obtener filtros
                $tipo = $_GET['tipo'] ?? null;
                $fecha_inicio = $_GET['fecha_inicio'] ?? null;
                $fecha_fin = $_GET['fecha_fin'] ?? null;

                // ✅ Obtener alertas filtradas
                $alertas = getAlertasPorFiltro($conn, $tipo, $fecha_inicio, $fecha_fin);

                if ($alertas->num_rows > 0):
                ?>
                    <table border="1" cellspacing="0" cellpadding="5" style="font-size: small; align-items: center;" ;>
                        <tr>
                            <th>Estudiante</th>
                            <th>Apellido</th>
                            <th>Tipo</th>
                            <th>Mensaje</th>
                            <th>Fecha</th>
                        </tr>

                        <?php while ($a = $alertas->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($a['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($a['apellido'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($a['tipo'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($a['mensaje'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($a['fecha'], ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>

                <?php else: ?>
                    <p>No hay alertas generadas<?= $tipo ? ' para los filtros seleccionados' : '' ?></p>
                <?php endif; ?>


        </div>
        <hr>
        <div class="alineacion" id="lado2">
            <!-- ✅ SECCIÓN DE REPORTES -->
            <h3>Generar Reportes</h3>

            <?php
                // Obtener filtros activos para los reportes
                $categoria = isset($_GET['tipo']) ? $_GET['tipo'] : '';
                $desde     = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
                $hasta     = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';
            ?>


            <h4>Reportes de Estudiantes:</h4>

            <!-- Reporte PDF de Estudiantes -->
            <div class="organizacion">
                <a href="/recreo/controllers/reportes.php?action=pdf_estudiantes"
                    class="btn btn-danger"
                    target="_blank">
                    📄
                </a>
                <p style="font-size: 12px;">PDF de <br>Estudiantes</p>
            </div>

            <!-- ✅ Reporte EXCEL de Estudiantes -->
            <div class="organizacion">
                <a href="/recreo/controllers/reportes.php?action=excel_estudiantes"
                    class="btn btn-success"
                    target="_blank">
                    📊
                </a>
                <p style="font-size: 12px;">Excel de <br>Estudiantes</p>
            </div>
            <br>
            <br>



            <h4>Reportes de Faltas (con filtros aplicados):</h4>

            <!-- Reporte PDF de Faltas -->
            <div class="organizacion">
                <a href="/recreo/controllers/reportes.php?tipo=pdf&categoria=<?= urlencode($categoria) ?>&desde=<?= urlencode($desde) ?>&hasta=<?= urlencode($hasta) ?>"
                    class="btn btn-danger"
                    target="_blank">
                    📄
                </a>
                <p style="font-size: 12px;">PDF de <br>Faltas</p>
            </div>

            <!-- Reporte Excel de Faltas -->
            <div class="organizacion">
                <a href="/recreo/controllers/reportes.php?tipo=excel&categoria=<?= urlencode($categoria) ?>&desde=<?= urlencode($desde) ?>&hasta=<?= urlencode($hasta) ?>"
                    class="btn btn-success"
                    target="_blank">
                    📊
                </a>
                <p style="font-size: 12px;">Excel de <br> Faltas</p>
            </div>

        <?php endif; ?>
        </div>

    </section>
</body>
<footer>
    <p>Institución Educativa Compartir &copy; 2025</p>
    <address>
        <p>Cl. 26 Sur #3c Sur10 No 5B Soacha, Cundinamarca</p>
    </address>
    <p>Software y Soluciones B.O.</p>
</footer>

</html>