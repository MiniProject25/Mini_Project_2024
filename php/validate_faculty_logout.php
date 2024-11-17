<?php
session_start();
include 'db_connection.php';

if (isset($_POST['EntryKey']) && isset($_POST['pass'])) {
    $empId = $_POST['empId'];
    $entryKey = $_POST['EntryKey'];
    $pass = $_POST['pass'];
    $admin_id = $_SESSION['libadmin_id'];

    $sql = "SELECT pass_hash FROM admin WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (password_verify($pass, $row['pass_hash'])) {
        $query = "SELECT * FROM faculty WHERE emp_id = ? AND EntryKey = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $empId, $entryKey);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // EntryKey is valid
            echo json_encode(['success' => true]);
        } else {
            // Invalid EntryKey
            echo json_encode(['success' => false, 'message' => 'No matching entry found']);
        }
    }
    else {
        echo json_encode(['success' => false, 'message' => 'Incorrect Password or Entry Key']);
    }

    // Query to check if the EntryKey matches the one in the database for the given USN
} else {
    echo json_encode(['success' => false, 'message' => 'Entry Key or Password not provided']);
}
?>
