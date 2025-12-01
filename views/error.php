<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Error</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .error-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        h2 {
            color: #d9534f;
        }

        p {
            font-size: 16px;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #0275d8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background: #025aa5;
        }
    </style>
</head>

<body>

    <div class="error-box">
        <h2>⚠ Error</h2>

        <p>
            <?php
            echo isset($_GET['msg'])
                ? htmlspecialchars($_GET['msg'])
                : "Ha ocurrido un error inesperado.";
            ?>
        </p>

        <a href="../views/dashboard.php">Volver al Dashboard</a>
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