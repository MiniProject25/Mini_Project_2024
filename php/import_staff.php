<?php
session_start();
include 'db_connection.php';

// Include PhpSpreadsheet library
require 'C:/wamp64/www/vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file is uploaded
    if (isset($_FILES['staffFile']) && $_FILES['staffFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['staffFile']['tmp_name'];
        $fileName = $_FILES['staffFile']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed file extensions
        $allowedfileExtensions = array('csv', 'xlsx');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Load the spreadsheet
            if ($fileExtension === 'csv') {
                // Open the CSV file
                if (($handle = fopen($fileTmpPath, "r")) !== false) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                        // Sanitize and check if data exists before inserting
                        $empid = isset($data[0]) ? $data[0] : null;
                        $fname = isset($data[1]) ? $data[1] : null;
                        $bdept = isset($data[2]) ? $data[2] : null;
                        $entrykey = substr($empid,-5);

                        // Only proceed if $usn and $sname are notNull
                        if ($empid && $fname) {

                            if (is_numeric($empid)) {
                                $stmt = $conn->prepare("INSERT IGNORE INTO faculty (emp_id,fname,dept,entrykey) VALUES (?, ?, ?, ?)");
                                $stmt->bind_param("sssi", $empid, $fname, $dept,$entrykey);
                                $stmt->execute();
                            } else {
                                continue;
                            }
                        }
                    }
                    fclose($handle);
                }
            } elseif ($fileExtension === 'xlsx') {
                // Load the XLSX file
                $spreadsheet = IOFactory::load($fileTmpPath);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                foreach ($sheetData as $row) {
                    // Sanitize and check if data exists before inserting
                    $empid = isset($row[0]) ? $row[0] : null;
                    $fname = isset($row[1]) ? $row[1] : null;
                    $dept = isset($row[2]) ? $row[2] : null;
                    $entrykey = substr($empid, -5);

                    // Only proceed if $usn and $sname are not null
                    if ($empid && $fname) {

                        if (is_numeric($empid)) {
                            $stmt = $conn->prepare("INSERT IGNORE INTO faculty (emp_id,fname,dept,entrykey) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("sssi", $empid, $fname, $dept,$entrykey);
                            $stmt->execute();
                        } else {
                            continue;
                        }
                    }
                }
            }
            $_SESSION['message'] = "Data imported successfully.";
            header("Location: ../librarian.php");
            exit;
        } else {
            $_SESSION['message'] = "Upload failed. Only .csv and .xlsx files are allowed.";
            header("Location: ../librarian.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "There was an error uploading the file.";
        header("Location: ../librarian.php");
        exit;
    }
}

$conn->close();
