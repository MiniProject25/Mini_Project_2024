<?php
include 'db_connection.php';

// Check if form is submitted and the 'reg_year' value is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usn"])) {
    $usn = $_POST["usn"];

    // Check if the input is not empty
    if (!empty($usn)) {
        // Sanitize the input (optional but recommended)
        $usn = $conn->real_escape_string($usn);

        // SQL query to delete the record
        $sql = "DELETE FROM users WHERE usn = '$usn'";

        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Please enter a valid USN.";
    }
} else {
    echo "Form not submitted or USN invalid.";
}

// Close the connection
$conn->close();
?>

