<?php
session_start();
include 'db_connection.php';

// Check if form is submitted and the 'reg_year' value is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usn"])) {
    $usn = $_POST['usn'];
    $name = $_POST['name'];
    $branch = $_POST['branch'];
    $regyear = $_POST['regyear'];
    $section = $_POST['section'];
    $year = $_POST['cyear'];

    // Check if the input is not empty
    if (!empty($usn)) {
        // Sanitize the input (optional but recommended)
        $usn = $conn->real_escape_string($usn);

        // SQL query to delete the record
        $sql = "UPDATE users 
                SET sname='$name',branch='$branch',regyear='$regyear',section='$section',cyear='$year'
                WHERE usn='$usn'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Record Updated successfully";
        } else {
            $_SESSION['message'] = "Error Updating record: " . $conn->error;
        }
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