<h2>Registrar Falta</h2>

<form action="/recreo/controllers/faltas.php?action=store" method="POST">

    <label>Estudiante:</label>
    <select name="estudiante_id" required>
        <option value="">-- Seleccione un estudiante --</option>
        <?php while ($e = $estudiantes->fetch_assoc()): ?>
            <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
        <?php endwhile; ?>
    </select>

    <br><br>

<label>Tipo de Falta:</label>
<select name="tipo" required>
    <option value="Tipo 1">Tipo 1</option>
    <option value="Tipo 2">Tipo 2</option>
    <option value="Tipo 3">Tipo 3</option>
</select>

    <br><br>

    <label>Descripción:</label>
    <textarea name="descripcion" required></textarea>

    <br><br>

    <button type="submit">Guardar</button>
</form>

<br>
<a href="/recreo/controllers/faltas.php?action=index">⬅ Volver</a>