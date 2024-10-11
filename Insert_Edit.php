<?php
// If the form is submitted, execute the following block of code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $servername = "localhost";
    $username = "root"; // Default WAMP server username
    $password = ""; // Default WAMP server password is blank
    $dbname = "library"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Capture form data
    $usn = $_POST['usn'];
    $name = $_POST['name'];
    $branch = $_POST['branch'];
    $reg_year = $_POST['reg_year'];
    $section = $_POST['section'];

    // Insert data into the `users` table or update if the USN already exists
    $sql = "INSERT INTO users (usn, name, branch, reg_year, section) 
            VALUES ('$usn', '$name', '$branch', '$reg_year', '$section')
            ON DUPLICATE KEY UPDATE 
            name='$name', branch='$branch', reg_year='$reg_year', section='$section'";

    if ($conn->query($sql) === TRUE) {
        $message = "Record updated successfully";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert or Update User Details</title>
</head>
<body>
    <h2>Insert or Update User Details</h2>

    <!-- Display a success/error message if the form was submitted -->
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- HTML form to take user input -->
    <form action="" method="post">
        <label for="usn">USN:</label>
        <input type="text" id="usn" name="usn" required><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="branch">Branch:</label>
        <input type="text" id="branch" name="branch" required><br><br>

        <label for="reg_year">Registration Year:</label>
        <input type="year" id="reg_year" name="reg_year" required><br><br>

        <label for="section">Section:</label>
        <input type="text" id="section" name="section" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
