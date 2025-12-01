<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">


</head>

<body>

    <header>
        <h1>Crear Nuevo Usuario</h1>
    </header>

    <div class="container2">

        <form method="POST" action="/recreo/controllers/usuarios.php?action=store">

            <label>Nombre: <span class="required">*</span></label>
            <input type="text" name="nombre" required placeholder="Ej: Juan Pérez">

            <label>Email: <span class="required">*</span></label>
            <input type="email" name="email" required placeholder="usuario@ejemplo.com">

            <label>Contraseña: <span class="required">*</span></label>
            <input type="password" name="password" required minlength="6" placeholder="Mínimo 6 caracteres">

            <label>Rol: <span class="required">*</span></label>
            <select name="rol_id" required>
                <option value="">-- Seleccione un rol --</option>
                <?php foreach ($roles as $r): ?>
                    <option value="<?= $r['id'] ?>">
                        <?= htmlspecialchars($r['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">💾 Guardar Usuario</button>
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