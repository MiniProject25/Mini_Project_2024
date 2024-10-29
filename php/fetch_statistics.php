<?php
include 'db_connection.php';

$date_from = $_POST['date_from'];
$date_to = $_POST['date_to'];
$branch = $_POST['branch'];
$cyear = $_POST['cyear'];
$data = [];

// if branch and year isn't mentioned
// if all the options are set (dates, branch and year)
if (isset($data_from) && isset($date_to) && isset($branch) && isset($cyear)) {
    // echo '<script> alert(Hello); </script>';
    $_SESSION['message'] = "Hello";
    $query = "SELECT HOUR(TimeIn) as hour, COUNT(*) as student_count 
          FROM history
          WHERE (Date BETWEEN ? AND ?) AND (Branch = ?) AND (Cyear = ?) 
          GROUP BY HOUR(TimeIn) 
          ORDER BY hour";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $date_from, $date_to);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
} else if (isset($data_from) && isset($date_to)) { // totality of statistics from all branches and years
    // echo '<script> alert(World); </script>';  
    $_SESSION['message'] = "World";
    $query = "SELECT HOUR(TimeIn) as hour, COUNT(*) as student_count 
          FROM history
          WHERE Date BETWEEN ? AND ? 
          GROUP BY HOUR(TimeIn) 
          ORDER BY hour";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $date_from, $date_to);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}


echo json_encode($data);
?>