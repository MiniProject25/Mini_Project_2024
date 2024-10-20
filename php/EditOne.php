<?php
session_start();
include 'db_connection.php';

// Check if form is submitted and the 'reg_year' value is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usn"])) {
    $usn = $_POST['usn'];
    $name = $_POST['name'];
    $branch = $_POST['branch'];
    $regyear = (int)$_POST['regyear'];
    $section = $_POST['section'];
    $year = (int)$_POST['cyear'];

    // Check if the input is not empty
    if (!empty($usn)) {
        // Prepare the statement to prevent SQL injection
        $stmt = $conn->prepare("UPDATE users SET sname=?, branch=?, regyear=?, section=?, cyear=? WHERE usn=?");
        $stmt->bind_param("ssisis", $name, $branch, $regyear, $section, $year, $usn);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Record Updated successfully";
        } else {
            $_SESSION['message'] = "Error Updating record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Please enter a valid USN.";
    }
} else {
    $_SESSION['message'] = "Form not submitted or USN invalid.";
}

// Close the connection
$conn->close();
header("Location: ../admin_dashboard.php");
exit;
?>