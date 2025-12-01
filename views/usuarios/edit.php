<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">


</head>

<body>

    <header>
        <h1>✏ Editar Usuario</h1>
    </header>

    <div class="container2">

        <form method="POST" action="/recreo/controllers/usuarios.php?action=update">

            <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">

            <label>Nombre: <span class="required">*</span></label>
            <input type="text"
                name="nombre"
                value="<?= htmlspecialchars($usuario['nombre']) ?>"
                required>

            <label>Email: <span class="required">*</span></label>
            <input type="email"
                name="email"
                value="<?= htmlspecialchars($usuario['email']) ?>"
                required>

            <label>Nueva contraseña (opcional):</label>
            <input type="password" name="password" minlength="6" placeholder="Dejar vacío para no cambiar">
            <div class="info">
                💡 Solo completa este campo si deseas cambiar la contraseña actual
            </div>

            <label>Rol: <span class="required">*</span></label>
            <select name="rol_id" required>
                <?php foreach ($roles as $r): ?>
                    <option value="<?= $r['id'] ?>"
                        <?= $usuario['rol_id'] == $r['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">💾 Actualizar Usuario</button>
        </form>

        <a class="boton" href="/recreo/controllers/usuarios.php?action=index">⬅ Volver al listado</a>
    </div>

</body>
<footer>
    <p>Institución Educativa Compartir &copy; 2025</p>
    <address>
        <p>Cl. 26 Sur #3c Sur10 No 5B Soacha, Cundinamarca</p>
    </address>
    <p>Software y Soluciones B.O.</p>
</footer>

</html>