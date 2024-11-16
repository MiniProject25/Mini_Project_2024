<?php
session_start();
include 'db_connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $empid = $_POST['emp_id'];

    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM faculty WHERE emp_id = ?");
    $stmt->bind_param("s", $empid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $num = $row['count'];

    if ($num == 0) {
        $fname = $_POST['emp_name'];
        $dept = $_POST['dept'];
        $entrykey = substr($empid, -3);

        // Insert data into the `faculty` table or update if the empid already exists
        $sql = "INSERT INTO faculty (emp_id, Fname, dept, entry_key) 
            VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $empid, $fname, $dept, $entrykey);

        if($stmt->execute()) {
            $_SESSION["message"] = "Added {$empid} to the Faculty Table";
        }
    } else {
        $_SESSION["message"] = "Faculty with Employee ID {$empid} already exists.";
    }

    // Close the connection
    $conn->close();
    header("Location: ../admin_dashboard.php");
    exit;
}