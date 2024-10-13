// fetching branches from the DB
$(document).ready(function () {
    loadActiveStudents();
    $.ajax({
        url: 'fetch_branches.php',
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
            url: 'fetch_students.php',
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

function handleLogin() {
    let year = $('#year').val();
    let branch = $('#branch').val();
    let section = $('#section').val();
    let EntryKey = $('#EntryKey').val();
    console.log(year, branch, section, EntryKey);

    if (year && branch && section && EntryKey) {
        $.ajax({
            url: 'validate_entry_key.php',
            method: 'POST',
            dataType: 'json',
            data: {
                year: year,
                branch: branch,
                section: section,
                EntryKey: EntryKey
            },
            success: function (response) {
                // console.log(response);
                if (response.success) {
                    loadActiveStudents();

                    $('#loginModal').modal('hide');
                } else {
                    alert('Invalid Entry Key');
                }
            },
            error: function (response) {
                // console.log(response);
                alert('Error during login.');
            }
        });
    } else {
        alert('Please fill out all fields.');
    }
}

//
function loadActiveStudents() {
    $.ajax({
        url: 'get_active_students.php', // The PHP file to retrieve data
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            // Clear the DataTable before adding new rows
            let table = $('#LibraryTable').DataTable();
            table.clear();

            // Iterate over the response and add each student to the DataTable
            response.forEach(function (student) {
                table.row.add([
                    student.Name,
                    student.USN,
                    student.Branch,
                    student.Section,
                    student.RegYear,
                    `<button class="btn btn-danger logoutBtn" data-usn="${student.USN}">Logout</button>`
                ]).draw();
            });
        },
        error: function () {
            alert('Failed to load active students.');
        }
    });
}

// deleting students from the datatable (functionality of logout button)
$(document).on('click', '.logoutBtn', function () {
    const usn = $(this).data('usn');

    // AJAX request to remove student from active table
    $.ajax({
        url: 'logout_students.php',
        method: 'POST',
        dataType: 'json',
        data: { usn: usn },
        success: function (response) {
            if (response.success) {
                const table = $('#LibraryTable').DataTable();
                table.row($(this).parents('tr')).remove().draw();
            } else {
                alert('Error logging out Student');
            }
            // loadActiveStudents();
        }.bind(this),
        error: function () {
            alert('Error during logout');
        }
    });
});