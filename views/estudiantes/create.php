<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema RECREO Crear</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">


</head>

<body>
    <header>
        <h1>Crear Estudiante</h1>
    </header>

    <div class="container2">
        <form action="/recreo/controllers/estudiantes.php?action=store" method="POST">

            Nombre:
            <input type="text" name="nombre" required><br>

            Apellido:
            <input type="text" name="apellido" required><br>

            Grado:
            <input type="text" name="grado" required><br>

            Documento:
            <input type="number" name="documento" required><br><br>

            <button type="submit">Guardar</button>
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