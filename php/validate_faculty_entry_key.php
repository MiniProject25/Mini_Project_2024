<?php
include 'db_connection.php';

if(isset($_POST['dept'], $_POST['name'],$_POST['entryKey'])){
    $dept= $_POST['dept'];
    $name=$_POST['name'];
    $entryKey=$_POST['entryKey'];

    $query="SELECT * FROM faculty WHERE Fname=? AND dept=? AND Entrykey=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param('sss',$name,$dept,$entryKey);
    $stmt->execute();
    $result=$stmt->get_result();

    if($result->num_rows==1){
        $faculty=$result->fetch_assoc();
        $empId=$faculty['emp_id'];

        $queryHistory="SELECT TimeOut FROM faculty_history WHERE emp_id=? ORDER BY DATE DESC LIMIT 1";
        $stmtHistory=$conn->prepare($queryHistory);
        $stmtHistory->bind_param('s',$empId);
        $stmtHistory->execute();
        $resultHistory=$stmtHistory->get_result();

        if($resultHistory->num_rows>0){
            $row=$resultHistory->fetch_assoc();

            if(is_null($row['TimeOut'])){
                echo json_encode(['success' => false, 'message' => 'Faculty is already in the library.']);
            }else{
                $insertQuery="INSERT INTO faculty_history (EMP_ID, Dept,TimeIn,Date) VALUES(?,?,NOW(),CURDATE())";
                $insertStmt=$conn->prepare($insertQuery);
                $insertStmt->bind_param('ss',$empId,$dept);
                
                if($insertStmt->execute()){
                    echo json_encode(['success' => true, 'data' => $faculty]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to log student into history table']);
                }
            }
        } else {
            $insertQuery="INSERT INTO faculty_history (EMP_ID, Dept,TimeIn,Date) VALUES(?,?,NOW(),CURDATE())";
                $insertStmt=$conn->prepare($insertQuery);
                $insertStmt->bind_param('ss',$empId,$dept);
                
                if($insertStmt->execute()){
                    echo json_encode(['success' => true, 'data' => $faculty, 'message' => 'First-time login successful.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to log first-time faculty into history table']);
                }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Faculty not found or invalid entry key']);
    }
} else{
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
}