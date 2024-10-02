<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="container">
        <h1 class="title">LIBRARY ATTENDANCE SYSTEM</h1>
        <div class="row">
            <div class="col">
                <button type="button" class="btn-lin btn btn-secondary" data-bs-toggle="modal"
                    data-bs-target="#loginModal">LOGIN</button>
                <button type="button" class="btn-lout btn btn-secondary" data-bs-toggle="modal"
                    data-bs-target="#logoutModal">LOGOUT</button>
            </div>
        </div>
    </div>
    <div class="logo-container">
        <img src=".\Res\cec better.png" alt="Canara Logo" class="logo">
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
                            <input type="text" class="form-control" id="year" placeholder="Enter year">
                        </div>
                        <div class="mb-3">
                            <label for="branch" class="form-label">Branch</label>
                            <input type="text" class="form-control" id="branch" placeholder="Enter branch">
                        </div>
                        <div class="mb-3">
                            <label for="section" class="form-label">Section</label>
                            <input type="text" class="form-control" id="section" placeholder="Enter section">
                        </div>
                        <div class="mb-3">
                            <label for="studentName" class="form-label">Student Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Accept</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="logoutModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Logout</h5>
                    <button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form></form>
                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <input type="text" class="form-control" id="year" placeholder="Enter year">
                        </div>
                        <div class="mb-3">
                            <label for="studentName" class="form-label">Student Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Accept</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.js"></script>
    <!-- <script src=""></script> -->
</body>

</html>