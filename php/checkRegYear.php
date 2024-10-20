<?php
// Database connection
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $regyear = $_POST['regyear'];

    //SQL statement to check registration year
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE regyear = ?");
    $stmt->bind_param("s", $regyear);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Registration year found, redirect or respond with success
        echo json_encode(['success' => true]);
    } else {
        // Registration year not found
        echo json_encode(['success' => false, 'message' => 'Registration year not found.']);
    }
}
?>
