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
    <title>Library Login Page</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/index_login.css" />
</head>

<body>
    <div class="hero">
        <div class="logo-container">
            <div class="logo">
                <img src="./res/cec-better.png" alt="cec-logo">
            </div>
        </div>
        <div class="form-box">
            <div class="heading-container">
                <h2 class="form-heading">LIBRARY LOGIN</h2>
            </div>
            <form method="POST" class="input-group">
                <input type="text" name="admin_id" class="input-field" placeholder="Admin ID" required>
                <input type="password" name="password" class="input-field" placeholder="Password" required>
                <!-- <div class="change_password_container">
                    <a name="user_pass_change" data-bs-target="#change_pass_modal" data-bs-toggle="modal"
                        style="text-decoration: none; color: gray; font-size: small" href="#">Change
                        password</a>
                </div> -->
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
            $result = $conn->query("SELECT * FROM user_login WHERE id = '$admin'");
            if ($result->num_rows == 1) {
                $admin = $result->fetch_assoc();
                // echo "Correct ID<br>";
                if (password_verify($password, $admin['pass_hash'])) {
                    $_SESSION['library_logged_in'] = true;
                    $_SESSION['libadmin_id'] = $admin['id'];
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

    ob_end_flush();
    $conn->close();
    ?>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>