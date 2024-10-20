<?php
session_start();
// Include database connection
include 'db_connection.php';

// Include PhpSpreadsheet library
require 'C:/wamp64/www/vendor/autoload.php'; // Adjust path as necessary

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
                        $usn = isset($data[0]) ? $data[0] : null;
                        $sname = isset($data[1]) ? $data[1] : null;
                        $branch = isset($data[2]) ? $data[2] : null;
                        $regyear = isset($data[3]) ? $data[3] : null;
                        $section = isset($data[4]) ? $data[4] : null;
                        $cyear = isset($data[5]) ? $data[5] : null;

                        // Only proceed if $usn and $sname are not null
                        if ($usn && $sname) {
                            $entrykey = substr($usn, -3); // Extract last 3 digits of USN

                            $stmt = $conn->prepare("INSERT IGNORE INTO users (usn, sname, branch, regyear, section, entrykey, cyear) VALUES (?, ?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("sssssss", $usn, $sname, $branch, $regyear, $section, $entrykey, $cyear);
                            $stmt->execute();
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
                    $usn = isset($row[0]) ? $row[0] : null;
                    $sname = isset($row[1]) ? $row[1] : null;
                    $branch = isset($row[2]) ? $row[2] : null;
                    $regyear = isset($row[3]) ? $row[3] : null;
                    $section = isset($row[4]) ? $row[4] : null;
                    $cyear = isset($row[5]) ? $row[5] : null;

                    // Only proceed if $usn and $sname are not null
                    if ($usn && $sname) {
                        $entrykey = substr($usn, -3); // Extract last 3 digits of USN

                        $stmt = $conn->prepare("INSERT IGNORE INTO users (usn, sname, branch, regyear, section, entrykey, cyear) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("sssssss", $usn, $sname, $branch, $regyear, $section, $entrykey, $cyear);
                        $stmt->execute();
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

// Close connection
$conn->close();
?>