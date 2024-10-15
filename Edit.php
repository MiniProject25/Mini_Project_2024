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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit the Student details</title>
</head>
<body>
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" class="form-control" required><br>

    <label for="branch">Branch:</label>
    <input type="text" id="branch" name="branch" class="form-control" required><br>

    <label for="reg_year">Registration Year:</label>
    <input type="text" id="reg_year" name="reg_year" class="form-control" required><br>

    <label for="section">Section:</label>
    <input type="text" id="section" name="section" class="form-control" required><br>
</body>
</html>