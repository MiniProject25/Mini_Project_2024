<?php
include 'db_connection.php';
// comment
if (isset($_POST['name'], $_POST['year'], $_POST['branch'], $_POST['section'], $_POST['EntryKey'])) {
    $name = $_POST['name'];
    $year = (int) $_POST['year'];
    $branch = $_POST['branch'];
    $section = $_POST['section'];
    $EntryKey = $_POST['EntryKey'];
    
    //Fetch student details from 'users' table
    $query = "SELECT * FROM users WHERE Sname = ? AND Branch = ? AND Section = ? AND EntryKey = ? AND Cyear = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $name, $branch, $section, $EntryKey, $year);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();
        $usn = $student['USN'];

        //Check if student has logged in before (i.e., if they exist in the 'history' table)
        $queryHistory = "SELECT TimeOut FROM history WHERE USN = ? ORDER BY Date DESC LIMIT 1";
        $stmtHistory = $conn->prepare($queryHistory);
        $stmtHistory->bind_param('s', $usn);
        $stmtHistory->execute();
        $resultHistory = $stmtHistory->get_result();

        //Handle the case for returning users
        if ($resultHistory->num_rows > 0) {
            $row = $resultHistory->fetch_assoc();

            //Check if the student's 'TimeOut' is NULL (meaning they are still logged in)
            if (is_null($row['TimeOut'])) {
                // User is already in the library, prevent another login
                echo json_encode(['success' => false, 'message' => 'Student is already in the library.']);
            } else {
                //Valid returning student, log them in again (new session)
                $insertQuery = "INSERT INTO history (USN, Cyear, TimeIn, Date) VALUES(?, ?, NOW(), CURDATE())";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param('si', $student['USN'], $student['Cyear']);  
        
                if ($insertStmt->execute()) {
                    echo json_encode(['success' => true, 'data' => $student]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to log student into history table']);
                }
            }
        } 
        //Handle first-time login (i.e., no record in the 'history' table)
        else {
            // First-time login, log the student into the 'history' table
            $insertQuery = "INSERT INTO history (USN, Cyear, TimeIn, Date) VALUES(?, ?, NOW(), CURDATE())";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param('si', $student['USN'], $student['Cyear']);
    
            if ($insertStmt->execute()) {
                echo json_encode(['success' => true, 'data' => $student, 'message' => 'First-time login successful.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to log first-time student into history table']);
            }
        }
    } else {
        //If the student is not found in the 'users' table
        echo json_encode(['success' => false, 'message' => 'Student not found or invalid entry key']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
}

?>
