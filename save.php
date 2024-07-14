<?php
header("Content-Type:application/json");
error_reporting(0);
require "connexion.php";
$connexion = new DB;// connect to the database 
$conn = $connexion->connexion();

require 'vendor/autoload.php';
use Smalot\PdfParser\Parser;
$valid = array('success' => false,'messages'=>array());

// Function to extract table data from the PDF text, excluding the first line
function extractTableData($text) {
    $lines = explode("\n", $text);

    // Extract header (first line)
    $header = preg_split('/\s+/', trim($lines[0]));

    // Remove the first line (header)
    array_shift($lines);

    $data = [];
    foreach ($lines as $line) {
        $data[] = preg_split('/\s+/', trim($line));
    }

    return array($header, $data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["pdf_file"])) {
    $pdfFile = $_FILES["pdf_file"]["tmp_name"];
    $parser = new Parser();
    $pdf = $parser->parseFile($pdfFile);
    $text = $pdf->getText();

    // Extract data from the table in the PDF file
    list($header, $tableData) = extractTableData($text);

    // Create a new table based on the extracted column names
    $tableName = "users"; // Generate a unique table name
    $sqlCreateTable = "CREATE TABLE IF NOT EXISTS $tableName (u_22id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY";

    foreach ($header as $column) {
        $sqlCreateTable .= ", `" . $column . "` VARCHAR(255)";
    }

    $sqlCreateTable .= ", created_at  timestamp NOT NULL DEFAULT current_timestamp() , modified_at datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()";

    $sqlCreateTable .= ")";
    if ($conn->query($sqlCreateTable) === TRUE) {
        // table created succefully .
    } else {
        $valid['success'] = false;
        $valid['messages'] = "Error while creating table!";
    }

    $sqlInsertData = "INSERT IGNORE INTO $tableName (".implode(',', $header).") VALUES (".str_repeat('?,', count($header) - 1)."?)";
    $stmt = $conn->prepare($sqlInsertData);

    foreach ($tableData as $row) {
        if (count($row) == count($header)) {
            // Bind each value from the row to the statement
            $stmt->bind_param(str_repeat("s", count($header)), ...$row);
            $stmt->execute();
        } else {
            $valid['success'] = false;
            $valid['messages'] = "Error!";
        }
    }

    $valid['success'] = true;
    $valid['messages'] = "Data inserted succefully !";
   
    $stmt->close();
    $conn->close();

    echo json_encode($valid);
}
?>