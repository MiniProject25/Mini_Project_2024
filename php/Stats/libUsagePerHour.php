<?php
include '../db_connection.php';

$date_from = $_POST['date_from'];
$date_to = $_POST['date_to'];
$branch = $_POST['branch'];
$cyear = $_POST['cyear'];
$data = [];

// LIBRARY USAGE PER HOUR
// if all the options are set (dates, branch and year)
if (isset($date_from) && isset($date_to)) {

    // if branch and cyear is provided
    if (!empty($branch) && !empty($cyear)) {
        $query = "
            SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Date BETWEEN ? AND ?) AND (Branch = ?) AND (Cyear = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $date_from, $date_to, $branch, $cyear);

    } else if(!empty($branch)) {
        $query = "
            SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Date BETWEEN ? AND ?) AND (Branch = ?) 
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $date_from, $date_to, $branch);

    } else if (!empty($cyear)) {
        $query = "
            SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Date BETWEEN ? AND ?) AND (Cyear = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $date_from, $date_to, $cyear);

    }else {
        // Query for all branches and years
        $query = "
            SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE Date BETWEEN ? AND ?
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $date_from, $date_to);
    }

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