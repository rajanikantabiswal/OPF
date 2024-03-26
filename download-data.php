<?php
include 'db.php';


$sql = "SELECT * FROM  where is_payment_done = '1'"; // Replace with your table name
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Set headers for Excel file
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=exported_data.xls");

    // Create a file pointer
    $file = fopen('php://output', 'w');

    // Output column headers
    $row = $result->fetch_assoc();
    fputcsv($file, array_keys($row), "\t");

    // Output data rows
    fputcsv($file, $row, "\t");
    while ($row = $result->fetch_assoc()) {
        fputcsv($file, $row, "\t");
    }

    // Close file pointer
    fclose($file);
} else {
    echo "No data found";
}

?>