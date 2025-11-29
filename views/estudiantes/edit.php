<h2>Editar Estudiante</h2>

<form action="/recreo/controllers/estudiantes.php?action=update" method="POST">

    <input type="hidden" name="id" value="<?= $est['id'] ?>">

    Nombre:
    <input type="text" name="nombre" value="<?= htmlspecialchars($est['nombre']) ?>" required><br>

    Grado:
    <input type="text" name="grado" value="<?= htmlspecialchars($est['grado']) ?>" required><br><br>

    <button type="submit">Actualizar</button>
</form>

<br>
<a href="/recreo/controllers/estudiantes.php?action=index">⬅ Volver</a>