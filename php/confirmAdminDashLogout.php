<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pwd = $_POST['pwd-logout'];
    $admin_id = $_SESSION['admin_id'];

    $sql = "SELECT pass_hash FROM admin WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (password_verify($pwd, $row['pass_hash'])) {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_logged_in']);
        echo '<script type="text/JavaScript">  
                    window.location.href = "../admin.php"; 
                    window.history.pushState(null, null, window.location.href);  
                    window.onpopstate = function () {
                        window.history.pushState(null, null, window.location.href);  
                    };
            </script>';
    } else {
        // echo json_encode(['success' => false, 'message' => "Invalid password"]);  
        echo '<script type="text/javascript">
                alert("Invalid Password!");
                window.location.href = "../admin_dashboard.php";
            </script>';
        // header('location: ../admin_dashboard.php');
    }

    $stmt->close();
    $conn->close();
}