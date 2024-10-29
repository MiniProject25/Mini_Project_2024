<?php
include 'db_connection.php';

$data=array();



$sql="SELECT USN,Sname,Branch,RegYear,Section,Cyear FROM users";
$result=$conn->query($sql);

if ($result === false) {
    echo json_encode(['success' => false, 'message' => 'Database query failed: ' . $conn->error]);
    exit();
}

if($result->num_rows > 0){
    while($row=$result->fetch_assoc()){
        $data[]=$row;
    }
}
echo json_encode($data);

$conn->close();
?>