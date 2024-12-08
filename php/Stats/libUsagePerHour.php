<?php
// general stat
include '../db_connection.php';

$date_from = isset($_POST['date_from']) ? $_POST['date_from'] : '';
$date_to = isset($_POST['date_to']) ? $_POST['date_to'] : '';
$branch = isset($_POST['branch']) ? $_POST['branch'] : '';
$cyear = isset($_POST['cyear']) ? $_POST['cyear'] : '';
$purpose = isset($_POST['purpose']) ? $_POST['purpose'] : '';
$data = [];

// LIBRARY USAGE PER HOUR
if (!empty($date_from) && !empty($date_to)) {

    // if all options are set
    if (!empty($branch) && !empty($cyear) && !empty($purpose)) {
        $query = "
        SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
        FROM history
            WHERE (Date BETWEEN ? AND ?) AND (Branch = ?) AND (Cyear = ?) AND (purpose = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssis', $date_from, $date_to, $branch, $cyear, $purpose);

    } else if (!empty($branch) && !empty($purpose)) { // if year is not set
        $query = "
            SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Date BETWEEN ? AND ?) AND (Branch = ?) AND (purpose = ?) 
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssss', $date_from, $date_to, $branch, $purpose);

    } else if (!empty($cyear) && !empty($purpose)) { // if branch is not set
        $query = "
            SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Date BETWEEN ? AND ?) AND (Cyear = ?) AND (purpose = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssis', $date_from, $date_to, $cyear, $purpose);

    } else if (!empty($cyear) && !empty($branch)) { // if purpose is not set
        $query = "
        SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
        FROM history
        WHERE (Date BETWEEN ? AND ?) AND (Branch = ?) AND (Cyear = ?)
        GROUP BY HOUR(TimeIn)
        ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $date_from, $date_to, $branch, $cyear);
    } else if(!empty($purpose)) { // if branch and year are not set
        $query = "
        SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
        FROM history
        WHERE (Date BETWEEN ? AND ?) AND (purpose = ?)
        GROUP BY HOUR(TimeIn)
        ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $date_from, $date_to, $purpose);
    } else if(!empty($branch)) { // if year and purpose are not set
        $query = "
        SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
        FROM history
        WHERE (Date BETWEEN ? AND ?) AND (Branch = ?)
        GROUP BY HOUR(TimeIn)
        ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $date_from, $date_to, $branch);
    } else if(!empty($cyear)) { // if branch and purpose are not set
        $query = "
        SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
        FROM history
        WHERE (Date BETWEEN ? AND ?) AND (Cyear = ?)
        GROUP BY HOUR(TimeIn)
        ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $date_from, $date_to, $cyear);
    } else {
        // if year and branch and purpose are not set
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

    // if from and to date are not set
} else if (empty($date_from) && empty($date_to)){  

    if (!empty($branch) && !empty($cyear) && !empty($purpose)) { //  all are set
        $query = "SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Branch = ?) AND (Cyear = ?) AND (purpose = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $branch, $cyear, $purpose);

    } // if branch is not set
    else if (!empty($cyear) && !empty($purpose)) {
        $query = "SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Cyear = ?) AND (purpose = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('is', $cyear, $purpose);
        $stmt->execute();

    } //if cyear is not set
    else if (!empty($branch) && !empty($purpose)) { 
        $query = "SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Branch = ?) AND (purpose = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $branch, $purpose);

    } else if (!empty($branch) && !empty($cyear)) { // if purpose is not set
        $query = "SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Branch = ?) AND (Cyear= ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('si', $branch, $cyear);
    } else if (!empty($purpose)) { // if year and branch are not set
        $query = "SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (purpose = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $purpose);
    } else if (!empty($cyear)) { // if branch and purpose are not set
        $query = "SELECT HOUR(TimeIn) AS hour, COUNT(*) AS student_count
            FROM history
            WHERE (Cyear = ?)
            GROUP BY HOUR(TimeIn)
            ORDER BY hour";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $cyear);
    } else if (!empty($branch)) { // if year and purpose are not set 
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