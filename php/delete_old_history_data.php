<?php
include 'db_connection.php';

$query = 'SELECT COUNT(*) FROM history
        WHERE Date <= DATE_SUB(CURDATE(), INTERVAL 5 YEAR)';
$stmt = $conn->prepare($query);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count > 0) {
    $query = 'DELETE FROM history
            WHERE Date <= DATE_SUB(CURDATE(), INTERVAL 5 YEAR)';
    $stmt = $conn->prepare($query);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => "Successfully deleted 5+ Year Old Data From the History Table"]);
    } else {
        echo json_encode(['success' => true, 'message' => "Successfully deleted 5+ Year Old Data From the History Table"]);
    }
} else {
    echo json_encode(['message' => "No 5+ Year Old Data Exists"]);
}

