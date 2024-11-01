<?php
// general stat
include '../db_connection.php';

$date_from = isset($_POST['date_from']) ? $_POST['date_from'] : '';
$date_to = isset($_POST['date_to']) ? $_POST['date_to'] : '';
$branch = isset($_POST['branch']) ? $_POST['branch'] : '';
$cyear = isset($_POST['cyear']) ? $_POST['cyear'] : '';
$data = [];

// LIBRARY USAGE PER HOUR
if (!empty($date_from) && !empty($date_to)) {

    // if all options are set
    if (!empty($branch) && !empty($cyear)) {
        $query = "
        SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
        FROM history
            WHERE (Date BETWEEN ? AND ?) AND (Branch = ?) AND (Cyear = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $date_from, $date_to, $branch, $cyear);

    } else if (!empty($branch)) { // if year is not set
        $query = "
            SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Date BETWEEN ? AND ?) AND (Branch = ?) 
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $date_from, $date_to, $branch);

    } else if (!empty($cyear)) { // if branch is not set
        $query = "
            SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Date BETWEEN ? AND ?) AND (Cyear = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $date_from, $date_to, $cyear);

    } else {
        // if year and branch are not set
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

} else if (empty($date_from) && empty($date_to)){

    // if from and to date are not set
    if (!empty($branch) && !empty($cyear)) {
        $query = "SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Branch = ?) AND (Cyear = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $branch, $cyear);

    } // if from, to date and branch is not set
    else if (!empty($cyear)) {
        $query = "SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Cyear = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $cyear);
        $stmt->execute();

    } //if from, to date and cyear is not set
    else if (!empty($branch)) { // if year is not set
        $query = "SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Branch = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $branch);

    } else { // if none are set
        $query = "SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode($data);
}
$conn->close();
?>