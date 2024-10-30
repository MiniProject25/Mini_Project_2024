<?php
session_start();

if (!isset($_SESSION['library_logged_in'])) {
    header("Location: auth_librarian.php");
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <!-- Logout from the librarian page -->
    <div class="logout-library justify-content-end">
        <button class="btn-logoutlib btn btn-danger" style="margin-right: 50px; margin-left: auto; display: block"
            type="button">LOGOUT</button>
    </div>

    <!-- Librarian Logout Modal -->
    <div class="modal libraryLogout" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="php/confirmLibraryLogout.php" method="POST">
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
                        <button type="submit" onclick="confirmation(event)" class="confirmLibraryLogout btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- main page -->
    <div class="container">
        <h1 class="title">LIBRARY ATTENDANCE SYSTEM</h1>
        <div class="row">
            <div class="col">
                <button type="button" class="btn-lin btn btn-secondary" data-bs-toggle="modal"
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
                    <h5 class="modal-title">Login</h5>
                    <button type="button" data-bs-dismiss="modal" class="btn-close closebtn"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                            </select>
                        </div>
                        <div class="mb-3" id="studentListContainer" style="display: none;">
                            <!--We can do the same drop down option for name section but importing from some other file all names , and when i type sum it should display aa person with sum... -->
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
                <div class="modal-footer">
                    <button type="button" id="closeModal" class="btn btn-secondary"
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
                <div class="modal-body">
                    <p>Please enter your Entry-Key to confirm logout:</p>
                    <input type="password" class="form-control" id="logoutEntryKey" placeholder="Enter EntryKey">
                    <input type="hidden" id="logoutUSN"> <!-- Hidden input to store the USN -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancelLogout" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" onclick="confirmation()" class="btn btn-primary" id="confirmLogout">Logout</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Datatable -->
    <div class="container mt-5">
        <table id="LibraryTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Branch</th>
                    <th>Section</th>
                    <th>Year</th>
                    <th>Time-in</th>
                    <th>Date</th>
                    <th>Logout</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="js/script.js"></script>

    <!-- Datatable Script -->
    <script>
        $('#closeModal, .closebtn, .cancelLogout').on('click', function () {
            // Clear the form fields when the modal is closed
            $('#studentLoginForm')[0].reset();
            $('#studentName').val('');
            $('#studentListContainer').hide();
            $('#EntryExitKey').hide();
            $('#logoutEntryKey').val('');
        });

        $(document).ready(function () {
            $('#LibraryTable').DataTable({
                paging: true,          // Enable pagination
                searching: true,       // Enable search box
                ordering: true,        // Enable column ordering
                pageLength: 7,         // Set default number of rows per page
                lengthMenu: [5, 10, 25, 50], // Page length options
            });
        });
    </script>


</body>

</html>