<?php
include 'db_connection.php';

if (isset($_POST['name'], $_POST['year'], $_POST['branch'], $_POST['section'], $_POST['EntryKey'])) {
    $name = $_POST['name'];
    $year = (int) $_POST['year'];
    $branch = $_POST['branch'];
    $section = $_POST['section'];
    $EntryKey = $_POST['EntryKey'];

    $query = "SELECT * FROM users WHERE Sname = ? AND Branch = ? AND Section = ? AND EntryKey = ? AND Cyear = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $name, $branch, $section, $EntryKey, $year);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();

        $query = 'SELECT h.TimeOut
                FROM history h
                JOIN Users u ON u.USN = h.USN
                WHERE h.USN = ?
                ORDER BY h.Date DESC
                LIMIT 1';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $student['USN']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (is_null($row['TimeOut'])) {
            // TimeOut is NULL, so they are still in the library
            echo json_encode(['success' => false, 'message' => 'Student is already in the library.']);
        }
        else {
            // insert student into the history table
            $insertQuery = "INSERT INTO history (USN, Cyear, TimeIn, Date) VALUES(?, ?, NOW(), CURDATE())";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param('si', $student['USN'], $student['Cyear']);
    
            if ($insertStmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'data' => $student
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to log student into history table'
                ]);
            }
        }

    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Student not found'
        ]);
    }
}
