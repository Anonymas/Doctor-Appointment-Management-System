<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../connection.php");

// Function to export data to Excel
function exportToExcel($data) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=appointments.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $sep = "\t";

    foreach ($data as $row) {
        echo implode($sep, $row) . "\n";
    }

    exit();
}

// Function to export data to PDF
function exportToPDF($data) {
    require_once('../tcpdf/tcpdf.php'); // Correct the path to TCPDF

    $pdf = new TCPDF();
    $pdf->AddPage();
    $html = '<h2>Appointments</h2><table border="1"><tr>';

    // Add headers only once
    $headers = $data[0];
    foreach ($headers as $heading) {
        $html .= "<th>$heading</th>";
    }
    $html .= '</tr>';

    // Add data rows
    foreach ($data as $index => $row) {
        if ($index === 0) continue; // Skip the first row as it is headers
        $html .= '<tr>';
        foreach ($row as $column) {
            $html .= "<td>$column</td>";
        }
        $html .= '</tr>';
    }

    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output('appointments.pdf', 'D');
    exit();
}

// Check if export data is set
if (isset($_POST['export_data'])) {
    $data = json_decode($_POST['export_data'], true);

    if ($data === null) {
        echo "Error decoding JSON data.";
        exit();
    }

    if (isset($_POST['export_excel'])) {
        exportToExcel($data);
    } elseif (isset($_POST['export_pdf'])) {
        exportToPDF($data);
    } else {
        echo "Invalid export action.";
    }
} else {
    echo "No data to export.";
}
?>
