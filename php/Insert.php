<?php
session_start();
include 'db_connection.php';

// If the form is submitted, execute the following block of code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $usn = $_POST['usn'];

    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE usn = ?");
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $num = $row['count'];

    if ($num == 0) {
        $name = $_POST['sname'];
        $branch = $_POST['branch'];
        $regyear = $_POST['regyear'];
        $section = $_POST['section'];
        $year = $_POST['cyear'];

        $entrykey = substr($usn, -3);

        // Insert data into the `users` table or update if the USN already exists
        $sql = "INSERT INTO users (usn, Sname, branch, regyear, section, entrykey, Cyear) 
            VALUES ('$usn', '$name', '$branch', '$regyear', '$section', '$entrykey','$year')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Record updated successfully";
        } else {
            $_SESSION['message'] = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $_SESSION["message"] = "Student with USN {$usn} already exist!!!";
    }

    // Close the connection
    $conn->close();
    header("Location: ../admin_dashboard.php");
    exit;
}
?>