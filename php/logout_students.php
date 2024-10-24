<?php
include 'db_connection.php';
$usn = $_POST['usn'];

// update the timeout in active table
$query = "UPDATE history SET TimeOut = NOW() where USN = ? ORDER BY `Date` DESC, `TimeIn` DESC LIMIT 1;";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $usn);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
$stmt->close();

?>