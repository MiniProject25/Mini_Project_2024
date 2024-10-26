<?php
include 'db_connection.php';

$query = 'UPDATE users SET Cyear = 3 WHERE Cyear = 2s';
$result = mysqli_query($conn, $query);

if ($result) {
    echo '
        <script type="text/javascript"> alert("Successfully Promoted 2nd Year Students") </script> 
    ';
}
else {
    echo '
        <script type="text/javascript"> alert("Could not promote") </script> 
    ';
}