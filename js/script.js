// fetching branches from the DB
$(document).ready(function () {    
    loadActiveStudents();

    $.ajax({
        url: './php/fetch_branches.php',
        method: 'GET',
        success: function (response) {
            $('#branch').append(response);
        }
    });
});

// fetching students from the DB
$('#section, #year, #branch').on('change', function () {
    let year = $('#year').val();
    let branch = $('#branch').val();
    let section = $('#section').val();

    if (branch && section && year) {
        $.ajax({
            url: './php/fetch_students.php',
            method: 'POST',
            data: {
                year: year,
                branch: branch,
                section: section
            },
            success: function (response) {
                $('#studentName').html(response);
                $('#EntryExitKey').show();
                $('#studentListContainer').show();
            }
        });
    } else {
        $('#studentListContainer').hide(); // Hide if any field is empty
        $('#EntryExitKey').hide();
    }
});

// Adding record to the Data Table
$('#acceptLogin').on('click', function () {
    handleLogin();
    $('#studentLoginForm')[0].reset();
    $('#studentName').val('');
    $('#studentName').empty();
});

$('#loginModal').on('keypress', function (e) {
    if (e.which === 13) { // Check if Enter key is pressed
        e.preventDefault(); // Prevent default form submission
        handleLogin(); // Call the login handling function
    }
});

$('#logoutModal').on('keypress', function (e) {
    if (e.which === 13) {
        e.preventDefault();
        handleLogout();
    }
});

// login 
function handleLogin() {
    let name = $('#studentName').val();
    let year = $('#year').val();
    let branch = $('#branch').val();
    let section = $('#section').val();
    let EntryKey = $('#EntryKey').val();
    console.log(name);  // Add this to debug

    if (name && year && branch && section && EntryKey) {
        $.ajax({
            url: './php/validate_entry_key.php',
            method: 'POST',
            dataType: 'json',
            data: {
                name: name,
                year: year,
                branch: branch,
                section: section,
                EntryKey: EntryKey
            },
            success: function (response) {
                // console.log(response);
                if (response.success) {
                    loadActiveStudents();
                    $('#studentLoginForm')[0].reset();
                    $('#studentName').val('');
                    $('#studentName').empty();
                    $('#loginModal').modal('hide');
                } else {
                    alert('Invalid Entry Key');
                }
            },
            error: function (response) {
                alert(response.message);
            }
        });
    } else {
        alert('Please fill out all fields.');
    }
}

function loadActiveStudents() {
    $.ajax({
        url: './php/get_active_students.php', // The PHP file to retrieve data
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            // Clear the DataTable before adding new rows
            let table = $('#LibraryTable').DataTable();
            table.clear();

            //Iterate over the response and add each student to the DataTable
            response.forEach(function(student) {
                table.row.add([
                    student.Name,
                    student.Branch,            
                    student.Section,            
                    student.Year,             
                    `<button class="btn btn-danger logoutBtn" data-usn="${student.USN}">Logout</button>`
                ]).draw();
            });     
        },
        error: function () {
            alert('Failed to load active students.');
        }
    });
}

// when you click the logout button in the datatable
$('#LibraryTable').on('click', '.logoutBtn', function () {
    let usn = $(this).data('usn');
    console.log("This is the USN: ", usn);

    // Store the USN in a hidden input in the modal
    $('#logoutUSN').val(usn);

    // Show the confirmation modal
    $('#logoutModal').modal('show');
});

// logging out from the library
$('#confirmLogout').on('click', function () {
    handleLogout();
    // $('#studentLoginForm')[0].reset();
    $('#logoutEntryKey').val('');
    $('#logoutEntryKey').empty();
});

function handleLogout() {
    let usn = $('#logoutUSN').val();
    let entryKey = $('#logoutEntryKey').val();

    if (entryKey) {
        $.ajax({
            url: './php/validate_logout.php', 
            method: 'POST',
            dataType: 'json',
            data: {
                usn: usn,
                EntryKey: entryKey
            },
            success: function (response) {
                // console.log(response);
                if (response.success) {
                    $.ajax({
                        url: './php/logout_students.php',  // Your existing logout logic
                        method: 'POST',
                        dataType: 'json',
                        data: { usn: usn },
                        success: function (response) {
                            if (response.success) {
                                // Remove the row from the table
                                const table = $('#LibraryTable').DataTable();
                                let row = table.row($('button[data-usn="' + usn + '"]').parents('tr'));
                                row.remove().draw();

                                // Hide the modal
                                $('#logoutModal').modal('hide');
                            } else {
                                alert('Error during logout.');
                            }
                        },
                        error: function () {
                            alert('Error during logout.');
                        }
                    });
                } else {
                    alert('Invalid Entry Key. Please try again.');
                }
            },
            error: function () {
                alert('Error validating EntryKey.');
            }
        });
    } else {
        alert('Please enter your EntryKey.');
    }
}
