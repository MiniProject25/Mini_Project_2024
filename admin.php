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
        }

        .container {
            position: relative;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .bgimage {
            /* opacity: 0.3; */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            width: 100%;
            height: auto;
            max-height: 100vh;
        }

        .form-container {
            padding: 20px;
            /* gap: 20px; */
            display: flex;
            justify-content: space-between;
            background-color: rgba(255, 255, 255, 0.8);
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            /* gap: 15px; */
        }
        
        input {
            padding: 10px 20px;
            border-radius: 15px;
            border-color: white;
            border: 1px solid #ccc;
        }

        input:focus {
            background-color: lightblue;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<!-- comment -->

<body>
    <div class="container">
        <img src="./Res/cec-better.png" alt="Canara Logo" class="bgimage">
        <div class="form-container">
            <div class="row">
                <!-- Sign Up Form -->
                <div class="col-6">
                    <form method="POST" action="">
                        <label for="admin_name">Admin Name:</label>
                        <input id="admin_name" type="text" name="admin_name" required><br>
                        <label for="email">Email:</label>
                        <input id="email" type="email" name="email" required><br>
                        <label for="password">Password:</label>
                        <input id="password" type="password" name="password" required><br>
                        <button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
                    </form>
                </div>
                <!-- Login Form -->
                <div class="col-6">
                    <form method="POST" action="">
                        <label for="email">Email:</label>
                        <input id="email" type="email" name="email" required><br>
                        <label for="password">Password:</label>
                        <input id="password" type="password" name="password" required><br>
                        <button type="submit" class="btn btn-primary" name="login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- PHP Code Here -->
    <?php
    // ......................
    // ......................
    // SIGN UP IMPLEMENTATION 
    // ......................
    // ......................
    session_start(); # helps to remember who signed up
    $conn = mysqli_connect("localhost", "root", "", "library_db"); // connecting to the DB
    
    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function generateAdminID($length = 4)
    {
        return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    if (isset($_POST['signup'])) {
        $admin_name = $_POST['admin_name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $admin_id = generateAdminID();

        $checkEmail = $conn->query("SELECT * FROM admin WHERE email = '$email'");
        if ($checkEmail->num_rows > 0) {
            echo "Email already Exists!";
        } else {
            $sql = "INSERT INTO admin (admin_id, admin_name, email, password_hash) VALUES ('$admin_id', '$admin_name', '$email', '$password')";
            if ($conn->query($sql) === TRUE) {
                echo "Signup Successful! Your Admin ID is: $admin_id. You can now log in.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    // ......................
    // ......................
    // LOGIN IMPLEMENTATION 
    // ......................
    // ......................
    
    ?>

    <script src="js/bootstrap.js"></script>
</body>

</html>