<?php
session_start();
include 'db_connection.php';

$pov = $_POST['pov'];

if (isset($pov)) {
    $query = 'INSERT INTO purpose_of_visit(purpose) VALUES(?)';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $pov);
    
    // check whether it has been inserted or not
    if($stmt->execute()) {
        $_SESSION["message"] = "Added Succesfully!";
    }
    else {
        $_SESSION["message"] = "Failed to add. Try Again.";
    }
}
else {
    $_SESSION["message"] = "Please enter the purpose of visit before submiting!";
}

$conn->close();
header("Location: ../librarian.php");
exit;