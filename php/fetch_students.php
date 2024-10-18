<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include 'db_connection.php';

$year = $_POST['year'];
$branch = $_POST['branch'];
$section = $_POST['section'];

$query = "SELECT Sname FROM users WHERE branch = ? AND section = ? AND Cyear = ? ORDER BY Sname ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssi', $branch, $section, $year);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $students = array();
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['Sname'] . "'>" . $row['Sname'] . "</option>";
    }
}
else {
    echo "<option disabled>No Students available</option>";
}

?>
