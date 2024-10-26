<?php
include 'db_connection.php';

$query = 'UPDATE users SET Cyear = 2 WHERE Cyear = 1';
$result = mysqli_query($conn, $query);

if ($result) {
    echo '
        <script type="text/javascript"> alert("Successfully Promoted 1st Year Students") </script> 
    ';
}
else {
    echo '
        <script type="text/javascript"> alert("Could not promote") </script> 
    ';
}