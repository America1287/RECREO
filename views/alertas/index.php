<h2>Alertas Automáticas</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Estudiante</th>
        <th>Tipo de Falta</th>
        <th>Cantidad</th>
        <th>Fecha</th>
        <th>Acción</th>
    </tr>

    <?php while ($a = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($a['id']) ?></td>
        <td><?= htmlspecialchars($a['estudiante']) ?></td>
        <td><?= htmlspecialchars($a['tipo']) ?></td>
        <td><?= htmlspecialchars($a['cantidad']) ?></td>
        <td><?= htmlspecialchars($a['fecha']) ?></td>
        <td>
            <a href="/recreo/controllers/alertas.php?action=delete&id=<?= $a['id'] ?>"
               onclick="return confirm('¿Eliminar alerta?')">🗑 Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<br>
<a href="/recreo/views/dashboard.php">⬅ Volver</a>