<?php
include 'db_connection.php';

// update the timeout in active table
$query = "UPDATE faculty_history SET TimeOut = NOW() where TimeOut is NULL";
$stmt = $conn->prepare($query);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
$stmt->close();

?>