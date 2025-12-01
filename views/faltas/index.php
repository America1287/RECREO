<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faltas</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>

    <h1>Listado de Faltas</h1>

    <form method="GET" action="">
        <input type="hidden" name="action" value="index">

        <label>
            <h2>Filtrar por categoría:</h2>
        </label>
        <select name="tipo" onchange="this.form.submit()">
            <option value="">Todas</option>
            <option value="Tipo 1" <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'Tipo 1') ? 'selected' : '' ?>>Tipo 1</option>
            <option value="Tipo 2" <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'Tipo 2') ? 'selected' : '' ?>>Tipo 2</option>
            <option value="Tipo 3" <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'Tipo 3') ? 'selected' : '' ?>>Tipo 3</option>
        </select>
    </form>
    <br>

    <div class="container">

        <a class="btn" href="/recreo/controllers/faltas.php?action=create">Registrar Nueva Falta</a>
        <br><br>

        <table class="alineacion 2" id="central" style="font-size: 12px; width: 100%;" border="1" cellpadding="8">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['estudiante_nombre']) ?></td>
                    <td><?= htmlspecialchars($row['estudiante_apellido']) ?></td>
                    <td><?= htmlspecialchars($row['tipo']) ?></td>
                    <td><?= htmlspecialchars($row['descripcion']) ?></td>
                    <td><?= htmlspecialchars($row['fecha']) ?></td>
                    <td>
                        <a class="btn btn-warning" href="/recreo/controllers/faltas.php?action=edit&id=<?= $row['id'] ?>">✏ Editar</a>
                        <a class="btn btn-danger" href="/recreo/controllers/faltas.php?action=delete&id=<?= $row['id'] ?>"
                            onclick="return confirm('¿Eliminar falta?')">🗑 Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

    </div>

    <br>
    <a class="boton" href="/recreo/views/dashboard.php">⬅ Volver</a>

</body>
<footer>
    <p>Institución Educativa Compartir &copy; 2025</p>
    <address>
        <p>Cl. 26 Sur #3c Sur10 No 5B Soacha, Cundinamarca</p>
    </address>
    <p>Software y Soluciones B.O.</p>
</footer>

</html>