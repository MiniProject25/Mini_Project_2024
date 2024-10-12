// fetching branches from the DB
$(document).ready(function () {
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
    let year = $('#year').val();
    let branch = $('#branch').val();
    let section = $('#section').val();
    let EntryKey = $('#EntryKey').val();

    if (year && branch && section && entryKey) {
        $.ajax({
            url: 'validate_entry_key.php', // PHP script for validation
            method: 'POST',
            data: {
                year: year,
                branch: branch,
                section: section,
                EntryKey: EntryKey
            },
            success: function (response) {
                if (response.success) {
                    // Add student data to the DataTable
                    let student = response.data;
                    $('#LibraryTable').DataTable().row.add([
                        student.Name,
                        student.USN,
                        student.Branch,
                        student.Section,
                        student.RegYear
                    ]).draw();

                    // Close the modal after success
                    $('#loginModal').modal('hide');
                } else {
                    alert('Invalid Entry Key');
                }
            },
            error: function () {
                alert('Error during login.');
            }
        });
    } else {
        alert('Please fill out all fields.');
    }
});