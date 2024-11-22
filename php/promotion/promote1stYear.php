<?php
include '../db_connection.php';

$currentTimestamp = date('Y-m-d H:i:s');

// Select students in the current year who haven't been promoted in this cycle
$query = "SELECT * FROM users WHERE Cyear = 1 AND (last_promoted_at IS NULL OR last_promoted_at < DATE_SUB('$currentTimestamp', INTERVAL 2 MONTH))";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Update the students' year and mark the current promotion timestamp
    $updateQuery = "UPDATE users SET Cyear = 2, last_promoted_at = '$currentTimestamp' WHERE Cyear = 1 AND (last_promoted_at IS NULL OR last_promoted_at < DATE_SUB('$currentTimestamp', INTERVAL 2 MONTH))";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult) {
        echo json_encode(array('success' => true, 'message' => "Successfully Promoted Year 1 Students to Year 2"));
    } else {
        echo json_encode(array('success' => false, 'message' => "Could not Promote Year 1 Students"));
    }
} else {
    echo json_encode(array('success' => false, 'message' => "No Year 1 Students Found for Promotion"));
}
