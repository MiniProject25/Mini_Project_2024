<?php
include 'db_connection.php';

$query = "SELECT u.USN, u.Name, u.Branch, u.Section, u.RegYear
        FROM users u 
        INNER JOIN active a ON u.USN = a.USN";
$result = $conn->query($query);

$active_students = array();
while ($row = $result->fetch_assoc()) {
    $active_students[] = $row;
}
echo json_encode($active_students);

?>