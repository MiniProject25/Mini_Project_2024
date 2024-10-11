<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
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
                    <button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="year" class="form-label">Year of Registration</label>
                            <select class="form-select" id="year" aria-label="Select Year">
                                <option selected disabled>Select year</option>
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="branch" class="form-label">Branch</label>
                            <select class="form-select" id="branch" placeholder="Enter branch">
                                <option selected disabled>Select branch</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="section" class="form-label">Section</label>
                            <select class="form-select" id="section" aria-label="Select Section">
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
                            <select class="form-select" id="studentName" name="studentName">
                                <option selected disabled>Select student</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="acceptbtn">Accept</button>
                </div>
            </div>
        </div>
    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>

    <!-- <script src=""></script> -->
</body>

</html>