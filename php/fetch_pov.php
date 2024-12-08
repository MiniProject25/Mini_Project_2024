<?php
include 'db_connection.php';

$query = "SELECT purpose FROM purpose_of_visit";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['purpose'] . "'>" . $row['purpose'] . "</option>";
    }
}
else {
    echo "<option disabled>No Students available</option>";
}
