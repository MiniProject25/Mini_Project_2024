<?php
include 'db_connection.php';

if (isset($_POST['name'], $_POST['year'], $_POST['branch'], $_POST['section'], $_POST['EntryKey'])) {
    $name = $_POST['name'];
    $year = (int)$_POST['year'];
    $branch = $_POST['branch'];
    $section = $_POST['section'];
    $EntryKey = $_POST['EntryKey'];

    $query = "SELECT * FROM users WHERE Name = ? AND Branch = ? AND Section = ? AND EntryKey = ? AND Year = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $name, $branch, $section, $EntryKey, $year);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();

        // insert student into the active table
        $insertQuery = "INSERT INTO history (USN, Year, TimeIn, Date) VALUES(?, ?, NOW(), CURDATE())";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param('si', $student['USN'], $student['Year']);

        if ($insertStmt->execute()) {
            echo json_encode([
                'success' => true,
                'data' => $student
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to log student into active table'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
        ]);
    }
}
