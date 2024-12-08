<?php
session_start(); # Helps to remember who signed up
ob_start(); # Output buffering to handle headers

include './php/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/admin_login.css" />
</head>

<body>
    <div class="hero">
        <div class="logo-container">
            <div class="logo">
                <img src="res/logo.png" alt="cec-logo">
            </div>
        </div>
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" onclick="admin()" class="toggle-btn white-text" id="admin-btn">LIBRARIAN
                    LOGIN</button>
                <button type="button" onclick="sUser()" class="toggle-btn black-text" id="sUser-btn">INSTITUTE
                    LOGIN</button>
            </div>
            <form id="admin" method="POST" class="input-group">
                <input type="text" name="admin_id" class="input-field" placeholder="Admin ID" required>
                <input type="password" name="admin_pass" class="input-field" placeholder="Password" required>
                <!-- <div class="change_password_container" style="margin-top: 10px;">
                    <a data-bs-target="#admin_pass_modal" data-bs-toggle="modal"
                        name="admin_pass_change" style="text-decoration: none; color: gray; font-size: small"
                        href="#">Change password</a>
                </div> -->
                <div class="button-container">
                    <button type="submit" name="admin_login" class="btn-btn">LOGIN</button>
                    <button type="reset" class="btn-btn">RESET</button>
                </div>
            </form>
            <form id="sUser" method="POST" class="input-group">
                <input type="text" name="sUser_id" class="input-field" placeholder="Enter Id" required>
                <input type="password" name="sUser_pass" class="input-field" placeholder="Enter Password" required>
                <!-- <div class="change_password_container" style="margin-top: 10px;">
                    <a data-bs-target="#super_user_pass_modal" data-bs-toggle="modal" style="text-decoration: none; color: gray; font-size: small"
                        href="#">Change password</a>
                </div> -->
                <div class="button-container">
                    <button type="submit" name="sUser_login" class="btn-btn">LOGIN</button>
                    <button type="reset" class="btn-btn">RESET</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST['admin_login'])) {
        $admin = $_POST['admin_id'];
        $password = $_POST['admin_pass'];

        // Prepared statement for secure query
        $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?");
        $stmt->bind_param("s", $admin);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $adminData = $result->fetch_assoc();
            if (password_verify($password, $adminData['pass_hash'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $adminData['admin_id'];
                header("Location: librarian.php");
                exit;
            } else {
                echo "<script>alert('Invalid ID or Password!');</script>";
            }
        } else {
            echo "<script>alert('Invalid ID or Password!');</script>";
        }

        $stmt->close();
    } elseif (isset($_POST['sUser_login'])) {
        $sUser = $_POST['sUser_id'];
        $password = $_POST['sUser_pass'];

        // Prepared statement for super-user login
        $stmt = $conn->prepare("SELECT * FROM super_user WHERE sUser_id = ?");
        $stmt->bind_param("s", $sUser);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $sUserData = $result->fetch_assoc();
            if (password_verify($password, $sUserData['pass_hash'])) {
                $_SESSION['sUser_logged_in'] = true;
                $_SESSION['sUser_id'] = $sUserData['sUser_id'];
                header("Location: cec.php");
                exit;
            } else {
                echo "<script>alert('Invalid ID or Password!');</script>";
            }
        } else {
            echo "<script>alert('Invalid ID');</script>";
        }

        $stmt->close();
    }

    $conn->close();
    ob_end_flush();
    ?>

    <script>
        var adminForm = document.getElementById("admin");
        var sUserForm = document.getElementById("sUser");
        var btn = document.getElementById("btn");
        var adminBtn = document.getElementById("admin-btn");
        var sUserBtn = document.getElementById("sUser-btn");

        function admin() {
            adminForm.style.left = "50px";
            sUserForm.style.left = "450px";
            btn.style.left = "0";

            // Toggle text colors
            adminBtn.classList.add("white-text");
            adminBtn.classList.remove("black-text");
            sUserBtn.classList.add("black-text");
            sUserBtn.classList.remove("white-text");
        }

        function sUser() {
            adminForm.style.left = "-400px";
            sUserForm.style.left = "50px";
            btn.style.left = "155px";

            // Toggle text colors
            sUserBtn.classList.add("white-text");
            sUserBtn.classList.remove("black-text");
            adminBtn.classList.add("black-text");
            adminBtn.classList.remove("white-text");
        }
    </script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>