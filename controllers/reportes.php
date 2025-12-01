<?php
// ====================================================
//  ARCHIVO DE REPORTES - SISTEMA RECREO
// ====================================================
session_start();

// Verificar sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: /recreo/views/login.php");
    exit;
}

// Verificar permisos (solo Admin, Docente, Director)
if (!in_array($_SESSION['rol_id'], [1, 2, 3])) {
    die("No tienes permisos para acceder a esta sección");
}

// Conexión MySQLi global
require_once __DIR__ . '/../config/database.php';  // carga $conn

// ✅ IMPORTANTE: Incluir FPDF para PDF
require_once __DIR__ . '/../public/libs/fpdf/fpdf.php';

// ✅ IMPORTANTE: Incluir PhpSpreadsheet para Excel
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;


// ====================================================
//  CONTROLADOR PRINCIPAL DE REPORTES
// ====================================================
class ReportesController
{

    // ✅ Obtener faltas con filtros opcionales (CONSULTAS PREPARADAS)
    public static function obtenerFaltas($conn, $categoria = null, $desde = null, $hasta = null)
    {
        $sql = "SELECT f.*, e.nombre AS estudiante_nombre, e.apellido AS estudiante_apellido 
                FROM faltas f
                JOIN estudiantes e ON f.estudiante_id = e.id
                WHERE 1=1";

        $types = "";
        $params = [];

        if ($categoria) {
            $sql .= " AND f.tipo = ?";
            $types .= "s";
            $params[] = $categoria;
        }

        if ($desde && $hasta) {
            $sql .= " AND DATE(f.fecha) BETWEEN ? AND ?";
            $types .= "ss";
            $params[] = $desde;
            $params[] = $hasta;
        }

        $sql .= " ORDER BY f.fecha DESC";

        // ✅ Si no hay filtros, ejecutar consulta directa
        if (empty($params)) {
            return $conn->query($sql);
        }

        // ✅ Si hay filtros, usar consulta preparada
        $stmt = $conn->prepare($sql);

        if ($types) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result();
    }
}


// ====================================================
//  GENERAR REPORTE PDF DE FALTAS
// ====================================================
if (isset($_GET['tipo']) && $_GET['tipo'] == 'pdf') {

    $categoria = $_GET['categoria'] ?? null;
    $desde     = $_GET['desde'] ?? null;
    $hasta     = $_GET['hasta'] ?? null;

    $resultado = ReportesController::obtenerFaltas($conn, $categoria, $desde, $hasta);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 10, "Reporte de Faltas", 0, 1, 'C');
    $pdf->Ln(5);

    // Mostrar filtros aplicados
    $pdf->SetFont('Arial', '', 10);
    if ($categoria) {
        $pdf->Cell(0, 5, "Categoria: $categoria", 0, 1);
    }
    if ($desde && $hasta) {
        $pdf->Cell(0, 5, "Periodo: $desde al $hasta", 0, 1);
    }
    $pdf->Ln(5);

    // Encabezados
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(50, 10, "Estudiante", 1);
    $pdf->Cell(30, 10, "Tipo", 1);
    $pdf->Cell(40, 10, "Fecha", 1);
    $pdf->Cell(70, 10, "Descripcion", 1);
    $pdf->Ln();

    // Contenido
    $pdf->SetFont('Arial', '', 9);
    while ($fila = $resultado->fetch_assoc()) {
        // Nombre completo: Nombre + Apellido
        $nombre_completo = $fila['estudiante_nombre'] . ' ' . $fila['estudiante_apellido'];
        $pdf->Cell(50, 10, utf8_decode($nombre_completo), 1);
        $pdf->Cell(30, 10, utf8_decode($fila['tipo']), 1);
        $pdf->Cell(40, 10, $fila['fecha'], 1);

        // ✅ Usar 'descripcion' en lugar de 'detalle'
        $descripcion = substr($fila['descripcion'], 0, 40); // Limitar caracteres
        $pdf->Cell(70, 10, utf8_decode($descripcion), 1);
        $pdf->Ln();
    }

    $pdf->Output('I', 'reporte_faltas.pdf');
    exit;
}


