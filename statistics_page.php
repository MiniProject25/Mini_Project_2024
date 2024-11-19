<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics Dashboard</title>
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
                STATISTICS PAGE
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

    <!-- Dashboard Body -->
    <main class="mt-5 pt-3">
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
                                            <option value="I">I</option>
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
                                                        <option value="H">H</option>
                                                        <option value="I">I</option>
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