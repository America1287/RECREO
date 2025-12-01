<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema RECREO - Alertas</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

    <header>
        <h1 class="encabezado">Alertas Automáticas</h1>
    </header>

    <div class="container">
        <table border="1" cellpadding="8">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Tipo de Falta</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>

            <?php while ($a = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($a['id']) ?></td>
                    <td><?= htmlspecialchars($a['estudiante_nombre']) ?></td>
                    <td><?= htmlspecialchars($a['estudiante_apellido']) ?></td>
                    <td><?= htmlspecialchars($a['tipo']) ?></td>
                    <td><?= htmlspecialchars($a['cantidad']) ?></td>
                    <td><?= htmlspecialchars($a['fecha']) ?></td>
                    <td>
                        <a class="btn btn-danger" href="/recreo/controllers/alertas.php?action=delete&id=<?= $a['id'] ?>"
                            onclick="return confirm('¿Eliminar alerta?')">
                            🗑
                        </a>
                        <p style="font-size: 12px;"> Eliminar</p>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <br>
    <a href="/recreo/views/dashboard.php" class="boton">⬅ Volver</a>

</body>
<footer>
    <p>Institución Educativa Compartir &copy; 2025</p>
    <address>
        <p>Cl. 26 Sur #3c Sur10 No 5B Soacha, Cundinamarca</p>
    </address>
    <p>Software y Soluciones B.O.</p>
</footer>

</html>