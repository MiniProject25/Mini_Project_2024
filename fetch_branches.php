<?php
include 'db_connection.php'; 

$query = "SELECT * FROM branch";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['Name'] . "'>" . $row['Name'] . "</option>";
    }
}
