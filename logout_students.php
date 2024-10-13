<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usn = $_POST['usn'];
    
    $query = "DELETE FROM active where USN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $usn);
    
    if($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success'=> false]);
    }
    $stmt->close();
}
?>