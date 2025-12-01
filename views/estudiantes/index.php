<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

    <h1>Listado de Estudiantes</h1>
    <br>
    <div class="container">
        <a class="btn" href="/recreo/controllers/estudiantes.php?action=create"> Nuevo Estudiante</a>
        <br>

        <table class="alineacion 2" id="central" style="font-size: 12px; width: 100%;" border="0" cellpadding="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Grado</th>
                <th>Documento</th>
                <th>Acciones</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td><?= htmlspecialchars($row['apellido']) ?></td>
                    <td><?= htmlspecialchars($row['grado']) ?></td>
                    <td><?= htmlspecialchars($row['documento']) ?></td>
                    <td>
                        <a class="btn btn-warning" href="/recreo/controllers/estudiantes.php?action=edit&id=<?= $row['id'] ?>">✏ Editar</a>

                        <a class="btn btn-danger" href="/recreo/controllers/estudiantes.php?action=delete&id=<?= $row['id'] ?>"
                            onclick="return confirm('¿Eliminar este estudiante?')">🗑 Eliminar</a>

                        <a class="btn btn-success" href="/recreo/controllers/estudiantes.php?action=consolidado&id=<?= $row['id'] ?>">Consolidado</a>



                    </td>
                </tr>
            <?php endwhile ?>
        </table>

    </div>

    <br><a class="boton" href="/recreo/views/dashboard.php">⬅ Volver</a>

</body>
<footer>
    <p>Institución Educativa Compartir &copy; 2025</p>
    <address>
        <p>Cl. 26 Sur #3c Sur10 No 5B Soacha, Cundinamarca</p>
    </address>
    <p>Software y Soluciones B.O.</p>
</footer>

</html>