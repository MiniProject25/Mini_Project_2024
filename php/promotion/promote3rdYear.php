<?php
include 'db_connection.php';

$query = 'UPDATE users SET Cyear = 4 WHERE Cyear = 3';
$result = mysqli_query($conn, $query);

if ($result) {
    echo '
        <script type="text/javascript"> alert("Successfully Promoted 3rd Year Students") </script> 
    ';
}
else {
    echo '
        <script type="text/javascript"> alert("Could not promote") </script> 
    ';
}