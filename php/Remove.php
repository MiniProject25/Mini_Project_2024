<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['removechoice'])) {
    // Get the selected option
    $choice = $_POST['removechoice'];

    $currentTimestamp = date('Y-m-d H:i:s');

    // removing 4th year students off the DB
    if ($choice == 'option1') {
        // Check if any users exist with the given year of study
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE Cyear = 4 AND (last_promoted_at IS NULL OR last_promoted_at < DATE_SUB('$currentTimestamp', INTERVAL 2 MONTH))");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $bnum = $row['count'];

        // If users exist, delete the records
        if ($bnum > 0) {
            $stmt = $conn->prepare("DELETE FROM users WHERE Cyear = 4 AND (last_promoted_at IS NULL OR last_promoted_at < DATE_SUB('$currentTimestamp', INTERVAL 2 MONTH))");
            $stmt->execute();

            // Verify deletion
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE Cyear = 4 AND (last_promoted_at IS NULL OR last_promoted_at < DATE_SUB('$currentTimestamp', INTERVAL 2 MONTH))");
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $num = $row['count'];

            if ($num == 0) {
                $_SESSION['message'] = "Records deleted successfully.";
            } else {
                $_SESSION['message'] = "Failed to delete records.";
            }
        } else {
            $_SESSION['message'] = "No records found for the given year of study.";
        }
    } elseif ($choice == 'option2') {
        if (isset($_POST["usn"])) {
            $usn = $_POST["usn"];

            if (!empty($usn)) {
                // Check if any user exists with the given USN
                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE usn = ?");
                $stmt->bind_param("s", $usn);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $bnum = $row['count'];

                // If a user exists, delete the record
                if ($bnum > 0) {
                    $stmt = $conn->prepare("DELETE FROM users WHERE usn = ?");
                    $stmt->bind_param("s", $usn);
                    $stmt->execute();

                    // Verify deletion
                    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE usn = ?");
                    $stmt->bind_param("s", $usn);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $num = $row['count'];

                    if ($num == 0) {
                        $_SESSION['message'] = "Record deleted successfully.";
                    } else {
                        $_SESSION['message'] = "Failed to delete record.";
                    }
                } else {
                    $_SESSION['message'] = "USN does not exist.";
                }
            } else {
                $_SESSION['message'] = "Please enter a valid USN.";
            }
        } else {
            $_SESSION['message'] = "Form not submitted or USN invalid.";
        }
    }
}

$conn->close();
header("Location: ../librarian.php");
exit;
?>