<?php
// this is for student-wise statistic
include '../db_connection.php';

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

$query = 'SELECT COUNT(*)
        FROM history
        WHERE USN = ?';
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $usn);
$stmt->execute();
$stmt->bind_result($visit_count);
$stmt->fetch();
$stmt->close();

echo json_encode(['visitcount' => $visit_count]);
