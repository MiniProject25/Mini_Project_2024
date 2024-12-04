<?php
include 'db_connection.php';

$new_pass = $_POST['new_pass'];
$reentered_pass = $_POST['re_new_pass'];

if (($new_pass == $reentered_pass) && isset($_POST['user_pass_change'])) {
    $result = $conn->query("SELECT id FROM user_login");
    $admin = $result->fetch_assoc();

    if ($result->num_rows == 1) {
        $password_hash = password_hash($new_pass, PASSWORD_BCRYPT);

        $query = "UPDATE user_login SET pass_hash = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $password_hash, $admin['id']);

        if ($stmt->execute()) {
            $query = "SELECT pass_hash FROM user_login WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $admin['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $updated_admin = $result->fetch_assoc();

            if ($updated_admin['pass_hash'] === $password_hash) {
                echo '<script type="text/javascript">';
                echo 'alert("Password successfully changed");';
                echo 'window.location.href = "../librarian.php";';
                echo '</script>';

                // header("Location: ../index.php");
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("Password failed to change");';
                echo 'window.location.href = "../librarian.php";';
                echo '</script>';
                // header("Location: ../index.php");
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Password failed to change");';
            echo 'window.location.href = "../librarian.php";';
            echo '</script>';
            // header("Location: ../index.php");
        }
    }

    unset($_POST['user_pass_change']);
} else if (($new_pass == $reentered_pass) && isset($_POST['super_user_pass_change'])) {

    $result = $conn->query("SELECT sUser_id FROM super_user");
    $admin = $result->fetch_assoc();

    if ($result->num_rows == 1) {
        $password_hash = password_hash($new_pass, PASSWORD_BCRYPT);

        $query = "UPDATE super_user SET pass_hash = ? WHERE sUser_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $password_hash, $admin['sUser_id']);

        if ($stmt->execute()) {
            $query = "SELECT pass_hash FROM super_user WHERE sUser_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $admin['sUser_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $updated_admin = $result->fetch_assoc();

            if ($updated_admin['pass_hash'] === $password_hash) {
                echo '<script type="text/javascript">';
                echo 'alert("Password successfully changed");';
                echo 'window.location.href = "../librarian.php";';
                echo '</script>';

                // header("Location: ../index.php");
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("Password failed to change");';
                echo 'window.location.href = "../librarian.php";';
                echo '</script>';
                // header("Location: ../index.php");
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Password failed to change");';
            echo 'window.location.href = "../librarian.php";';
            echo '</script>';
            // header("Location: ../index.php");
        }
    }
    unset($_POST['super_user_pass_change']);
} else if(($new_pass == $reentered_pass) && isset($_POST['admin_pass_change'])) {

    $result = $conn->query("SELECT admin_id FROM admin");
    $admin = $result->fetch_assoc();

    if ($result->num_rows == 1) {
        $password_hash = password_hash($new_pass, PASSWORD_BCRYPT);

        $query = "UPDATE admin SET pass_hash = ? WHERE admin_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $password_hash, $admin['admin_id']);

        if ($stmt->execute()) {
            $query = "SELECT pass_hash FROM admin WHERE admin_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $admin['admin_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $updated_admin = $result->fetch_assoc();

            if ($updated_admin['pass_hash'] === $password_hash) {
                echo '<script type="text/javascript">';
                echo 'alert("Password successfully changed");';
                echo 'window.location.href = "../librarian.php";';
                echo '</script>';

                // header("Location: ../index.php");
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("Password failed to change");';
                echo 'window.location.href = "../librarian.php";';
                echo '</script>';
                // header("Location: ../index.php");
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Password failed to change");';
            echo 'window.location.href = "../librarian.php";';
            echo '</script>';
            // header("Location: ../index.php");
        }
    }
    unset($_POST['admin_pass_change']);
} else {
    if(isset($_POST['user_pass_change'])) {
        echo '<script type="text/javascript">';
        echo 'alert("Passwords do not match");';
        echo 'window.location.href = "../librarian.php";';
        echo '</script>';
    } else 
    if (isset($_POST['super_user_pass_change'])) {
        echo '<script type="text/javascript">';
        echo 'alert("Passwords do not match");';
        echo 'window.location.href = "../librarian.php";';
        echo '</script>';
    } else if(isset($_POST['admin_pass_change'])) {
        echo '<script type="text/javascript">';
        echo 'alert("Passwords do not match");';
        echo 'window.location.href = "../librarian.php";';
        echo '</script>';
    }
} 

// header("Location: ../index.php");
$conn->close();

