<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema RECREO Editar</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>
    <header class="encabezado">
        <h1>Editar Estudiante</h1>
    </header>

    <div class="container2">

        <form action="/recreo/controllers/estudiantes.php?action=update" method="POST">

            <input type="hidden" name="id" value="<?= $est['id'] ?>">

            <label>Nombre:<span class="required">*</label>
            <input style="width: 400px;" type="text" name="nombre" value="<?= htmlspecialchars($est['nombre']) ?>" required><br>

            <label>Apellido:<span class="required">*</label>
            <input style="width: 400px;" type="text" name="apellido" value="<?= htmlspecialchars($est['apellido']) ?>" required><br>

            <label>Grado:<span class="required">*</label>
            <input style="width: 400px;" type="text" name="grado" value="<?= htmlspecialchars($est['grado']) ?>" required><br>

            <label>Documento:<span class="required">*</label>
            <input style="width: 400px;" type="number" name="documento" value="<?= htmlspecialchars($est['documento']) ?>" required><br><br>

            <button class="btn btn-success" type="submit">Actualizar</button>
        </form>
    </div>

    <br>
    <a class="boton" href="/recreo/controllers/estudiantes.php?action=index">⬅ Volver</a>

</body>
<footer>
    <p>Institución Educativa Compartir &copy; 2025</p>
    <address>
        <p>Cl. 26 Sur #3c Sur10 No 5B Soacha, Cundinamarca</p>
    </address>
    <p>Software y Soluciones B.O.</p>
</footer>

</html>