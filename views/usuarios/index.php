<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>

    <header>
        <h1>📋 Gestión de Usuarios</h1>
    </header>

    <div class="container">

        <a class="btn btn-success" href="/recreo/controllers/usuarios.php?action=create">➕ Crear Usuario</a>
        <br><br>

        <?php if (empty($usuarios)): ?>
            <p>No hay usuarios registrados.</p>
        <?php else: ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['id']) ?></td>
                            <td><?= htmlspecialchars($u['nombre']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td>
                                <?php
                                // ✅ Mostrar badge según el rol
                                $rol_nombre = $u['rol_nombre'] ?? 'Sin rol';
                                $badge_class = 'badge ';

                                // Mapeo de IDs a clases CSS
                                switch ($u['rol_id']) {
                                    case 1:
                                        $badge_class .= 'badge-admin';
                                        break;      // admin
                                    case 2:
                                        $badge_class .= 'badge-docente';
                                        break;    // docente
                                    case 3:
                                        $badge_class .= 'badge-director';
                                        break;   // director
                                    case 4:
                                        $badge_class .= 'badge-estudiante';
                                        break; // estudiante
                                    default:
                                        $badge_class .= 'badge-admin';
                                }
                                ?>
                                <span class="<?= $badge_class ?>">
                                    <?= htmlspecialchars($rol_nombre) ?>
                                </span>
                            </td>

                            <td>
                                <a class="btn" href="/recreo/controllers/usuarios.php?action=edit&id=<?= $u['id'] ?>">
                                    ✏ Editar
                                </a>

                                <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                    <a class="btn btn-danger"
                                        href="/recreo/controllers/usuarios.php?action=delete&id=<?= $u['id'] ?>"
                                        onclick="return confirm('¿Eliminar usuario <?= htmlspecialchars($u['nombre']) ?>?');">
                                        🗑 Eliminar
                                    </a>
                                <?php else: ?>
                                    <span style="color: #999; font-size: 12px;">(Tu cuenta)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>

        <br>
        <a class="btn" href="/recreo/views/dashboard.php">⬅ Volver al Dashboard</a>
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