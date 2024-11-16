<?php
include 'db_connection.php';
$empId = $_POST['empId'];

// update the timeout in active table
$query = "UPDATE faculty_history SET TimeOut = NOW() where emp_id = ? ORDER BY `Date` DESC, `TimeOut` ASC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $empId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
$stmt->close();

?>