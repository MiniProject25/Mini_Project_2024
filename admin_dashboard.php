<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/admin_dash.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 page-title ms-auto me-auto">Library Admin Page</span>
            <a class="nav-link px-3 active" style="color: white; cursor: pointer" data-bs-target="#adminLogoutModal"
                data-bs-toggle="modal">Logout</a>
        </div>
    </nav>

    <!-- Librarian Logout Modal -->
    <div class="modal" id="adminLogoutModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="php/confirmAdminDashLogout.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Enter Password to Logout</p>
                        <input type="password" name="pwd-logout" id="pwd-logout" class="form-control"
                            placeholder="Enter Password" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" onclick="confirmation(event,'', 'log out')"
                            class="confirmLibraryLogout btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-body p-0">
            <div class="navbar-dark">
                <ul class="navbar-nav">
                    <li>
                        <a href="#" data-bs-target="#importModal" data-bs-toggle="modal"
                            class="nav-link px-3 active">Import</a>
                        <hr>
                        <a href="#" data-bs-target="#addStudentModal" data-bs-toggle="modal"
                            class="nav-link px-3 active">Add a Student</a>
                        <hr>
                        <a href="#" data-bs-target="#removeStudentModal" data-bs-toggle="modal"
                            class="nav-link px-3 active">Remove Student(s)</a>
                        <hr>
                        <a href="#" data-bs-target="#editModal" data-bs-toggle="modal" class="nav-link px-3 active">Edit
                            Student(s)</a>
                        <hr>
                        <a href="#" data-bs-target="#promoteModal" data-bs-toggle="modal"
                            class="nav-link px-3 active">Promote Students</a>
                        <hr>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Dashboard Body -->
    <main class="mt-5 pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="card text-center mx-auto">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link stats" style="text-decoration: none; color: black;"
                                    aria-current="true" href="#">Statistics</a>
                            </li>
                            <li class="nav-item db">
                                <a class="nav-link" style="text-decoration: none; color: black;" href="#">DB</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <!-- Statistics Body -->
                        <div id="statistics-content">
                            <div class="row">
                                <div class="col-md-12 statInfo">
                                    <form id="statsInfo" action="" method="POST">
                                        <label for="from_date">From</label>
                                        <input type="date" name="date_from" id="from_date" class="me-auto">
                                        <label for="to_date" class="ms-auto ps-3">To</label>
                                        <input type="date" name="date_to" id="to_date">
                                        <label for="branch" class="ps-3">Branch</label>
                                        <select name="branch" id="branch_stat" placeholder="Enter Branch" required>
                                            <option value="" selected disabled>Select Branch</option>
                                            <option value="">All</option>
                                        </select>
                                        <label for="Cyear" class="ps-3">Year:</label>
                                        <select name="Cyear" id="Cyear_edit">
                                            <option value="" selected>All</option>
                                            <option value="1">I</option>
                                            <option value="2">II</option>
                                            <option value="3">III</option>
                                            <option value="4">IV</option>
                                        </select>
                                        <button type="reset" id="reset_stat_form" class="btn btn-danger ms-3" style="padding: 1px">RESET</button>
                                    </form>
                                </div>
                                <div id="lib-usage-per-hour" style="width: 100%;"></div>
                                <div id="statistics-chart" style="width: 100%;"></div>
                            </div>
                            <br>
                        </div>
                        <!-- DB Body -->
                        <div id="db-content" class="d-none">
                            <h2>Users Table</h2>
                            <div class="db-filters d-flex align-items-center justify-content-between">
                                <div class="db-year">
                                    <label for="Cyear">Year:</label>
                                    <select type="submit" name="Cyear" id="Cyear" class="form-control">
                                        <option value="" selected>All</option>
                                        <option value="1">I</option>
                                        <option value="2">II</option>
                                        <option value="3">III</option>
                                        <option value="4">IV</option>
                                    </select>
                                </div>
                                <div class="db-branch">
                                    <label for="branch">Branch:</label>
                                    <select tyoe="submit" name="branch" id="branch" class="form-control">
                                        <option value="" selected>All</option>
                                    </select>
                                </div>
                                <div class="db-section">
                                    <label for="section">Section:</label>
                                    <select type="submit" name="section" id="section" class="form-control">
                                        <option value="" selected>All</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                        <option value="G">G</option>
                                    </select>
                                </div>
                                <div class="db-search">
                                    <label for="searchInput" class="me-2">Search:</label>
                                    <input type="search" id="searchInput" class="form-control" placeholder="Search...">
                                </div>
                            </div>
                            <table id="dbtable" class="table table-striped table-bordered">
                                <thead>
                                    <th>USN</th>
                                    <th>Student Name</th>
                                    <th>Branch</th>
                                    <th>Year of Registration</th>
                                    <th>Section</th>
                                    <th>Year of Study</th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Sidebar Modals -->
    <!-- Promote Modal -->
    <div class="modal fade" id="promoteModal" tabindex="-1" aria-labelledby="promoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="promoteModalLabel">Promote Students</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for File Upload -->
                    <form method="POST" action4="">
                        <div class="container">
                            <div class="row">
                                <div class="col-4">
                                    <!-- <input type="text" value="1" hidden> -->
                                    <button id="promote1st" onclick="confirmation('#promote1stForm','promote 1st years')" form="promote1stForm" class="btn btn-light ms-auto" type="button">1st Year -- 2nd
                                        Year</button>
                                </div>
                                <div class="col-4">
                                    <!-- <input type="text" value="2" hidden> -->
                                    <button id="promote2nd" onclick="confirmation('#promote2rdForm','promote 2rd years')" form="promote2rdForm" class="btn btn-light ms-auto" type="button">2nd Year -- 3rd
                                        Year</button>
                                </div>
                                <div class="col-4">
                                    <!-- <input type="text" value="3" hidden> -->
                                    <button id="promote3rd" onclick="confirmation(event,'#promote3rdForm','promote 3rd years')" form="promote3rdForm" class="btn btn-light ms-auto" type="button">3rd Year -- 4th
                                        Year</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for File Upload -->
                    <form id="importFileForm" method="POST" action="php/import.php" enctype="multipart/form-data">
                        <label for="file">Choose a text file:</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".csv,.xlsx" required><br>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="confirmation(event,'#importFileForm','import file')" form="importFileForm"
                        class="btn btn-primary">Import</button>
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
                    <!-- Form fields to add a student -->
                    <form id="addStudentForm" method="post" action="php/insert.php"> <!-- Set action to insert.php -->
                        <label for="usn">USN:</label>
                        <!-- <input type="text" id="usn" name="usn" class="form-control" placeholder="Enter USN" required><br> -->
                        <input type="text" id="usn" placeholder="Enter Student USN" name="usn" class="form-control"
                            required><br>

                        <label for="sname">Name:</label>
                        <!-- <input type="text" id="sname" name="sname" class="form-control" placeholder="Enter Name" required><br> -->
                        <input type="text" id="sname" name="sname" placeholder="Enter Student Name" class="form-control"
                            required><br>

                        <label for="branch">Branch:</label>
                        <select name="branch" id="branch_add" class="form-control" placeholder="Enter Branch"
                            style="width: 100%" required>
                            <option value="" selected disabled>Select Branch</option>
                        </select>
                        <br>

                        <label for="regyear">Registration Year:</label>
                        <input type="text" placeholder="Enter Year of Registration" name="regyear" class="form-control"
                            required><br>

                        <label for="section">Section:</label>
                        <select name="section" id="section" class="form-control">
                            <option selected disabled>Select Section</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                        </select><br>

                        <label for="cyear">Year:</label>
                        <select name="cyear" id="cyear" class="form-control"> <!-- Updated name to 'year' -->
                            <option selected disabled>Select year</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeAddStudentModal"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="confirmation(event,'#addStudentForm','Add Student')" form="addStudentForm"
                        class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Remove a Student Modal -->
    <div class="modal fade" id="removeStudentModal" tabindex="-1" aria-labelledby="removeStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="removeStudentForm" method="post" action="php/Remove.php">
                    <!-- Updated form to redirect to Remove.php -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="removeStudentModalLabel">Remove Student(s)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Content for Remove Student -->
                        <p>Please select an option:</p>
                        <label>
                            <input type="radio" id="remove_4th" name="removechoice" value="option1" required> Remove 4th
                            Year
                        </label><br>
                        <label>
                            <input type="radio" id="remove_one" name="removechoice" value="option2" required> Remove
                            a student
                        </label><br><br>

                        <!-- Hidden fields that are shown based on radio selection -->
                        <div id="usnField" class="d-none">
                            <label for="usn">USN:</label>
                            <input type="text" name="usn" placeholder="Enter USN"><br><br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary closeRemoveModal"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" onclick="confirmation(event,'#removeStudentForm','remove student(s)')"
                            form="removeStudentForm" class="btn btn-danger">Remove</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editStudentForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Please select an option:</p>
                        <label>
                            <input type="radio" name="choice" value="updateStudent" required>
                            Update USN
                        </label><br>
                        <label>
                            <input type="radio" name="choice" value="editStudent" required>
                            Edit a student
                        </label><br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary closeEditModal"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" id="continueEditBtn" class="btn btn-danger">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Import Data for updating the USN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for File Upload -->
                    <form id="updateFileForm" method="POST" action="php/update.php" enctype="multipart/form-data">
                        <label for="file">Choose a text file:</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".csv,.xlsx" required><br>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="confirmation(event,'#updateFileForm','import file details')" form="updateFileForm"
                        class="btn btn-primary">Import</button>
                </div> 
            </div>
        </div>
    </div>

    <!-- EditOne Modal -->
    <div class="modal fade" id="editOneModal" tabindex="-1" aria-labelledby="editOneModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOneModalLabel">Edit Student Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="editUsnField">
                            <label for="usn">USN:</label>
                            <input type="text" name="usn" class="form-control edit_usn" style="width: 100%"><br>
                            <button type="button" id="processUSN" class="btn btn-primary">Proceed</button>
                        </div>
                        <div class="edit-one-modal d-none">
                            <div class="form-group mb-3">
                                <label for="name">Name:</label>
                                <input type="text" id="name_edit" name="name" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="branch">Branch:</label>
                                <select name="branch" id="branch_edit" class="form-control" placeholder="Enter Branch"
                                    style="width: 100%" required>
                                    <option value="" selected disabled>Select Branch</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="regyear">Registration Year:</label>
                                <input type="text" id="regyear_edit" name="regyear" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="section">Section:</label>
                                <select name="section" id="section_edit" class="form-control" required>
                                    <option value="" selected disabled>Select Section</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    <option value="G">G</option>
                                    <option value="H">H</option>
                                    <option value="I">I</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="cyear">Year:</label>
                                <select name="cyear" id="cyear_edit" class="form-control" required>
                                    <option value="" selected disabled>Select Year</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-none">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" onclick="confirmation(event,'','edit student')" id="submit_edit_btn" class="btn btn-danger">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/admin_script.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var message = "<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?>";

            if (message) {
                alert(message);
                <?php unset($_SESSION['message']); ?>  // Clear the session message
            }
        });

        $('.closeRemoveModal').on('click', function () {
            $('#regYearField').addClass('d-none');
            $('#usnField').addClass('d-none');
            $('#remove_set, #remove_one').prop('checked', false);
        });

        $('.closeEditModal').on('click', function () {
            // $('#editRadio').prop('checked', false);
            $('#editStudentForm')[0].reset();
        });

        $('.closeAddStudentModal').on('click', function () {
            $('#addStudentForm')[0].reset();
        });
    </script>

</body>

</html>