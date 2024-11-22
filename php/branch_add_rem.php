<?php
include 'db_connection.php';

$chosenOption = $_POST['branch_choice'];

if ($chosenOption == 'addbranch') {
    
    $nameOfBranchToBeCreated = $_POST['branch_name'];
    // checking whether the branch to be inserted already exists
    $query = 'SELECT * FROM branch WHERE name = ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $nameOfBranchToBeCreated);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        echo '<script type="text/javascript"> alert("Cannot Insert. Branch already Exists"); 
                window.location.href = "../admin_dashboard.php";
            </script>';
    } else {
        $query = 'INSERT INTO branch (name) VALUES(?)';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $nameOfBranchToBeCreated);
        if ($stmt->execute()) {
            // echo json_encode(['success' => true, 'message' => 'Created a Branch Successfully']);
            echo '<script type="text/javascript"> alert("Succesfully Added the Branch"); 
                    window.location.href = "../librarian.php";
                </script>';
        }
        else {
            // echo json_encode(['success' => false, 'message' => 'Failed to create a branch']);
            echo '<script type="text/javascript"> alert("Failed to create a branch"); 
                    window.location.href = "../librarian.php";
                </script>';
        }
    }
}
else if ($chosenOption == 'removebranch') {
    
    $nameOfBranchToBeDeleted = $_POST['branch_to_remove'];
    $query = 'DELETE FROM branch WHERE Name = ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $nameOfBranchToBeDeleted);
    if ($stmt->execute()) {
        // echo json_encode(['success' => true, 'message' => 'Deleted the Branch Successfully']);
        echo '<script type="text/javascript"> alert("Succesfully Deleted the Branch"); 
                window.location.href = "../librarian.php";
                </script>';
    }
    else {
        // echo json_encode(['success' => false, 'message' => 'Failed to delete the branch']);
        echo '<script type="text/javascript"> alert("Failed to Delete the Branch"); 
                window.location.href = "../librarian.php";
            </script>';
    }
}
else {
    echo json_encode(['message' => "Options not chosen. Try Again", 'success' => false]);
}

$conn->close();