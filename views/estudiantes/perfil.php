<?php
// =====================================
//   PERFIL DEL ESTUDIANTE - RECREO
// =====================================

// Validar que llega el ID
if (!isset($_GET['id'])) {
    echo "ID del estudiante no proporcionado.";
    exit;
}

$id = $_GET['id'];

// Cargar el modelo
require_once "../../config/database.php";
require_once "../../models/Estudiante.php";

$estudianteModel = new Estudiante($db);
$estudiante = $estudianteModel->obtenerPorId($id);

if (!$estudiante) {
    echo "Estudiante no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil del Estudiante</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 60%;
            margin: auto;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .campo {
            margin-bottom: 10px;
            font-size: 17px;
        }

        .campo span {
            font-weight: bold;
        }

        .acciones {
            margin-top: 25px;
            text-align: center;
        }

        .btn {
            padding: 10px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 5px;
            display: inline-block;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>

</head>

<body>

    <div class="card">

        <h2>Perfil del Estudiante</h2>

        <div class="campo"><span>Nombre:</span> <?php echo $estudiante['nombre']; ?></div>
        <div class="campo"><span>Documento:</span> <?php echo $estudiante['documento']; ?></div>
        <div class="campo"><span>Curso:</span> <?php echo $estudiante['curso']; ?></div>
        <div class="campo"><span>Acudiente:</span> <?php echo $estudiante['acudiente']; ?></div>
        <div class="campo"><span>Teléfono del acudiente:</span> <?php echo $estudiante['telefono_acudiente']; ?></div>

        <div class="acciones">

            <!-- Ver consolidado -->
            <a class="btn" href="consolidado.php?id=<?php echo $estudiante['id']; ?>">
                Ver Consolidado
            </a>

            <!-- Reporte PDF -->
            <a class="btn"
                href="../../controllers/reportes.php?tipo=pdf_estudiante&id=<?php echo $estudiante['id']; ?>">
                Descargar PDF
            </a>

            <!-- Reporte Excel -->
            <a class="btn"
                href="../../controllers/reportes.php?tipo=excel_estudiante&id=<?php echo $estudiante['id']; ?>">
                Descargar Excel
            </a>

            <!-- Volver -->
            <br><br>
            <a class="btn" href="javascript:history.back();">Volver</a>

        </div>

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