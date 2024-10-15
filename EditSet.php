<?php
// Database connection details
$servername = "localhost";  // or your server name
$username = "root";         // your MySQL username
$password = "";             // your MySQL password
$dbname = "library";        // your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted and the 'reg_year' value is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reg_year"])) {
    $year = $_POST["reg_year"];
    $n_year=$_POST["new_reg_"]

    // Check if the input is not empty
    if (!empty($year)) {
        // Sanitize the input (optional but recommended)
        $year = $conn->real_escape_string($year);

        // SQL query to delete the record
        $sql = "DELETE FROM users WHERE reg_year = '$year'";

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