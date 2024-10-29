<?php
session_start();
include 'db_connection.php';

// Include PhpSpreadsheet library
require 'C:/wamp64/www/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file is uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
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
                        $serial = isset($data[0]) ? $data[0] : null;
                        $usn = isset($data[1]) ? $data[1] : null;
                        $x = substr($usn, 0, 3);

                        // Only proceed if $usn and $sname are notNull
                        if ($usn) {

                            if ($x != 'USN' || $x != 'usn' || $x != 'Uni') {
                                $stmt = $conn->prepare("UPDATE users SET usn=$usn WHERE usn=$serial");
                                $stmt->bind_param("ss", $serial, $usn);
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
                    $serial = isset($row[0]) ? $row[0] : null;
                    $usn = isset($row[1]) ? $row[1] : null;
                    $x = substr($usn, 0, 3);

                    // Only proceed if $usn are not null
                    if ($usn) {

                        if ($x != 'USN' || $x != 'usn' || $x != 'Uni') {
                            $stmt = $conn->prepare("UPDATE users SET usn=? WHERE usn=?");
                            $stmt->bind_param("ss", $usn, $serial);
                            $stmt->execute();
                        } else {
                            continue;
                        }
                    }
                }
            }
            $_SESSION['message'] = "Data imported successfully.";
            header("Location: ../admin_dashboard.php");
            exit;
        } else {
            $_SESSION['message'] = "Upload failed. Only .csv and .xlsx files are allowed.";
            header("Location: ../admin_dashboard.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "There was an error uploading the file.";
        header("Location: ../admin_dashboard.php");
        exit;
    }
}

$conn->close();
