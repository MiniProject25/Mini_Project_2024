<?php
include 'db_connection.php';

$query = "SELECT f.emp_id, f.fname, f.Dept, h.TimeIn, DATE_FORMAT(h.Date, '%d-%m-%Y') as Date
        FROM faculty f
        INNER JOIN faculty_history h ON f.emp_id = h.emp_id
        WHERE h.TimeOut IS NULL";
$result = $conn->query($query);

$active_staffs = array();
while ($row = $result->fetch_assoc()) {
    $active_staffs[] = $row;
}
echo json_encode($active_staffs);

?>