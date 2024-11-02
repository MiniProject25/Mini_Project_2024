<?php
ob_start();
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Page</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        body {
            background-color: #AFAEAE;
            font-family: sans-serif;
        }

        .container {
            position: relative;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        button {
            box-shadow: 0 4px 0px rgba(0, 0, 0, 0.3);
        }

        input {
            padding-left: 10px;
            padding-top: 7px;
            padding-bottom: 7px;
            border-radius: 5px;
            border-color: white;
            border: 1px solid #ccc;
        }

        input:focus {
            background-color: rgb(255, 204, 203);
        }

        .container button:hover {
            background-color: #494949;
        }

        .login-form {
            /* width: 40%; */
            background-color: white;
            padding: 30px 40px;
            /* margin: 0px 20px; */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .logo-container {
            position: fixed;
            bottom: 80%;
            left: 0%;
            right: 0%;
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 200px;
            /* height: auto; */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <!-- Login Form -->
            <div class="login-form col-fluid ms-auto me-auto">
                <p class="login-title" style="padding-bottom: 15px; font-size: 20px;">Library LOGIN</p>
                <form method="POST" action="">
                    <label for="admin_id">Admin ID:</label>
                    <input class="ms-1" id="admin_id" type="text" name="admin_id" required><br>
                    <br>
                    <label for="Password">Password:</label>
                    <input id="Password" type="password" name="password" required><br>
                    <br>
                    <p class="error-msg" hidden></p>
                    <button type="submit" class="btn btn-secondary" name="login">LOGIN</button>
                    <button type="reset" class="btn btn-secondary" name="reset">RESET</button>
                </form>
            </div>
        </div>
    </div>
    <div class="logo-container ms-auto me-auto">
        <img src=".\Res\cec-better.png" alt="Canara Logo" class="logo">
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