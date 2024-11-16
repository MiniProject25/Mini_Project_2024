<?php
// this is for student-wise statistic
include '../db_connection.php';

$cyear = (int)$_POST['cyear'];
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

$query = 'SELECT SUM(TIMESTAMPDIFF(SECOND, TimeIn, TimeOut))
        FROM history
        WHERE USN = ? AND TimeOut IS NOT NULL AND TimeIn IS NOT NULL';
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $usn);
$stmt->execute();
$stmt->bind_result($total_duration);
$stmt->fetch();
$stmt->close();

$hours = floor($total_duration / 3600);
$minutes = floor(($total_duration % 3600) / 60);
$seconds = $total_duration % 60;

$formatted_duration = sprintf("%02dh : %02dm : %02ds", $hours, $minutes, $seconds);

echo json_encode(['duration' => $formatted_duration, 'usn' => $usn]);