<?php
session_start();

if (!isset($_SESSION['library_logged_in'])) {
    header("Location: index_page_auth.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
    <link href="css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <!-- Logout from the librarian page -->
    <nav class="navbar navbar-dark">
        <a href="#" class="navbar-brand">Library</a>
        <button class="btn-logoutlib btn btn-danger mx-3" type="button">LOGOUT</button>
    </nav>

    <!-- Librarian Logout Modal -->
    <div class="modal libraryLogout" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="php/confirmLibraryLogout.php" id="libLogoutForm" method="POST">
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
                        <button type="submit" onclick="librarianConfirmation(event)"
                            class="confirmLibraryLogout btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- main page -->
    <div class="container">
        <h1 class="title">LIBRARY VISIT MONITORING SYSTEM</h1>
        <div class="row">
            <div class="col">
                <button type="button" id="StudFacLoginBtn" class="btn-lin btn btn-secondary" data-bs-toggle="modal"
                    data-bs-target="#loginModal">LOGIN</button>
            </div>
        </div>
    </div>
    <div class="logo-container">
        <img src=".\Res\cec-better.png" alt="Canara Logo" class="logo">
    </div>

    <div class="modal" tabindex="-1" id="loginModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link bg-light studentLogin" id="studentBtn"
                                style="text-decoration: none; color: black; border-color: #D3D3D3;" href="#">
                                <h6>Student Login</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link staffLogin" id="staffBtn"
                                style="text-decoration: none; color: black; border-color: #D3D3D3;" href="#">
                                <h6>Staff Login</h6>
                            </a>
                        </li>
                    </ul>
                    <button type="button" data-bs-dismiss="modal" class="btn-close"
                        aria-label="Close"></button>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Student Modal -->
                    <div id="studentLogin-content">
                        <form method="POST" id="studentLoginForm">
                            <div class="mb-3">
                                <label for="year" class="form-label">Year</label>
                                <select name="year" class="form-select" id="year" aria-label="Select Year">
                                    <option selected disabled>Select year</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="branch" class="form-label">Branch</label>
                                <select name="branch" class="form-select" id="branch" placeholder="Enter branch">
                                    <option selected disabled>Select branch</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="section" class="form-label">Section</label>
                                <select name="section" class="form-select" id="section" aria-label="Select Section">
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
                            <div class="mb-3" id="studentListContainer" style="display: none;">
                                <label for="studentName" class="form-label">Student Name</label>
                                <select class="form-select studentName" id="studentName" name="studentName">
                                    <!-- <option selected disabled>Select student</option> -->
                                </select>
                            </div>
                            <div class="mb-3" id="EntryExitKey" style="display: none;">
                                <label for="EntryKey">Entry Key (Last 3 Characters of your USN (Eg: 4CB22CSXXX))</label>
                                <br>
                                <input name="EntryKey" type="password" id="EntryKey" class="form-control mt-2"
                                    placeholder="Entry Key" aria-label="EntryKey">
                            </div>
                        </form>
                    </div>

                    <!-- Staff Modal -->
                    <div id="staffLogin-content">
                        <form method="POST" id="staffLoginForm">
                            <div class="mb-3 dept d-none">
                                <label for="dept" class="form-label">Department</label>
                                <select name="dept" class="form-select" id="dept" placeholder="Enter department">
                                    <option selected disabled>Enter Department</option>
                                </select>
                            </div>
                            <div class="mb-3 staffListContainer d-none">
                                <label for="staffName" class="form-label">Staff Name</label>
                                <select class="form-select staffName" id="staffName" name="staffName">
                                    <!-- <option selected disabled>Select student</option> -->
                                </select>
                            </div>
                            <div class="mb-3 staffEntryExitKey d-none">
                                <label for="staffEntryKey">Entry Key (Last 5 Characters of your EMP_ID)</label>
                                <br>
                                <input name="staffEntryKey" type="password" id="staffEntryKey" class="form-control mt-2"
                                    placeholder="Entry Key" aria-label="EntryKey">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer loginFacultyOrStudentFooter">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="acceptLogin">Accept</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" data-bs-dismiss="modal" class="btn-close closebtn"
                        aria-label="Close"></button>
                    </button>
                </div>
                <div class="modal-body" id="usnLogout">
                    <form method="POST">
                        <p>Please enter your Entry-Key to confirm logout (Student):</p>
                        <input type="password" class="form-control" id="logoutEntryKey" placeholder="Enter EntryKey">
                        <input type="hidden" id="logoutUSN"> <!-- Hidden input to store the USN -->
                    </form>
                </div>
                <div class="modal-body d-none" id="empLogout">
                    <form method="POST">
                        <p>Please enter your Entry-Key to confirm logout (Faculty):</p>
                        <input type="password" class="form-control" id="staffLogoutEntryKey"
                            placeholder="Enter EntryKey">
                        <input type="hidden" id="logoutEmp"> <!-- Hidden input to store the emp_id -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancelLogout" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="confirmLogout">Logout</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Datatable -->
    <div class="mt-3 dataTableContainer">
        <div class="dataTableContainer-content">
            <div class="dataTableContainer-header mb-1" style="border-bottom: 1px solid #d3d3d3;">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item studentTable">
                        <a class="nav-link sBtn bg-light"
                            style="text-decoration: none; color: black; border-color: #D3D3D3;" href="#">
                            <h6>Student Login</h6>
                        </a>
                    </li>
                    <li class="nav-item staffTable">
                        <a class="nav-link fBtn" style="text-decoration: none; color: black; border-color: #D3D3D3;"
                            href="#">
                            <h6>Staff Login</h6>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="dataTableConatiner-body mt-3">
                <div class="studentTable-content">
                    <table id="studentTable" class="table table-striped table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Branch</th>
                                <th>Section</th>
                                <th>Year</th>
                                <th>Time-in</th>
                                <th>Date</th>
                                <th>Logout</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">

                        </tbody>
                    </table>
                </div>
                <div class="staffTable-content  d-none">
                    <table id="staffTable" class="table table-striped table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Department</th>
                                <th>Time-in</th>
                                <th>Date</th>
                                <th>Logout</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- copyright -->
    <footer class="text-center">
        <p class="mb-0">&copy; 2024 Canara Engineering College | All Rights Reserved | Designed by Dr.Demian Antonty D'mello, H.Sumith Shenoy, Christy Sojan & Harivardhan Mallya</p>
    </footer>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/dataTables.bootstrap5.min.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/script.js"></script>

</body>

</html>