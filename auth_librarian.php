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
            height: 300px;
            position: relative;
            margin: 2% auto;
            background: rgba(255, 255, 255, 0.8);
            padding: 5px;
            overflow: hidden;
            border-radius: 10px;
        }

        .form-heading {
            font-size: 24px;
            color: #fff;
            text-align: center;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .heading-container{
            background: #1e3c72;
        }

        .input-group {
            position: absolute;
            width: 280px;
            top: 120px;
            transition: left 0.5s;
            left: 50px;
            margin-bottom: 50px;
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
            <div class="heading-container">
                <h2 class="form-heading">LIBRARIAN LOGIN</h2>
            </div>
            <form method="POST" class="input-group">
                <input type="text" name="admin_id" class="input-field" placeholder="Admin ID" required>
                <input type="password" name="password" class="input-field" placeholder="Password" required>
                <div class="button-container">
                    <button type="submit" name="login" class="btn-btn">LOGIN</button>
                    <button type="reset" class="btn-btn">RESET</button>
                </div>
            </form>
        </div>
    </div>

    <!-- PHP Code Here -->
    <?php
    include './php/db_connection.php';
    // ......................
    // ......................
    // LOGIN IMPLEMENTATION 
    // ......................
    // ......................
    if (isset($_POST['login'])) {
        if (isset($_POST['admin_id']) && isset($_POST['password'])) {
            $admin = $_POST['admin_id'];
            $password = $_POST['password'];

            # fetch admin data
            $result = $conn->query("SELECT * FROM admin WHERE admin_id = '$admin'");
            if ($result->num_rows == 1) {
                $admin = $result->fetch_assoc();
                // echo "Correct ID<br>";
                if (password_verify($password, $admin['pass_hash'])) {
                    $_SESSION['library_logged_in'] = true;
                    $_SESSION['libadmin_id'] = $admin['admin_id'];
                    header("Location: index.php");
                    exit;
                } else {
                    echo '<script type="text/javascript">';
                    echo 'alert("Invalid ID or Password!");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("Invalid ID or Password!");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Admin ID or Password not provided!");';
            echo '</script>';
        }
    }

    $conn->close();
    ob_end_flush();
    ?>

    <script src="js/bootstrap.js"></script>
</body>

</html>