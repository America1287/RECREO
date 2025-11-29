<h2>Listado de Faltas</h2>

<form method="GET" action="">
    <input type="hidden" name="action" value="index">

    <label>Filtrar por categoría:</label>
    <select name="tipo" onchange="this.form.submit()">
        <option value="">Todas</option>
        <option value="Tipo 1" <?= (isset($_GET['tipo']) && $_GET['tipo']=='Tipo 1')?'selected':'' ?>>Tipo 1</option>
        <option value="Tipo 2" <?= (isset($_GET['tipo']) && $_GET['tipo']=='Tipo 2')?'selected':'' ?>>Tipo 2</option>
        <option value="Tipo 3" <?= (isset($_GET['tipo']) && $_GET['tipo']=='Tipo 3')?'selected':'' ?>>Tipo 3</option>
    </select>
</form>

<hr>

<a href="/recreo/controllers/faltas.php?action=create">Registrar Nueva Falta</a>
<br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Estudiante</th>
        <th>Tipo</th>
        <th>Descripción</th>
        <th>Fecha</th>
        <th>Acciones</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><?= htmlspecialchars($row['estudiante_nombre']) ?></td>
        <td><?= htmlspecialchars($row['tipo']) ?></td>
        <td><?= htmlspecialchars($row['descripcion']) ?></td>
        <td><?= htmlspecialchars($row['fecha']) ?></td>
        <td>
            <a href="/recreo/controllers/faltas.php?action=edit&id=<?= $row['id'] ?>">✏ Editar</a> |
            <a href="/recreo/controllers/faltas.php?action=delete&id=<?= $row['id'] ?>"
               onclick="return confirm('¿Eliminar falta?')">🗑 Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<br>
<a href="/recreo/views/dashboard.php">⬅ Volver</a>