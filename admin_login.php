<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
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
            /* Semi-transparent white */
            padding: 20px;
            border-radius: 10px;
            /* Optional: add rounded corners */
            margin: 2% auto;
            /* Center align container */
        }


        .logo img {
            height: 100px;
            /* Adjust to your preferred size */
            width: auto;
        }

        .form-box {
            width: 380px;
            height: 340px;
            position: relative;
            margin: 2% auto;
            background: rgba(255, 255, 255, 0.8);
            /* Semi-transparent white */
            padding: 5px;
            overflow: hidden;
            border-radius: 10px;
            /* Optional: add rounded corners */
        }

        .button-box {
            width: 310px;
            margin: 35px auto;
            position: relative;
            box-shadow: 0 0 20px 9px #ff61241f;
            border-radius: 30px;
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
            background: linear-gradient(to right, #1e3c72, #ee82ee);
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
            border-left: 0;
            border-top: 0;
            border-right: 0;
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
            background: linear-gradient(to right, #1e3c72, #ee82ee);
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
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" onclick="admin()" class="toggle-btn">ADMIN LOGIN</button>
                <button type="button" onclick="sUser()" class="toggle-btn">SUPER-USER LOGIN</button>
            </div>
            <form id="admin" class="input-group">
                <input type="text" class="input-field" placeholder="Admin Id" required>
                <input type="password" class="input-field" placeholder="Enter Password" required>
                <div class="button-container">
                    <button type="submit" class="btn-btn">LOGIN</button>
                    <button type="reset" class="btn-btn">RESET</button>
                </div>
            </form>
            <form id="sUser" class="input-group">
                <input type="text" class="input-field" placeholder="Super-User Id" required>
                <input type="password" class="input-field" placeholder="Enter Password" required>
                <div class="button-container">
                    <button type="submit" class="btn-btn">LOGIN</button>
                    <button type="reset" class="btn-btn">RESET</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var adminForm = document.getElementById("admin");
        var sUserForm = document.getElementById("sUser");
        var btn = document.getElementById("btn");

        function admin() {
            adminForm.style.left = "50px";
            sUserForm.style.left = "450px";
            btn.style.left = "0";
        }

        function sUser() {
            adminForm.style.left = "-400px";
            sUserForm.style.left = "50px";
            btn.style.left = "155px";
        }
    </script>
</body>

</html>