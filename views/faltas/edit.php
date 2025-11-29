<h2>Editar Falta</h2>

<form action="/recreo/controllers/faltas.php?action=update" method="POST">

    <input type="hidden" name="id" value="<?= $falta['id'] ?>">

    <label>Estudiante:</label>
    <select name="estudiante_id" required>
        <?php while ($e = $estudiantes->fetch_assoc()): ?>
            <option value="<?= $e['id'] ?>"
                <?= $e['id'] == $falta['estudiante_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($e['nombre']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <br><br>

    <label>Tipo de Falta:</label>
    <select name="tipo" required>
        <option value="Tipo 1" <?= $falta['tipo']=='Tipo 1'?'selected':'' ?>>Tipo 1</option>
        <option value="Tipo 2" <?= $falta['tipo']=='Tipo 2'?'selected':'' ?>>Tipo 2</option>
        <option value="Tipo 3" <?= $falta['tipo']=='Tipo 3'?'selected':'' ?>>Tipo 3</option>
    </select>

    <br><br>

    <label>Descripción:</label>
    <textarea name="descripcion" required><?= htmlspecialchars($falta['descripcion']) ?></textarea>

    <br><br>

    <button type="submit">Actualizar</button>
</form>

<br>
<a href="/recreo/controllers/faltas.php?action=index">⬅ Volver</a>