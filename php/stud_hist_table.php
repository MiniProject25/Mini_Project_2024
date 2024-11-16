<?php
include 'db_connection.php';

$data = array();

$cyear = (int) $_POST['cyear'];
$branch = $_POST['branch'];
$section = $_POST['section'];
$sname = $_POST['sname'];

$usn_query = 'SELECT USN 
            FROM users
            WHERE Cyear = ? AND Branch = ? AND Section = ? AND Sname = ?';
$stmt = $conn->prepare($usn_query);
$stmt->bind_param('isss', $cyear, $branch, $section, $sname);
$stmt->execute();
$stmt->bind_result($usn);
$stmt->fetch();
$stmt->close();

$sql = "SELECT u.USN, u.Sname, u.Branch, u.Section, u.Cyear, h.TimeIn, h.TimeOut, DATE_FORMAT(h.Date, '%d-%m-%Y') as Date
        FROM users u 
        INNER JOIN history h ON u.USN = h.USN 
        WHERE h.USN = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $usn);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    echo json_encode(['success' => false, 'message' => 'Database query failed: ' . $conn->error]);
    exit();
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$stmt->close();
$conn->close();