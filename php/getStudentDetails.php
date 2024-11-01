<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usn"])) {
    $usn = $_POST["usn"];

    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT sname, branch, regyear, section, cyear FROM users WHERE usn = ?");
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch student details and return them as JSON
        $studentDetails = $result->fetch_assoc();
        echo json_encode(["success" => true, "data" => $studentDetails]);
    } else {
        echo json_encode(["success" => false, "message" => "Student not found."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}

$conn->close();
?>
