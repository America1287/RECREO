<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <h1 class="encabezado"><strong>Registro Estudiantil de Convivencia, Retardos y Observaciones (RECREO)</strong></h1>
    </header>

    <form class="login" id="content" action="../controllers/auth.php" method="POST">
        <img src="../imagenes/Imagen final.PNG" alt="Escudo del colegio" width="120px"><br>

        <h2>Iniciar Sesión</h2>
        <img src="../imagenes/usuario1.PNG" alt="Icono usuario" width="50px" id="icon1">
        <input type="email" name="email" placeholder="Correo" required><br>
        <label><strong>Usuario</strong></label><br>

        <img src="../imagenes/contrasena.PNG" alt="Icono contraseña" width="30px" id="icon2">
        <input type="password" name="password" placeholder="Contraseña" required><br>
        <label><strong>Contraseña</strong></label><br>

        <button type="submit" id="logeo">Ingresar</button>
    </form>
</body>
<footer>
    <p>Institución Educativa Compartir &copy; 2025</p>
    <address>
        <p>Cl. 26 Sur #3c Sur10 No 5B Soacha, Cundinamarca</p>
    </address>
    <p>Software y Soluciones B.O.</p>
</footer>

</html>