<?php
include 'db_connection.php';

$date_from = $_POST['date_from'];
$date_to = $_POST['date_to'];
$branch = $_POST['branch'];
$cyear = $_POST['cyear'];

$query = "SELECT HOUR(TimeIn) as hour, COUNT(*) as student_count 
          FROM history
          WHERE Date BETWEEN ? AND ? 
          GROUP BY HOUR(TimeIn) 
          ORDER BY hour";

$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $date_from, $date_to);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
