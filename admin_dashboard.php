<?php
session_start();

if (!isset($_SESSION['role'])) {
    header('Location: admin.php');
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 page-title ms-auto me-auto">
                <?php if ($_SESSION['role'] === 'admin'): ?>LIBRARIAN PAGE<?php endif; ?>
                <?php if ($_SESSION['role'] === 'super_user'): ?>LIBRARY STATISTICS PAGE<?php endif; ?>
            </span>
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

    <?php if ($_SESSION['role'] === 'admin'): ?>
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
                            <a href="#" data-bs-target="#addBranchModal" data-bs-toggle="modal"
                                class="nav-link px-3 active">Add/Remove a Branch</a>
                            <hr>
                            <a href="#" data-bs-target="#formatModal" data-bs-toggle="modal"
                                class="nav-link px-3 active">Download Format</a>
                            <hr>
                            <a href="#" data-bs-target="#facultyAdditionModal" data-bs-toggle="modal"
                                class="nav-link px-3 active">Add a Faculty</a>
                            <hr>
                            <a href="#" data-bs-target="#facultyRemovalModal" data-bs-toggle="modal"
                                class="nav-link px-3 active">Remove a Faculty</a>
                            <hr>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <!-- Dashboard Body -->
    <main class="mt-5 pt-3" <?php if ($_SESSION['role'] === 'admin'): ?> id="admin-main" <?php endif; ?>>
        <div class=" container-fluid">
            <div class="row">
                <div class="card text-center mx-auto">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link stats" style="text-decoration: none; color: black;"
                                    aria-current="true" href="#">Overall Statistics</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link stud_stat" style="text-decoration: none; color: black;"
                                    href="#">Student-wise
                                    Statistics</a>
                            </li>

                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <li class="nav-item db">
                                    <a class="nav-link" style="text-decoration: none; color: black;" href="#">DB</a>
                                </li>
                            <?php endif; ?>

                            <li class="nav-item history">
                                <a class="nav-link" style="text-decoration: none; color: black;" href="#">History</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <!-- Statistics Body -->
                        <div id="student-stat-content">
                            <form class="studStatInfo" method="POST">
                                <div class="row justify-content-center align-items-center g-2">
                                    <div class="col-auto">
                                        <label for="year">Year</label>
                                    </div>
                                    <div class="col-auto">
                                        <select name="stud_cyear" class="form-select" id="stud_cyear"
                                            aria-label="Select Year">
                                            <option selected disabled>Select year</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label for="branch" class="ms-auto">Branch</label>
                                    </div>
                                    <div class="col-auto">
                                        <select name="stud_branch" class="form-select" id="stud_branch"
                                            placeholder="Enter branch">
                                            <option selected disabled>Select branch</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label for="section" class="ms-auto">Section</label>
                                    </div>
                                    <div class="col-auto">
                                        <select name="stud_section" class="form-select" id="stud_section"
                                            aria-label="Select Section">
                                            <option selected disabled>Select section</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                            <option value="H">H</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label for="name" class="ms-auto">Name</label>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select studentName" id="studentName" name="studentName">
                                            <!-- <option selected disabled>Select student</option> -->
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="reset" id="reset_stud_stat_form" class="btn btn-danger"
                                            style="padding: 2px">RESET</button>
                                        <button type="button" id="print_stud_stats" class="btn btn-primary"
                                            style="padding: 2px">PRINT</button>
                                    </div>
                                </div>
                                <div class="student_stats py-4" id="student_stats">
                                    <div style="margin: 0 auto; width: 300px; text-align: left;" class="left-align">
                                        <p><strong>Last Visit Date:</strong> <span id="last-visit-date"></span></p>
                                        <p><strong>Total Duration:</strong> <span id="total-duration"></span></p>
                                        <p><strong>Average Duration:</strong> <span id="avg-duration"></span></p>
                                        <p><strong>Visit Count:</strong> <span id="visit-count"></span></p>
                                    </div>
                                    <div class="m-4 stud-history-table">
                                        <table id="StudenthistoryTable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>USN</th>
                                                    <th>Student Name</th>
                                                    <th>Branch</th>
                                                    <th>Section</th>
                                                    <th>Year of Study</th>
                                                    <th>Time-in</th>
                                                    <th>Time-out</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Table data -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="statistics-content">
                            <form class="statInfo" id="statsInfo" action="" method="POST">
                                <div class="row justify-content-center align-items-center g-2">
                                    <div class="col-auto">
                                        <label for="from_date">From</label>
                                    </div>
                                    <div class="col-auto">
                                        <input class="form-control" type="date" name="date_from" id="from_date">
                                    </div>
                                    <div class="col-auto">
                                        <label for="to_date" class="ms-auto">To</label>
                                    </div>
                                    <div class="col-auto">
                                        <input class="form-control" type="date" name="date_to" id="to_date">
                                    </div>
                                    <div class="col-auto">
                                        <label for="branch" class="ms-auto">Branch</label>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select" name="branch" id="branch_stat"
                                            placeholder="Enter Branch" required>
                                            <option value="" selected disabled>Select Branch</option>
                                            <option value="">All</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label for="Cyear" class="ms-auto">Year:</label>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select" name="Cyear" id="Cyear_edit">
                                            <option value="" selected>All</option>
                                            <option value="1">I</option>
                                            <option value="2">II</option>
                                            <option value="3">III</option>
                                            <option value="4">IV</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="reset" id="reset_stat_form" class="btn btn-danger"
                                            style="padding: 2px">RESET</button>
                                        <button type="button" id="print_stats" class="btn btn-primary"
                                            style="padding: 2px">PRINT</button>
                                    </div>

                                </div>
                                <!-- Bar Graphs are displayed here -->
                                <div id="Overall_stats">
                                    <div class="mt-3" id="lib-usage-per-hour" style="width: 100%;"></div>
                                    <hr>
                                    <div id="lib-visit-count" style="width: 100%;"></div>
                                    <hr>
                                    <div id="avg-visit-duration" style="width: 100%;"></div>
                                    <hr>
                                </div>
                            </form>
                            <br>
                        </div>

                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <!-- DB Body -->
                            <div id="db-content" class="d-none">
                                <div class="db m-3">
                                    <div class="db-header">
                                        <ul class="nav nav-tabs hist-header-tabs border-bottom">
                                            <li class="nav-item">
                                                <a class="nav-link bg-light studDbBtn"
                                                    style="text-decoration: none; color: black; border-color: #D3D3D3;"
                                                    aria-current="true" href="#">Student DB</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link staffDbBtn"
                                                    style="text-decoration: none; color: black; border-color: #D3D3D3;"
                                                    href="#">Staff DB</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="db-body mt-3">
                                        <div class="studentDb">
                                            <h2><b>Student Users Table</b></h2>
                                            <form class="dbForm" id="dbForm">
                                                <div class="db-filters d-flex align-items-center justify-content-between">
                                                    <div class="db-year">
                                                        <label for="Cyear">Year:</label>
                                                        <select name="Cyear" id="Cyear" class="form-control">
                                                            <option value="" selected>All</option>
                                                            <option value="1">I</option>
                                                            <option value="2">II</option>
                                                            <option value="3">III</option>
                                                            <option value="4">IV</option>
                                                        </select>
                                                    </div>
                                                    <div class="db-branch">
                                                        <label for="branch">Branch:</label>
                                                        <select name="branch" id="branch" class="form-control">
                                                            <option value="" selected>All</option>
                                                        </select>
                                                    </div>
                                                    <div class="db-section">
                                                        <label for="db_section">Section:</label>
                                                        <select name="section" id="db_section" class="form-control">
                                                            <option value="" selected>All</option>
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
                                                    <div class="db-search">
                                                        <label for="searchInput" class="me-2">Search:</label>
                                                        <input type="search" id="searchInput" class="form-control"
                                                            placeholder="Search...">
                                                    </div>
                                                    <div class="db-resetbtn">
                                                        <button type="button" id="db_resetbtn" class="btn btn-danger"
                                                            style="padding: 3px; flex: 1;margin-right: 5px ; width: 100px;">RESET</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <table id="dbtable" class="table table-striped table-bordered border-secondary">
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
                                        <div class="staffDb d-none">
                                            <h2><b>Staff Users Table</b></h2>
                                            <form id="staffDbForm">
                                                <div
                                                    class="staffDb-filters d-flex align-items-center justify-content-between">
                                                    <div class="staffDb-dept">
                                                        <label for="staffDb_dept">Department:</label>
                                                        <select name="dept" id="staffDb_dept">
                                                            <option value="" selected>All</option>
                                                        </select>
                                                    </div>
                                                    <div class="staffDb-search">
                                                        <label for="staffDb_searchInput">Search:</label>
                                                        <input type="search" id="staffDb_searchInput" class="form-control"
                                                            placeholder="Search...">
                                                    </div>
                                                    <div class="staffDb-resetbtn">
                                                        <button type="button" id="staffDb_resetbtn" class="btn btn-danger"
                                                            style="padding: 3px; flex: 1;margin-right: 5px ; width: 100px;">RESET</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <table id="staffDbTable"
                                                class="table table-striped table-bordered border-secondary">
                                                <thead>
                                                    <tr>
                                                        <th>Employee Id</th>
                                                        <th>Name</th>
                                                        <th>Department</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>


                        <!-- History Body -->
                        <div id="history-content" class="d-none">
                            <div class="hist m-3">
                                <div class=""></div>
                                <div class="hist-header">
                                    <ul class="nav nav-tabs hist-header-tabs border-bottom">
                                        <li class="nav-item">
                                            <a class="nav-link bg-light stud"
                                                style="text-decoration: none; color: black; border-color: #D3D3D3;"
                                                aria-current="true" href="#">Student History</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link staff"
                                                style="text-decoration: none; color: black; border-color: #D3D3D3;"
                                                href="#">Staff history</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="hist-body mt-3">
                                    <div class="studentHistory">
                                        <h2><b>Student History Table</b></h2>
                                        <form id="historyForm" class="historyForm">
                                            <div
                                                class="history-filters d-flex align-items-center justify-content-between">
                                                <div class="history-fromDate">
                                                    <label for="history_fromDate">From:</label>
                                                    <input type="date" class="form-control" id="history_fromDate"
                                                        name="fromDate">
                                                </div>
                                                <div class="history-toDate">
                                                    <label for="history_toDate">To:</label>
                                                    <input type="date" class="form-control" id="history_toDate"
                                                        name="toDate">
                                                </div>
                                                <div class="history-btn">
                                                    <div class="history-deletebtn">
                                                        <button type="button" id="history_deletebtn"
                                                            class="btn btn-danger"
                                                            style="padding: 3px; flex: 1; margin-right: 8px;">Delete 5+
                                                            Year
                                                            Old
                                                            Data</button>
                                                    </div>
                                                    <div class="history-resetbtn">
                                                        <button type="button" id="history_resetbtn"
                                                            class="btn btn-primary"
                                                            style="padding: 3px; flex: 1;margin-right: 5px ; width: 100px;">RESET</button>
                                                    </div>
                                                    <div class="history-refreshbtn">
                                                        <button type="button" id="history_refreshbtn"
                                                            class="btn btn-info"
                                                            style="padding: 3px; flex: 1;margin-left: 5px;  width: 100px;">REFRESH</button>
                                                    </div>
                                                    <div>
                                                        <button type="button" id="print_history"
                                                            class="btn btn-secondary"
                                                            style="padding: 3px; flex: 1; margin-left: 5px; width: 100px;">PRINT</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="history-filters d-flex align-items-center justify-content-between">
                                                <div class="history-year">
                                                    <label for="history_Cyear">Year:</label>
                                                    <select name="Cyear" id="history_Cyear" class="form-control">
                                                        <option value="" selected>All</option>
                                                        <option value="1">I</option>
                                                        <option value="2">II</option>
                                                        <option value="3">III</option>
                                                        <option value="4">IV</option>
                                                    </select>
                                                </div>
                                                <div class="history-branch">
                                                    <label for="history_branch">Branch:</label>
                                                    <select name="branch" id="history_branch" class="form-control">
                                                        <option value="" selected>All</option>
                                                    </select>
                                                </div>
                                                <div class="history-section">
                                                    <label for="history_section">Section:</label>
                                                    <select name="section" id="history_section" class="form-control">
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
                                                <div class="history-search">
                                                    <label for="history_searchInput" class="me-2">Search:</label>
                                                    <input type="search" id="history_searchInput" class="form-control"
                                                        placeholder="Search...">
                                                </div>
                                            </div>
                                        </form>
                                        <div id="hist_table">
                                            <table id="historyTable"
                                                class="table table-striped table-bordered border-secondary">
                                                <thead>
                                                    <tr>
                                                        <th>USN</th>
                                                        <th>Student Name</th>
                                                        <th>Branch</th>
                                                        <th>Section</th>
                                                        <th>Year of Study</th>
                                                        <th>Time-in</th>
                                                        <th>Time-out</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Table data -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="staffHistory d-none">
                                    <h2><b>Staff History Table</b></h2>
                                    <form id="staffHistoryForm" class="staffHistoryForm">
                                        <div
                                            class="staffHistory-filters d-flex align-items-center justify-content-between">
                                            <div class="staffHistory-deletebtn">
                                                <button type="button" id="staffHistory_deletebtn" class="btn btn-danger"
                                                    style="padding: 3px; flex: 1; margin-right: 8px;">Delete 5+ Year Old
                                                    Data</button>
                                            </div>
                                            <div class="staffHistory-resetbtn">
                                                <button type="button" id="staffHistory_resetbtn" class="btn btn-primary"
                                                    style="padding: 3px; flex: 1;margin-right: 5px ; width: 100px;">RESET</button>
                                            </div>
                                            <div class="staffHistory-refreshbtn">
                                                <button type="button" id="staffHistory_refreshbtn" class="btn btn-info"
                                                    style="padding: 3px; flex: 1;margin-left: 5px;  width: 100px;">REFRESH</button>
                                            </div>
                                            <div>
                                                <button type="button" id="print_staffHistory" class="btn btn-secondary"
                                                    style="padding: 3px; flex: 1; margin-left: 5px; width: 100px;">PRINT</button>
                                            </div>
                                        </div>
                                        <div class="history-filters d-flex align-items-center justify-content-between">
                                            <div class="staffHistory-fromDate">
                                                <label for="staffHistory_fromDate">From:</label>
                                                <input type="date" class="form-control" id="staffHistory_fromDate"
                                                    name="fromDate">
                                            </div>
                                            <div class="staffHistory-toDate">
                                                <label for="staffHistory_toDate">To:</label>
                                                <input type="date" class="form-control" id="staffHistory_toDate"
                                                    name="toDate">
                                            </div>
                                            <div class="staffHistory-dept">
                                                <label for="staffHistory_dept">Department:</label>
                                                <select name="dept" id="staffHistory_dept" class="form-control">
                                                    <option value="" selected>All</option>
                                                </select>
                                            </div>
                                            <div class="staffHistory-search">
                                                <label for="staffHistory_searchInput" class="me-2">Search:</label>
                                                <input type="search" id="staffHistory_searchInput" class="form-control"
                                                    placeholder="Search...">
                                            </div>
                                        </div>
                                    </form>
                                    <div id="staffHist_table">
                                        <table id="staffHistoryTable"
                                            class="table table-striped table-bordered border-secondary">
                                            <thead>
                                                <tr>
                                                    <th>Employee Id</th>
                                                    <th>Name</th>
                                                    <th>Department</th>
                                                    <th>Time-in</th>
                                                    <th>Time-out</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Table data -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="text-center">
                <p class="mb-0">&copy; 2024 CEC & Canara High School Association Mangalore. All Rights Reserved.</p>
            </footer>
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
                    <form method="POST" action="">
                        <div class="container">
                            <div class="row">
                                <div class="col-4">
                                    <!-- <input type="text" value="1" hidden> -->
                                    <button id="promote1st"
                                        onclick="confirmation('#promote1stForm','promote 1st years')"
                                        form="promote1stForm" class="btn btn-light ms-auto" type="button">1st Year
                                        --
                                        2nd
                                        Year</button>
                                </div>
                                <div class="col-4">
                                    <!-- <input type="text" value="2" hidden> -->
                                    <button id="promote2nd"
                                        onclick="confirmation('#promote2rdForm','promote 2rd years')"
                                        form="promote2rdForm" class="btn btn-light ms-auto" type="button">2nd Year
                                        --
                                        3rd
                                        Year</button>
                                </div>
                                <div class="col-4">
                                    <!-- <input type="text" value="3" hidden> -->
                                    <button id="promote3rd"
                                        onclick="confirmation(event,'#promote3rdForm','promote 3rd years')"
                                        form="promote3rdForm" class="btn btn-light ms-auto" type="button">3rd Year
                                        --
                                        4th
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
                    <form id="importFileForm" method="POST" action="php/import.php" enctype="multipart/form-data">
                        <label for="file">Choose a text file:</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".csv,.xlsx" required><br>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="confirmation(event,'#importFileForm','import file')"
                        form="importFileForm" class="btn btn-primary">Import</button>
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
                    <form id="addStudentForm" method="post" action="php/insert.php">
                        <label for="usn">USN:</label>
                        <input type="text" id="usn" placeholder="Enter Student USN" name="usn" class="form-control"
                            required><br>

                        <label for="sname">Name:</label>
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
                        <select name="cyear" id="cyear" class="form-control">
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
                    <button type="submit" onclick="confirmation(event,'#addStudentForm','Add Student')"
                        form="addStudentForm" class="btn btn-primary">Add</button>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="removeStudentModalLabel">Remove Student(s)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Please select an option:</p>
                        <label>
                            <input type="radio" id="remove_4th" name="removechoice" value="option1" required> Remove
                            4th
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
                    <form id="updateFileForm" method="POST" action="php/update.php" enctype="multipart/form-data">
                        <label for="ufile">Choose a text file:</label>
                        <input type="file" name="ufile" id="ufile" class="form-control" accept=".csv,.xlsx"
                            required><br>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="confirmation(event,'#updateFileForm','import file details')"
                        form="updateFileForm" class="btn btn-primary">Import</button>
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
                            <button type="submit" onclick="confirmation(event,'','edit student')" id="submit_edit_btn"
                                class="btn btn-danger">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Branch addition and Removal Modal -->
    <div class="modal" id="addBranchModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Remove Branch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addRemBranchForm" method="POST" action="php/branch_add_rem.php">
                    <div class="modal-body">
                        <p>Please select an option:</p>
                        <label>
                            <input type="radio" id="add_branch" name="branch_choice" value="addbranch" required> Add
                            a
                            Branch
                        </label><br>
                        <label>
                            <input type="radio" id="remove_branch" name="branch_choice" value="removebranch" required>
                            Remove
                            a Branch
                        </label><br><br>
                        <!-- hidden field -->
                        <div class="enter-branch-field d-none">
                            <label for="">Enter the name of the Branch: </label>
                            <input type="text" name="branch_name" id="branch_name" placeholder="Enter Branch Name">
                        </div>
                        <div class="select-branch-to-delete d-none">
                            <label for="">Select Branch to Remove: </label>
                            <select name="branch_to_remove" id="branch_removal" class="form-control"
                                placeholder="Enter Branch" style="width: 100%">
                                <option value="" selected disabled>Select Branch</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closeBranchBtn" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="addRemBranchBtn" class="btn btn-primary">Proceed</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Format Modal -->
    <div class="modal" id="formatModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Download Format</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div style="margin-left:15px">
                        <label for="importStudentFormat">Import Students Format:</label><br>
                        <img style="width: 250px; height: auto;margin-left:15px;"
                            src="res/import-students-format-ex.png">
                        <button type="button" style="margin-left:10px;margin-top:30px;" class="btn btn-primary"
                            id="importStudentFormat">Download</button>
                    </div><br>
                    <div style="margin-left:15px">
                        <label for="updateUsnFormat">Update USN Format:</label><br>
                        <img style="width: 250px; height: 77px;margin-left:15px" src="res/update-usn-format-ex.png">
                        <button type="button" style="margin-left:10px;margin-top:30px;" class="btn btn-primary"
                            id="updateUSNFormat">Download</button>
                    </div><br>
                </form>
                <div class="modal-footer">
                    <button type="button" id="closeFormatBtn" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Faculty Addition Modal -->
    <div class="modal" id="facultyAdditionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add a Faculty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addFacultyForm" method="post" action="php/insertFaculty.php">
                    <div class="modal-body">
                        <label for="empid">Faculty Employee ID:</label>
                        <input type="text" id="emp_id" placeholder="Enter Faculty ID" name="emp_id" class="form-control"
                            required><br>

                        <label for="sname">Name:</label>
                        <input type="text" id="emp_name" name="emp_name" placeholder="Enter Faculty Name"
                            class="form-control" required><br>

                        <label for="branch">Department:</label>
                        <select name="dept" id="dept" class="form-control" placeholder="Enter Department"
                            style="width: 100%" required>
                            <option value="" selected disabled>Select Department</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="addFacultyBtn" class="btn btn-primary">Proceed</button>
                        <button type="button" id="closeFacultyAdditionBtn" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Faculty Removal Modal -->
    <div class="modal" id="facultyRemovalModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remove a Faculty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="remFacultyForm" method="post">
                    <div class="modal-body">
                        <label for="branch">Select Department:</label>
                        <select name="f_dept" id="f_dept" class="form-control" placeholder="Select Department"
                            style="width: 100%" required>
                            <option value="" selected disabled>Select Department</option>
                        </select><br>

                        <label for="sname">Select Faculty:</label>
                        <select name="fac_name" id="fac_name" class="form-control" placeholder="Select Faculty"
                            style="width: 100%" required>
                            <option value="" selected disabled>Select Faculty</option>
                        </select><br>

                        <label for="empid">Faculty Employee ID:</label>
                        <input type="text" id="rem_emp_id" placeholder="Enter Faculty ID" name="rem_emp_id"
                            class="form-control" required><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="remFacultyBtn" class="btn btn-primary">Proceed</button>
                        <button type="button" id="closeFacultyRemovalBtn" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var message = "<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?>";

            if (message) {
                alert(message);
                <?php unset($_SESSION['message']); ?>  // Clear the session message
            }
        });
    </script>

</body>

</html>