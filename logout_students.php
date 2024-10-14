<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usn = $_POST['usn'];

    // update the timeout in active table
    $query = "UPDATE active SET TimeOut = NOW() where USN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $usn);
    $stmt->execute();

    // copy the row from active table to record table
    $record = "INSERT INTO record (USN, Name, Branch, Section, TimeIn, TimeOut, Date) 
            SELECT USN, Name, Branch, Section, TimeIn, TimeOut, Date FROM active where USN = ?";
    $stmt = $conn->prepare($record);
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    
    // delete the row from the active table
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