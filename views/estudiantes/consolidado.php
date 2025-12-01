<!-- <?php session_start(); ?> -->
<!DOCTYPE html>
<html>

<head>
    <title>Sistema RECREO Consolidado</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">


</head>

<body>


    <h2>Consolidado del Estudiante</h2>

    <p><strong>Nombre:</strong> <?php echo $estudiante['nombre']; ?></p>
    <!-- <p><strong>Documento:</strong> <?php echo $estudiante['documento']; ?></p> -->

    <h3>Faltas Registradas</h3>
    <table class="alineacion 2" id="central">
        <tr>
            <th>Tipo de Falta</th>
            <th>Total</th>
        </tr>

        <?php foreach ($resumen_faltas as $fila): ?>
            <tr>
                <td><?php echo $fila['tipo']; ?></td>
                <td><?php echo $fila['total']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Alertas Generadas</h3>
    <table class="alineacion 2" id="central">
        <tr>
            <th>Tipo</th>
            <th>Cantidad</th>
            <th>Fecha</th>
        </tr>

        <?php foreach ($alertas as $al): ?>
            <tr>
                <td><?php echo $al['tipo']; ?></td>
                <td><?php echo $al['cantidad']; ?></td>
                <td><?php echo $al['fecha']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>

    <!-- Botones para reportes
    <a class="btn" href="/recreo/controllers/reportes.php?action=pdf_consolidado&id=<?php echo $estudiante['id']; ?>">Descargar PDF Individual</a>
    <a class="btn" href="/recreo/controllers/reportes.php?action=excel_consolidado&id=<?php echo $estudiante['id']; ?>">Descargar Excel Individual</a> -->



    <br><br>
    <a href="javascript:history.back();" class="btn">Volver</a>

</body>
<footer>
    <p>Institución Educativa Compartir &copy; 2025</p>
    <address>
        <p>Cl. 26 Sur #3c Sur10 No 5B Soacha, Cundinamarca</p>
    </address>
    <p>Software y Soluciones B.O.</p>
</footer>

</html>