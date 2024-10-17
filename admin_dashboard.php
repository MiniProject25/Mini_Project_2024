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
                            class="nav-link px-3 active">Remove a Student</a>
                        <hr>
                        <a href="#" data-bs-target="#editModal" data-bs-toggle="modal"
                            class="nav-link px-3 active">Edit</a>
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
                    <!-- Form fields to add a student -->
                    <form id="addStudentForm" method="post"> <!-- Updated form without action -->
                        <label for="usn">USN:</label>
                        <input type="text" id="usn" name="usn" class="form-control" required><br>

                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required><br>

                        <label for="branch">Branch:</label>
                        <input type="text" id="branch" name="branch" class="form-control" required><br>

                        <label for="regyear">Registration Year:</label>
                        <input type="text" id="regyear" name="regyear" class="form-control" required><br>

                        <label for="section">Section:</label>
                        <input type="text" id="section" name="section" class="form-control" required><br>

                        <label for="year">Year:</label>
                        <select name="year" id="year">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button> <!-- Form submission button -->
                </div>
            </div>
        </div>
    </div>

    <!-- Remove a Student Modal -->
    <div class="modal fade" id="removeStudentModal" tabindex="-1" aria-labelledby="removeStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="removeStudentForm" method="post" action="Remove.php">
                    <!-- Updated form to redirect to Remove.php -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="removeStudentModalLabel">Remove Student(s)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Content for Remove Student -->
                        <p>Please select an option:</p>
                        <label>
                            <input type="radio" name="choice" value="option1" required> Remove a set of students
                        </label><br>
                        <label>
                            <input type="radio" name="choice" value="option2" required> Remove a student
                        </label><br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Remove</button> <!-- Form submission button -->
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="Edit.php" method="post" id="editStudentForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Content for Edit -->
                        <p>Please select an option:</p>
                        <label>
                            <input type="radio" name="choice" value="option1" onclick="toggleFields()" required> Update students
                        </label><br>
                        <label>
                            <input type="radio" name="choice" value="option2" onclick="toggleFields()" required> Edit a student
                        </label><br><br>

                        <!-- Hidden fields that are shown based on radio selection -->
                        <div id="regYearField" style="display:none;">
                            <label for="regyear">Registration Year:</label>
                            <input type="text" id="regyear" name="regyear"><br><br>
                        </div>

                        <div id="usnField" style="display:none;">
                            <label for="usn">USN:</label>
                            <input type="text" id="usn" name="usn"><br><br>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function toggleFields() {
            var selectedValue = document.querySelector('input[name="choice"]:checked').value;
            var regYearField = document.getElementById("regYearField");
            var usnField = document.getElementById("usnField");

            if (selectedValue === "option1") {
                regYearField.style.display = "block";
                usnField.style.display = "none";
            } else if (selectedValue === "option2") {
                usnField.style.display = "block";
                regYearField.style.display = "none";
            }
        }
    </script>


    <!-- Script -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- AJAX for form submission -->
    <script>
        document.getElementById("addStudentForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent default form submission

            // Create FormData object
            // var formData = new FormData(this);

            // // Send form data to Insert_Edit.php using fetch (AJAX)
            // fetch("Insert.php", {
            //     method: "POST",
            //     body: formData
            // })
            //     .then(response => response.text())
            //     .then(data => {
            //         // Handle the success case
            //         alert("Student added successfully!");
            //         // You could close the modal here, reset the form, or update the UI
            //         document.getElementById("addStudentForm").reset(); // Reset form fields
            //     })
            //     .catch(error => {
            //         // Handle the error case
            //         console.error("Error:", error);
            //         alert("An error occurred while adding the student.");
            //     });

            $.ajax({
                url: 'Insert.php',
                
            });
        });
    </script>

</body>

</html>