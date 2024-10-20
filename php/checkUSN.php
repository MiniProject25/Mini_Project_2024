<?php
// Include database connection
include 'db_connection.php';

if (isset($_POST['usn'])) {
    $usn = $_POST['usn'];

    // Prepare SQL query to check if USN exists
    $query = "SELECT * FROM users WHERE USN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $result = $stmt->get_result();
    // $row = $result->fetch_assoc();

    // Return response based on whether the USN exists
    if ($result->num_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'USN exists.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'USN does not exist.']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'No USN provided.']);
}

$conn->close();
?>
