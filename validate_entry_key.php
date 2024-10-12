<?php
include 'db_connection.php';

if (isset($_POST['year'], $_POST['branch'], $_POST['section'], $_POST['EntryKey'])) {
    $year = $_POST['year'];
    $branch = $_POST['branch'];
    $section = $_POST['section'];
    $EntryKey = $_POST['EntryKey'];

    $query = "SELECT * FROM users WHERE Branch = ? AND Section = ? AND EntryKey = ? AND RegYear = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $branch, $section, $EntryKey, $year);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();

        echo json_encode([
            'success' => true,
            'data' => $student
        ]);
    } else {
        echo json_encode([
            'success' => false
        ]);
    }
}