// ====================================================
//  ✅ GENERAR REPORTE EXCEL DE FALTAS (PhpSpreadsheet)
// ====================================================
if (isset($_GET['tipo']) && $_GET['tipo'] == 'excel') {

    $categoria = $_GET['categoria'] ?? null;
    $desde     = $_GET['desde'] ?? null;
    $hasta     = $_GET['hasta'] ?? null;

    $resultado = ReportesController::obtenerFaltas($conn, $categoria, $desde, $hasta);

    // Crear nuevo Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Configurar propiedades del documento
    $spreadsheet->getProperties()
        ->setCreator("Sistema Recreo")
        ->setTitle("Reporte de Faltas")
        ->setSubject("Reporte de Faltas Disciplinarias")
        ->setDescription("Reporte generado automáticamente");

    // ===== TÍTULO =====
    $sheet->setCellValue('A1', 'REPORTE DE FALTAS DISCIPLINARIAS');
    $sheet->mergeCells('A1:E1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // ===== INFORMACIÓN DE FILTROS =====
    $fila = 2;
    if ($categoria) {
        $sheet->setCellValue('A' . $fila, 'Categoría: ' . $categoria);
        $fila++;
    }
    if ($desde && $hasta) {
        $sheet->setCellValue('A' . $fila, 'Período: ' . $desde . ' al ' . $hasta);
        $fila++;
    }
    $sheet->setCellValue('A' . $fila, 'Fecha de generación: ' . date('d/m/Y H:i'));
    $fila += 2; // Espacio antes de los encabezados

    // ===== ENCABEZADOS =====
    $headerRow = $fila;
    $sheet->setCellValue('A' . $headerRow, 'ID');
    $sheet->setCellValue('B' . $headerRow, 'Estudiante');
    $sheet->setCellValue('C' . $headerRow, 'Tipo');
    $sheet->setCellValue('D' . $headerRow, 'Descripción');
    $sheet->setCellValue('E' . $headerRow, 'Fecha');

    // Estilo de encabezados
    $sheet->getStyle('A' . $headerRow . ':E' . $headerRow)->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'],
            'size' => 12
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => '4472C4']
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ]
    ]);

    // ===== DATOS =====
    $fila = $headerRow + 1;
    $contador = 1;

    while ($row = $resultado->fetch_assoc()) {
        // Nombre completo: Nombre + Apellido
        $nombre_completo = $row['estudiante_nombre'] . ' ' . $row['estudiante_apellido'];

        $sheet->setCellValue('A' . $fila, $contador);
        $sheet->setCellValue('B' . $fila, $nombre_completo);
        $sheet->setCellValue('C' . $fila, $row['tipo']);
        $sheet->setCellValue('D' . $fila, $row['descripcion']);
        $sheet->setCellValue('E' . $fila, $row['fecha']);

        // Alternar colores de filas
        if ($contador % 2 == 0) {
            $sheet->getStyle('A' . $fila . ':E' . $fila)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E7E6E6']
                ]
            ]);
        }

        // Bordes
        $sheet->getStyle('A' . $fila . ':E' . $fila)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC']
                ]
            ]
        ]);

        $fila++;
        $contador++;
    }

    // ===== AJUSTAR ANCHO DE COLUMNAS =====
    $sheet->getColumnDimension('A')->setWidth(8);
    $sheet->getColumnDimension('B')->setWidth(30);
    $sheet->getColumnDimension('C')->setWidth(15);
    $sheet->getColumnDimension('D')->setWidth(50);
    $sheet->getColumnDimension('E')->setWidth(15);

    // ===== TOTALES =====
    $fila++;
    $sheet->setCellValue('A' . $fila, 'TOTAL DE FALTAS:');
    $sheet->setCellValue('B' . $fila, $contador - 1);
    $sheet->getStyle('A' . $fila . ':B' . $fila)->getFont()->setBold(true);

    // ===== GENERAR Y DESCARGAR =====
    $filename = 'reporte_faltas_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}


