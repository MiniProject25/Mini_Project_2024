<?php
session_start();
include 'db_connection.php';

// Check if form is submitted and the 'reg_year' value is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["regyear"])) {
    $year=$_POST["cyear"];
    $regyear=$_POST["regyear"];

    // Check if the input is not empty
    if (!empty($year)) {
        // Sanitize the input (optional but recommended)
        $year = $conn->real_escape_string($year);

        // SQL query to delete the record
        $sql = "UPDATE users 
                SET cyear='$year'
                WHERE regyear='$regyear'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Record Updated successfully";
        } else {
            $_SESSION['message'] = "Error Updating record: " . $conn->error;
        }
    } else {
        $_SESSION['message'] = "Please enter a registration year.";
    }
} else {
    $_SESSION['message'] = "Form not submitted or year not set.";
}

// Close the connection
$conn->close();
?>