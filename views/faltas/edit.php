<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Faltas</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

</head>

</head>

<body>

    <h1>Editar Falta</h1>
    <div class="container">
        <form style="width: 400px;" action="/recreo/controllers/faltas.php?action=update" method="POST">

            <input type="hidden" name="id" value="<?= $falta['id'] ?>">

            <label>Estudiante:</label>
            <select name="estudiante_id" required>
                <?php while ($e = $estudiantes->fetch_assoc()): ?>
                    <option value="<?= $e['id'] ?>"
                        <?= $e['id'] == $falta['estudiante_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($e['nombre']) ?>
                        <?= htmlspecialchars($e['apellido']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <br><br>

            <label>Tipo de Falta:</label>
            <select name="tipo" required>
                <option value="Tipo 1" <?= $falta['tipo'] == 'Tipo 1' ? 'selected' : '' ?>>Tipo 1</option>
                <option value="Tipo 2" <?= $falta['tipo'] == 'Tipo 2' ? 'selected' : '' ?>>Tipo 2</option>
                <option value="Tipo 3" <?= $falta['tipo'] == 'Tipo 3' ? 'selected' : '' ?>>Tipo 3</option>
            </select>

            <br><br>

            <label>Descripción:</label>
            <textarea cols="50" rows="10" name="descripcion" required><?= htmlspecialchars($falta['descripcion']) ?></textarea>

            <br><br>

            <button type="submit">Actualizar</button>
        </form>
    </div>
    <br>
    <a class="boton" href="/recreo/controllers/faltas.php?action=index">⬅ Volver</a>

</body>
<footer>
    <p>Institución Educativa Compartir &copy; 2025</p>
    <address>
        <p>Cl. 26 Sur #3c Sur10 No 5B Soacha, Cundinamarca</p>
    </address>
    <p>Software y Soluciones B.O.</p>
</footer>

</html>