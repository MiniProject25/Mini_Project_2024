<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/admin_dash.css" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 page-title ms-auto me-auto">Library Admin Page</span>
        </div>
    </nav>

    <!-- Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel">
        <!-- <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
        </div> -->
        <div class="offcanvas-body p-0">
            <div class="navbar-dark">
                <ul class="navbar-nav">
                    <li>
                        <a href="#" class="nav-link px-3 active">Import</a>
                        <hr>
                        <a href="#" class="nav-link px-3 active">Add a Student</a>
                        <hr>
                        <a href="#" class="nav-link px-3 active">Remove a Student</a>
                        <hr>
                        <a href="#" class="nav-link px-3 active">Edit</a>
                        <hr>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <main class="mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="card text-center mx-auto">
                    <div class="card-header">
                        <h5 class="card-title">Statistics</h5>
                        <hr>
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="true" href="#">Active</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="text-decoration: none; color: black" href="#">Link</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col md-12">
                                <label for="from_date">From</label>
                                <input type="date" name="date" id="date" class="me-3">
                                <label for="from_date" class="ms-3">To</label>
                                <input type="date" name="date" id="date">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Script -->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>