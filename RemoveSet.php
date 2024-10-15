<?php
include 'db_connection.php';

// Check if form is submitted and the 'reg_year' value is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["regyear"])) {
    $year = $_POST["regyear"];

    // Check if the input is not empty
    if (!empty($year)) {
        // Sanitize the input (optional but recommended)
        $year = $conn->real_escape_string($year);

        // SQL query to delete the record
        $sql = "DELETE FROM users WHERE regyear = '$year'";

        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Please enter a registration year.";
    }
} else {
    echo "Form not submitted or year not set.";
}

// Close the connection
$conn->close();
?>