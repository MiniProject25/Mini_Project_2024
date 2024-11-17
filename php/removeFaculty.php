<?php
include 'db_connection.php';

$fdept = $_POST["dept"];
$fname = $_POST["fname"];
$empid = $_POST["empid"];

if (isset($empid)) {
    $query = 'SELECT COUNT(*) as count FROM faculty where emp_id = ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $empid);
    $stmt->execute();
    $result = $stmt->get_result();
    $faculty = $result->fetch_assoc();
    $count = $faculty['count'];
    $stmt->close();

    if ($count == 1) {
        $query = 'DELETE FROM faculty where emp_id = ?';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$empid);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM faculty WHERE emp_id = ?");
        $stmt->bind_param("s", $empid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $num = $row['count'];
        $stmt->close();

        if ($num == 0) {
            echo json_encode(['success' => true, 'message' => "Faculty ID {$empid} deleted successfully."]);
        } else {
            echo json_encode(['success' => false, 'message' => "Failed to delete faculty."]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => "Incorrect Employee ID entered"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => "Please Enter the employee ID"]);
}