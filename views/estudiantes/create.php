<h2>Crear Estudiante</h2>

<form action="/recreo/controllers/estudiantes.php?action=store" method="POST">

    Nombre:
    <input type="text" name="nombre" required><br>

    Grado:
    <input type="text" name="grado" required><br><br>

    <button type="submit">Guardar</button>
</form>

<br>
<a href="/recreo/controllers/estudiantes.php?action=index">⬅ Volver</a>
