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

    $('.studentName').select2({
        dropdownParent: $('#loginModal'),
        width: '100%',
        placeholder: "Select an option",
        allowClear: true,
        matcher: matchCustom
    });

    $('.btn-logoutlib').on('click', function () {
        $('.libraryLogout').modal('show');
    });

    // $('.confirmLibraryLogout').on('click', function () {
    //     let pwd = $('#pwd-logout').val();

    //     if (pwd) {
    //             $.ajax({
    //                 url: './php/confirmLibraryLogout.php',
    //                 data: { pwd: pwd },
    //                 dataType: 'json',

    //                 success: function (response) {
    //                     console.log(response.message);
                        // window.location.href = 'login.html'; 

                        // window.history.pushState(null, null, window.location.href);  
                        // window.onpopstate = function () {
                        //     window.history.pushState(null, null, window.location.href);  
                        // };
    //                 },
    //                 error: function (response) {
    //                     console.log(response.message);
    //                     alert('Incorrect Password');
    //                     $('#pwd-logout').val('');
    //                 }
    //             });
    //     } else {
    //         alert("Please enter the password");
    //     }
    // });
});

// Adding record to the Data Table
$('#acceptLogin').on('click', function () {
    handleLogin();
    $('#studentLoginForm')[0].reset();
    $('#studentName').val('');

    $('#EntryExitKey').hide();
    $('#studentListContainer').hide();

    // $('#studentName').empty();
});

// Logout via button
$('#confirmLogout').on('click', function () {
    handleLogout();
    $('#logoutEntryKey').val('');
    // $('#logoutEntryKey').empty();
});

// login via enter key
$('#loginModal').on('keypress', function (e) {
    if (e.which === 13) { // Check if Enter key is pressed
        e.preventDefault(); // Prevent default form submission
        handleLogin(); // Call the login handling function
    }
});

// Clear EntryKey when changing Student from the List (during login)
$('#studentName').on('change', function () {
    $('#EntryKey').val('');
});

// Press Enter key to login
$('#logoutModal').on('keypress', function (e) {
    if (e.which === 13) {
        e.preventDefault();
        handleLogout();
    }
});

// open modal when you click logout button
$('#LibraryTable').on('click', '.logoutBtn', function () {
    let usn = $(this).data('usn');

    // Store the USN in a hidden input in the modal
    $('#logoutUSN').val(usn);

    // Show the confirmation modal
    $('#logoutModal').modal('show');
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
                $('#studentListContainer').show();
                $('#studentName').html(response); // Update the dropdown option
                $('#EntryExitKey').show();
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                alert('Failed to fetch students. Please try again later.');
            }
        });
    } else {
        $('#studentListContainer').hide(); // Hide if any field is empty
        $('#EntryExitKey').hide();
    }
});

//////////////////////
// DEDICATED FUNCTIONS
//////////////////////
// login 
function handleLogin() {
    let name = $('#studentName').val();
    let year = $('#year').val();
    let branch = $('#branch').val();
    let section = $('#section').val();
    let EntryKey = $('#EntryKey').val();

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
                $('#currTimeIn').val();
                // console.log(response);
                if (response.success) {
                    loadActiveStudents();
                    $('#studentLoginForm')[0].reset();
                    $('#studentName').val('');
                    $('#EntryExitKey').hide();
                    $('#studentListContainer').hide();
                    $('#loginModal').modal('hide');
                } else {
                    alert(response.message);
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

// Load students in the library
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
            response.forEach(function (student) {
                table.row.add([
                    student.Sname,
                    student.Branch,
                    student.Section,
                    student.Cyear,
                    `<button class="btn btn-danger logoutBtn" data-usn="${student.USN}">Logout</button>`
                ]).draw();
            });
        },
        error: function () {
            alert('Failed to load active students.');
        }
    });
}

// logging out from the library
function handleLogout() {
    let usn = $('#logoutUSN').val();
    let entryKey = $('#logoutEntryKey').val();
    // let timeIn = $('#currTimeIn').val();

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
                                $('#logoutEntryKey').val('');
                            } else {
                                $('#logoutEntryKey').val('');
                                alert('Error during logout.');
                            }
                        },
                        error: function () {
                            $('#logoutEntryKey').val('');
                            alert('Error during logout.');
                        }
                    });
                } else {
                    $('#logoutEntryKey').val('');
                    alert('Invalid Entry Key. Please try again.');
                }
            },
            error: function () {
                $('#logoutEntryKey').val('');
                alert('Error validating EntryKey.');
            }
        });
    } else {
        alert('Please enter your EntryKey.');
    }
}

// match the input provided by the user with the entries present in the select element
function matchCustom(params, data) {
    if ($.trim(params.term) === '') {
        return data;
    }
    if (typeof data.text === 'undefined') {
        return null;
    }
    if (data.text.toLowerCase().startsWith(params.term.toLowerCase())) {
        return data;
    }
    return null;
}
