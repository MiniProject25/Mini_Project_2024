<?php
include '../db_connection.php';

$query = 'SELECT * FROM users WHERE Cyear = 1';
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $query = 'UPDATE users SET Cyear = 2 WHERE Cyear = 1';
    $result = $conn->query($query);
    
    if ($result) {
        echo json_encode(array('success' => true,'message' => 'Successfully Promoted 1st Year Students'));
    }
    else {
        echo json_encode(array('success' => false,'message' => 'Could not Promote'));
    }
} else {
    echo json_encode(array('success' => false,'message' => 'Could not find 1st Year Students'));
}
