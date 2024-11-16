<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include 'db_connection.php';

$dept = $_POST['dept'];

$query = "SELECT Fname FROM faculty WHERE dept = ? ORDER BY Fname ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $dept);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $students = array();
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['Fname'] . "'>" . $row['Fname'] . "</option>";
    }
}
else {
    echo "<option disabled>No staffs available</option>";
}

?>
