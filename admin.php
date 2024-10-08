<?php
ob_start();
session_start(); # helps to remember who signed up
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        body {
            background: rgba(0, 128, 128, 0.5);
            font-family: sans-serif;
        }

        .container {
            /* width: 100% */
            position: relative;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        /* .bgimage {
            opacity: 0.3; 
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            width: 100%;
            height: auto;
            max-height: 100vh;
        } */

        /* .form-container { */
            /* padding: 20px; */
            /* gap: 20px; */
            /* display: flex; */
            /* justify-content: space-between; */
            /* background-color: rgba(255, 255, 255, 0.8); */
            /* align-items: center; */
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
            /* border-radius: 10px; */
            /* margin-left: 67px; */
        /* } */

        /* .form-container form {
            display: flex;
            flex-direction: column; */
            /* gap: 15px; */
        /* } */

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
            background-color: rgb(255, 100, 100);
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
                <p class="signup-title" style="padding-bottom: 15px; font-size: 20px;">LOGIN</p>
                <form method="POST" action="">
                    <label for="admin_id">Admin ID:</label>
                    <input class="ms-1" id="admin_id" type="text" name="admin_id" required><br>
                    <br>
                    <label for="Password">Password:</label>
                    <input id="Password" type="password" name="password" required><br>
                    <br>
                    <button type="submit" class="btn btn-danger" name="login">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
    <div class="logo-container ms-auto me-auto">
        <img src=".\Res\cec-better.png" alt="Canara Logo" class="logo">
    </div>

    <!-- PHP Code Here -->
    <?php
    // ......................
    // ......................
    // SIGN UP IMPLEMENTATION 
    // ......................
    // ......................
    $conn = mysqli_connect("localhost", "root", "", "library_db"); // connecting to the DB
    
    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function generateAdminID($length = 4)
    {
        return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

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
                    $_SESSION['admin_id'] = $admin['admin_id'];
                    $_SESSION['admin_name'] = $admin['admin_name'];
                    header("Location: admin_dashboard.php");
                    exit;
                } else {
                    echo "Invalid ID or Password!";
                }
            } else {
                echo "Admin not found!";
            }
        } else {
            echo "Admin ID or Password not provided!";
        }
    }

    $conn->close();
    ob_end_flush();
    ?>

    <script src="js/bootstrap.js"></script>
</body>

</html>