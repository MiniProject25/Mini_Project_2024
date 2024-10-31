<?php
include '../db_connection.php';

$date_from = $_POST['date_from'];
$date_to = $_POST['date_to'];
$data = [];

// LIBRARY USAGE PER HOUR
// if all the options are set (dates, branch and year)
if (isset($date_from) && isset($date_to)) {

    $query = 'SELECT Date, COUNT(*) as visit_count
            FROM history
            WHERE Date BETWEEN ? AND ?
            GROUP BY Date
            ORDER BY Date';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $date_from, $date_to);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);

} else {
    echo json_encode(['error' => 'Please provide valid date range.']);
}
?>