// ====================================================
//  REPORTE PDF DE TODOS LOS ESTUDIANTES
// ====================================================
if (isset($_GET['action']) && $_GET['action'] === 'pdf_estudiantes') {
    generarPDFEstudiantes($conn);
}

function generarPDFEstudiantes($conn)
{
    $resultado = $conn->query("SELECT * FROM estudiantes ORDER BY nombre ASC");

    $pdf = new FPDF();
    $pdf->AddPage();

    // Título
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'REPORTE DE ESTUDIANTES', 0, 1, 'C');
    $pdf->Ln(5);

    // Información adicional
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, 'Fecha: ' . date('d/m/Y H:i'), 0, 1);
    $pdf->Cell(0, 5, 'Total estudiantes: ' . $resultado->num_rows, 0, 1);
    $pdf->Ln(5);

    // Encabezados
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20, 10, 'ID', 1);
    $pdf->Cell(80, 10, 'Nombre', 1);
    $pdf->Cell(40, 10, 'Grado', 1);
    $pdf->Ln();

    // Contenido
    $pdf->SetFont('Arial', '', 11);

    while ($e = $resultado->fetch_assoc()) {
        $pdf->Cell(20, 10, $e['id'], 1);
        $pdf->Cell(80, 10, utf8_decode($e['nombre']), 1);
        $pdf->Cell(40, 10, utf8_decode($e['grado']), 1);
        $pdf->Ln();
    }

    $pdf->Output("I", "reporte_estudiantes.pdf");
    exit;
}


// ====================================================
//  ✅ REPORTE EXCEL DE TODOS LOS ESTUDIANTES (PhpSpreadsheet)
// ====================================================
if (isset($_GET['action']) && $_GET['action'] === 'excel_estudiantes') {
    generarExcelEstudiantes($conn);
}

function generarExcelEstudiantes($conn)
{
    $resultado = $conn->query("SELECT * FROM estudiantes ORDER BY nombre ASC");

    // Crear nuevo Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Configurar propiedades del documento
    $spreadsheet->getProperties()
        ->setCreator("Sistema Recreo")
        ->setTitle("Reporte de Estudiantes")
        ->setSubject("Listado de Estudiantes")
        ->setDescription("Reporte generado automáticamente");

    // ===== TÍTULO =====
    $sheet->setCellValue('A1', 'REPORTE DE ESTUDIANTES');
    $sheet->mergeCells('A1:C1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // ===== INFORMACIÓN =====
    $sheet->setCellValue('A2', 'Fecha de generación: ' . date('d/m/Y H:i'));
    $sheet->setCellValue('A3', 'Total de estudiantes: ' . $resultado->num_rows);

    // ===== ENCABEZADOS =====
    $sheet->setCellValue('A5', 'ID');
    $sheet->setCellValue('B5', 'Nombre Completo');
    $sheet->setCellValue('C5', 'Grado');

    // Estilo de encabezados
    $sheet->getStyle('A5:C5')->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'],
            'size' => 12
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => '28A745']
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ]
    ]);

    // ===== DATOS =====
    $fila = 6;
    $contador = 0;

    while ($row = $resultado->fetch_assoc()) {
        $sheet->setCellValue('A' . $fila, $row['id']);
        $sheet->setCellValue('B' . $fila, $row['nombre']);
        $sheet->setCellValue('C' . $fila, $row['grado']);

        // Alternar colores de filas
        if ($contador % 2 == 0) {
            $sheet->getStyle('A' . $fila . ':C' . $fila)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E8F5E9']
                ]
            ]);
        }

        // Bordes
        $sheet->getStyle('A' . $fila . ':C' . $fila)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC']
                ]
            ]
        ]);

        $fila++;
        $contador++;
    }

    // ===== AJUSTAR ANCHO DE COLUMNAS =====
    $sheet->getColumnDimension('A')->setWidth(10);
    $sheet->getColumnDimension('B')->setWidth(40);
    $sheet->getColumnDimension('C')->setWidth(20);

    // Centrar columnas A y C
    $sheet->getStyle('A5:A' . ($fila - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('C5:C' . ($fila - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // ===== GENERAR Y DESCARGAR =====
    $filename = 'reporte_estudiantes_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
