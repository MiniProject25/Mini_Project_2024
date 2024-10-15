<?php
include 'db_connection.php'; // Your DB connection file

$year = $_POST['year'];
$branch = $_POST['branch'];
$section = $_POST['section'];

$query = "SELECT Name FROM users WHERE branch = '$branch' AND section = '$section' AND Year = '$year'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['Name'] . "'>" . $row['Name'] . "</option>";
    }
}
else {
    echo "<option disabled>No Students available</option>";
}
?>
