<?php
session_start();
include 'db_connection.php';

$pass = $_POST['pass'];
$admin_id = $_SESSION['libadmin_id'];

$sql = "SELECT pass_hash FROM admin WHERE admin_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if(isset($pass)) {
    if (password_verify($pass, $row['pass_hash'])) {
        echo json_encode(['success' => true]);
    } 
    else {
        echo json_encode(['success' => false, 'message' => "Incorrect password"]);
    }
}
else {
    echo json_encode(['success' => false, 'message' => "Enter the password again"]);
}

$stmt->close();
$conn->close();
