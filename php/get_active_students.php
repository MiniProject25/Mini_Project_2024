<?php
include 'db_connection.php';

$query = "SELECT u.USN, u.Sname, u.Branch, u.Section, u.Cyear
        FROM users u 
        INNER JOIN history h ON u.USN = h.USN
        WHERE h.TimeOut IS NULL";
$result = $conn->query($query);

$active_students = array();
while ($row = $result->fetch_assoc()) {
    $active_students[] = $row;
}
echo json_encode($active_students);

?>