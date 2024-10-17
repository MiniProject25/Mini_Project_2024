<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include 'db_connection.php';

$year = $_POST['year'];
$branch = $_POST['branch'];
$section = $_POST['section'];

$query = "SELECT Name FROM users WHERE branch = ? AND section = ? AND Year = ? ORDER BY Name ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssi', $branch, $section, $year);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $students = array();
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['Name'] . "'>" . $row['Name'] . "</option>";
    }
}
else {
    echo "<option disabled>No Students available</option>";
}

?>
