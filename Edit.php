<?php
session_start();
include 'php/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST["usn"]) || isset($_POST["regyear"]))) {
    $usn = $_POST["usn"];
    $regyear = $_POST["regyear"];

    if (!empty($usn)) {
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE usn = ?");
        $stmt->bind_param("s", $usn);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $num = $row['count'];

        if ($num == 1) {
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Edit Student Details</title>
                <link rel="stylesheet" href="css/bootstrap.min.css" />
                <link rel="stylesheet" href="css/admin_dash.css" />
            </head>

            <body>
                <!-- Top Navbar -->
                <nav class="navbar navbar-dark bg-dark">
                    <div class="container-fluid">
                        <span class="navbar-brand mb-0 h1 page-title ms-auto me-auto">Edit Student Details</span>
                    </div>
                </nav>

                <!-- Main Container -->
                <div class="container mt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-white text-dark text-center">
                                    <h2>Edit Student Information</h2>
                                </div>
                                <div class="card-body">
                                    <form action="php/EditOne.php" method="post">
                                        <input type="hidden" name="usn" value="<?php echo htmlspecialchars($usn); ?>">

                                        <div class="form-group mb-3">
                                            <label for="name">Name:</label>
                                            <input type="text" id="name" name="name" class="form-control" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="branch">Branch:</label>
                                            <input type="text" id="branch" name="branch" class="form-control" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="regyear">Registration Year:</label>
                                            <input type="text" id="regyear" name="regyear" class="form-control" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="section">Section:</label>
                                            <input type="text" id="section" name="section" class="form-control" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="cyear">Current Year:</label>
                                            <input type="text" id="cyear" name="cyear" class="form-control" required>
                                        </div>

                                        <button type="submit" class="btn btn-danger">Save changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="js/bootstrap.bundle.min.js"></script>
            </body>

            </html>

            <?php
        } else {
            $_SESSION['message'] = "USN does not exist!!!";
            header("Location: admin_dashboard.php");
            exit();
        }
    } else if (!empty($regyear)) {
        $num = 0;
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE regyear = ?");
        $stmt->bind_param("s", $regyear);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $num = $row['count'];

        if ($num == 0) {
            $_SESSION['message'] = "Students with registration year {$regyear} doesnot exist!!!";
            header("Location: admin_dashboard.php"); // Redirect back to the main page
            exit();
        } else {
            ?>
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Edit the Student details</title>
                    <link rel="stylesheet" href="css/bootstrap.min.css" />
                    <link rel="stylesheet" href="css/admin_dash.css" />
                </head>

                <body>
                    <!-- Top Navbar -->
                    <nav class="navbar navbar-dark bg-dark">
                        <div class="container-fluid">
                            <span class="navbar-brand mb-0 h1 page-title ms-auto me-auto">Update Student Details</span>
                        </div>
                    </nav>

                    <!-- Main Container -->
                    <div class="container mt-4">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header bg-white text-dark text-center">
                                        <h2>Edit Current Year Information</h2>
                                    </div>
                                    <div class="card-body">
                                        <form action="php/EditSet.php" method="post">
                                            <input type="hidden" name="regyear" value="<?php echo htmlspecialchars($regyear); ?>">

                                            <div class="form-group mb-3">
                                                <label for="cyear">Current Year:</label>
                                                <input type="text" id="cyear" name="cyear" class="form-control" required>
                                            </div>

                                            <button type="submit" class="btn btn-danger">Edit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script src="js/bootstrap.bundle.min.js"></script>
                </body>

                </html>
            <?php
        }
    } else {
        $_SESSION['message'] = "Please fill the content!!!";
        header("Location: admin_dashboard.php");
        exit();
    }
}

?>