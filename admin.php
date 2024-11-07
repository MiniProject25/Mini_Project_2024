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
    <style>
        /* Your CSS code remains unchanged */
        * {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .hero {
            height: 100%;
            width: 100%;
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(res/clg.png);
            background-position: center;
            background-size: cover;
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo-container {
            width: 15%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin: 2% auto;
        }

        .logo img {
            height: 100px;
            width: auto;
        }

        .form-box {
            width: 380px;
            height: 340px;
            position: relative;
            margin: 2% auto;
            background: rgba(255, 255, 255, 0.8);
            padding: 5px;
            overflow: hidden;
            border-radius: 10px;
        }

        .button-box {
            width: 310px;
            margin: 35px auto;
            position: relative;
            box-shadow: 0 0 20px 9px #ff61241f;
            border-radius: 30px;
            background: rgba(245, 245, 245, 0.3);
        }

        .toggle-btn {
            width: 150px;
            padding: 10px 0;
            cursor: pointer;
            background: transparent;
            border: 0;
            outline: none;
            position: relative;
            text-align: center;
        }

        #btn {
            top: 0;
            left: 0;
            position: absolute;
            width: 155px;
            height: 100%;
            background: #1e3c72;
            border-radius: 30px;
            transition: 0.5s;
        }

        .input-group {
            position: absolute;
            width: 280px;
            top: 140px;
            transition: left 0.5s;
        }

        #admin {
            left: 50px;
        }

        #sUser {
            left: 450px;
        }

        .input-field {
            width: 100%;
            padding: 10px 0;
            margin: 5px 0;
            border: none;
            border-bottom: 1px solid #999;
            outline: none;
            background: transparent;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn-btn {
            width: 40%;
            padding: 10px 30px;
            cursor: pointer;
            background: #1e3c72;
            border: 0;
            outline: none;
            border-radius: 30px;
            color: #fff;
        }

        .white-text {
            color: white;
        }

        .black-text {
            color: black;
        }
    </style>
</head>

<body>
    <div class="hero">
        <div class="logo-container">
            <div class="logo">
                <img src="res/cec-better.png" alt="cec-logo">
            </div>
        </div>
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" onclick="admin()" class="toggle-btn white-text" id="admin-btn">ADMIN
                    LOGIN</button>
                <button type="button" onclick="sUser()" class="toggle-btn black-text" id="sUser-btn">SUPER-USER
                    LOGIN</button>
            </div>
            <form id="admin" method="POST" class="input-group">
                <input type="text" name="admin_id" class="input-field" placeholder="Admin ID" required>
                <input type="password" name="admin_pass" class="input-field" placeholder="Password" required>
                <div class="button-container">
                    <button type="submit" name="admin_login" class="btn-btn">LOGIN</button>
                    <button type="reset" class="btn-btn">RESET</button>
                </div>
            </form>
            <form id="sUser" method="POST" class="input-group">
                <input type="text" name="sUser_id" class="input-field" placeholder="Super-User Id" required>
                <input type="password" name="sUser_pass" class="input-field" placeholder="Enter Password" required>
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
                $_SESSION['role'] = 'admin';
                header("Location: admin_dashboard.php");
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
                $_SESSION['role'] = 'super_user';
                header("Location: admin_dashboard.php");
                exit;
            } else {
                echo "<script>alert('Invalid ID or Password!');</script>";
            }
        } else {
            echo "<script>alert('Invalid ID or Password!');</script>";
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
</body>

</html>