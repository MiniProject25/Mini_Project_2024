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
    <!-- Top Navbar -->
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
                        <a href="#" data-bs-target="#importModal" data-bs-toggle="modal" class="nav-link px-3 active">Import</a>
                        <hr>
                        <a href="#" data-bs-target="#addStudentModal" data-bs-toggle="modal" class="nav-link px-3 active">Add a Student</a>
                        <hr>
                        <a href="#" data-bs-target="#removeStudentModal" data-bs-toggle="modal" class="nav-link px-3 active">Remove a Student</a>
                        <hr>
                        <a href="#" data-bs-target="#editModal" data-bs-toggle="modal" class="nav-link px-3 active">Edit</a>
                        <hr>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Dashboard Body -->
    <main class="mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="card text-center mx-auto">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link" onclick="showStatistics()"
                                    style="text-decoration: none; color: black;" aria-current="true"
                                    href="#">Statistics</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="showDB()" style="text-decoration: none; color: black;"
                                    href="#">DB</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <!-- Statistics Body -->
                        <div id="statistics-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="from_date">From</label>
                                    <input type="date" name="date" id="date" class="me-auto">
                                    <label for="to_date" class="ms-auto ps-3">To</label>
                                    <input type="date" name="date" id="date">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-fluid ms-auto me-auto">
                                    <button type="button" class="btn btn-primary">Accept</button>
                                </div>
                            </div>
                        </div>
                        <!-- DB Body -->
                        <div id="db-content" style="display: none;">
                            <p>Database-related content goes here.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Sidebar Modals -->
    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content for Import -->
                    <p>Import data functionality goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add a Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add a Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content for Add Student -->
                    <p>Add student functionality goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Remove a Student Modal -->
    <div class="modal fade" id="removeStudentModal" tabindex="-1" aria-labelledby="removeStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeStudentModalLabel">Remove a Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content for Remove Student -->
                    <p>Remove student functionality goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger">Remove</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content for Edit -->
                    <p>Edit student functionality goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Script -->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/admin_dash.js"></script>

</body>

</html>