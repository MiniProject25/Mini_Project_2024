// fetching branches from the DB
$(document).ready(function () {
    loadActiveStudents();
    loadActiveStaff();

    $.ajax({
        url: './php/fetch_branches.php',
        method: 'GET',
        success: function (response) {
            $('#branch').append(response);
            $('#dept').append(response);
        }
    });

    $('.studentName').select2({
        dropdownParent: $('#loginModal'),
        width: '100%',
        placeholder: "Select an option",
        allowClear: true,
        matcher: matchCustom
    });

    $('.staffName').select2({
        dropdownParent: $('#loginModal'),
        width: '100%',
        placeholder: "Select an option",
        allowClear: true,
        matcher: matchCustom
    });

    $('.btn-logoutlib').on('click', function () {
        $('.libraryLogout').modal('show');
    });

    $('#studentTable').DataTable({
        paging: true,          // Enable pagination
        searching: true,       // Enable search box
        ordering: true,        // Enable column ordering
        pageLength: 5,         // Set default number of rows per page
        lengthMenu: [5, 10, 25, 50], // Page length options
    });

    $('#staffTable').DataTable({
        paging: true,          // Enable pagination
        searching: true,       // Enable search box
        ordering: true,        // Enable column ordering
        pageLength: 5,         // Set default number of rows per page
        lengthMenu: [5, 10, 25, 50], // Page length options
    });
});

// Adding record to the Data Table
$('#acceptLogin').on('click', function () {
    if ($('#studentLogin-content').is(':visible')) {
        handleStudentLogin();
        $('#studentLoginForm')[0].reset();
        $('#studentName').val('');

        $('#EntryExitKey').hide();
        $('#studentListContainer').hide();

        // $('#studentName').empty();
    }
    else if ($('#staffLogin-content').is(':visible')) {
        handleStaffLogin();
        $('#staffLoginForm')[0].reset();
        $('#staffName').val('');
        $('.staffEntryExitKey').addClass('d-none');
        $('.staffListContainer').addClass('d-none');
    }
});

// Logout via button
$('#confirmLogout').on('click', function () {
    if ($('#usnLogout').is(':visible')) {
        handleStudentLogout();
        $('#logoutEntryKey').val('');
    }
    else if ($('#empLogout').is(':visible')) {
        handleStaffLogout();
        $('#staffLogoutEntryKey').val('');
    }
    // $('#logoutEntryKey').empty();
});

// login via enter key
$('#loginModal').on('keypress', function (e) {
    if (e.which === 13 && $('#studentLogin-content').is(':visible')) { // Check if Enter key is pressed
        e.preventDefault(); // Prevent default form submission
        handleStudentLogin(); // Call the login handling function
        $('#EntryExitKey').hide();
        $('#studentListContainer').hide();
    }
    else if (e.which === 13 && $('#staffLogin-content').is(':visible')) {
        e.preventDefault();
        handleStaffLogin();
        $('.staffEntryExitKey').addClass('d-none');
        $('.staffListContainer').addClass('d-none');
    }
});

$('#logoutModal').on('keypress', function (e) {
    if (e.which === 13 && $('#usnLogout').is(':visible')) {
        e.preventDefault();
        handleStudentLogout();
        $('#logoutEntryKey').val('');
    }
    else if (e.which === 13 && $('#empLogout').is(':visible')) {
        e.preventDefault();
        handleStaffLogout();
        $('#staffLogoutEntryKey').val('');
    }
});

// Clear EntryKey when changing Student from the List (during login)
$('#studentName').on('change', function () {
    $('#EntryKey').val('');
});

$('#staffName').on('change', function () {
    $('#staffEntryKey').val('');
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
                $('#studentName').val(null).trigger('change');
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

$('#dept').on('change', function () {
    let dept = $('#dept').val();

    if (dept) {
        $.ajax({
            url: './php/fetch_faculty.php',
            method: 'POST',
            data: {
                dept: dept
            },
            success: function (response) {
                $('#staffName').html(response); // Update the dropdown option
                $('#staffName').val(null).trigger('change');
                $('.staffListContainer').removeClass('d-none');
                $('.staffEntryExitKey').removeClass('d-none');
                $('.facAuth').removeClass("d-none");
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                alert('Failed to fetch staff. Please try again later.');
            }
        });
    }
});

//////////////////////
// DEDICATED FUNCTIONS
//////////////////////
// login 
function handleStudentLogin() {
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
                // console.log(response);
                if (response.success) {
                    loadActiveStudents();
                    $('#studentLoginForm')[0].reset();
                    $('#studentName').val('');
                    // $('#EntryExitKey').hide();
                    // $('#studentListContainer').hide();
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

function handleStaffLogin() {
    let name = $('#staffName').val();
    let dept = $('#dept').val();
    let entryKey = $('#staffEntryKey').val();

    if (name && dept && entryKey) {
        $.ajax({
            url: './php/validate_faculty_entry_key.php',
            method: 'POST',
            dataType: 'json',
            data: {
                name: name,
                dept: dept,
                entryKey: entryKey,
            },
            success: function (response) {
                // console.log(name);
                if (response.success) {
                    loadActiveStaff();
                    $('#staffLoginForm')[0].reset();
                    $('#staffName').val('');
                    $('#staffEntryExitKey').addClass("d-none");
                    $('#staffListContainer').addClass("d-none");
                    $('#loginModal').modal('hide');
                } else {
                    $('#staffLoginForm')[0].reset();
                    alert(response.message);
                }
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
            let studentTable = $('#studentTable').DataTable();
            studentTable.clear();

            //Iterate over the response and add each student to the DataTable
            response.forEach(function (student) {
                studentTable.row.add([
                    student.Sname,
                    student.Branch,
                    student.Section,
                    student.Cyear,
                    student.TimeIn,
                    student.Date,
                    `<button class="btn btn-danger studentLogoutBtn" data-usn="${student.USN}" data-name="${student.Sname}" data-timein="${student.TimeIn}">Logout</button>`
                ]).draw();
            });

            $('#studentTable').off('click', '.studentLogoutBtn').on('click', '.studentLogoutBtn', function (event) {
                const button = $(this);
                const name = button.data('name');
                const timeIn = button.data('timein');
                const timeOut = new Date().toLocaleTimeString('en-GB');

                // Check for confirmation before proceeding with logout
                if (confirmation(name, timeIn, timeOut)) {
                    // Proceed with logout actions
                    $('#logoutUSN').val(button.data('usn'));
                    $('#usnLogout').removeClass('d-none');
                    $('#empLogout').addClass('d-none');
                    $('#logoutModal').modal('show');
                }
            });
        },
        error: function () {
            alert('Failed to load active students.');
        }
    });
}

function loadActiveStaff() {
    $.ajax({
        url: './php/get_active_staffs.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            let staffTable = $('#staffTable').DataTable();
            staffTable.clear();

            response.forEach(function (faculty) {
                staffTable.row.add([
                    faculty.fname,
                    faculty.Dept,
                    faculty.TimeIn,
                    faculty.Date,
                    `<button class="btn btn-danger staffLogoutBtn" data-emp_id="${faculty.emp_id}" data-name="${faculty.fname}"
                    data-timein="${faculty.TimeIn}">Logout</button>`
                ]).draw();
            });
            $('#staffTable').off('click', '.staffLogoutBtn').on('click', '.staffLogoutBtn', function (event) {
                const button = $(this);
                const name = button.data('name');
                const timeIn = button.data('timein');
                const timeOut = new Date().toLocaleTimeString('en-GB');

                // Check for confirmation before proceeding with logout
                if (confirmation(name, timeIn, timeOut)) {
                    // Proceed with logout actions
                    $('#logoutEmp').val(button.data('emp_id'));
                    $('#usnLogout').addClass('d-none');
                    $('#empLogout').removeClass('d-none');
                    $('#logoutModal').modal('show');
                }
            });
        },
        error: function () {
            alert('Failed to load active staffs.');
        }
    });
}

// logging out from the library
function handleStudentLogout() {
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
                                const studentTable = $('#studentTable').DataTable();
                                let row = studentTable.row($('button[data-usn="' + usn + '"]').parents('tr'));
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

function handleStaffLogout() {
    let empId = $('#logoutEmp').val();
    let entryKey = $('#staffLogoutEntryKey').val();
    // console.log("empId: " + empId + " entryKey: " + entryKey);

    if (entryKey) {
        $.ajax({
            url: './php/validate_faculty_logout.php',
            method: 'POST',
            dataType: 'json',
            data: {
                empId: empId,
                EntryKey: entryKey,
            },
            success: function (response) {
                if (response.success) {
                    $.ajax({
                        url: './php/logout_staffs.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            empId: empId
                        },
                        success: function (response) {
                            if (response.success) {
                                const staffTable = $('#staffTable').DataTable();
                                let row = staffTable.row($('button[data-emp_id="' + empId + '"]').parents('tr'));
                                row.remove().draw();

                                $('#staffLogoutEntryKey').val('');
                                $('#logoutModal').modal('hide');
                            }
                            else {
                                $('#staffLogoutEntryKey').val('');
                                alert('Error during logout.');
                            }
                        },
                        error: function () {
                            $('#staffLogoutEntryKey').val('');
                            alert('Error during logout.');
                        }
                    });
                }
                else {
                    $('#staffLogoutEntryKey').val('');
                    alert('Invalid Credentials Entered. Please try again.');
                }
            },
            error: function () {
                $('#staffLogoutEntryKey').val('');
                alert(response.message);
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

function librarianConfirmation(event) {
    const isConfirmed = confirm("Are you sure you want to Log out from the librarian page?");

    if (!isConfirmed) {
        event.preventDefault();
    }
}

function confirmation(name, timeIn, timeOut) {
    return confirm(`${name},\nYour login time is ${timeIn} and your logout time will be ${timeOut}.\nAre you sure you want log out?`);
}

$(".studentLogin").click(function (e) {
    e.preventDefault();
    $("#staffLogin-content").addClass("d-none");
    $("#studentLogin-content").removeClass("d-none");
    $("#studentBtn").addClass("bg-light");
    $("#staffBtn").removeClass("bg-light");
});

$(".staffLogin").click(function (e) {
    e.preventDefault();
    $(".dept").removeClass("d-none");
    $("#staffLogin-content").removeClass("d-none");
    // $(".staffListContainer").show();
    // $(".staffEntryExitKey").show();
    // $('#fac_auth').removeClass("d-none");
    $("#studentLogin-content").addClass("d-none");
    $("#studentBtn").removeClass("bg-light");
    $("#staffBtn").addClass("bg-light");

    // if($('#fac_auth').is(':visible')) {
    //     $('.loginFacultyOrStudentFooter').addClass('d-none');
    // }else {
    //     $('.loginFacultyOrStudentFooter').removeClass('d-none');
    // }
});

// $("#fac_login_access_btn").on('click', function(e) {
//     e.preventDefault();
//     let pass = $('#pass_to_enter_fac_login').val();

//     $.ajax({
//         url: "php/validateEntryToFacultyLogin.php",
//         method: 'POST',
//         dateType: 'json',
//         data: {
//             pass: pass
//         },
//         success: function(response) {
//             if(response.success) {
//                 console.log("Bruh");
//                 $("#fac_auth").hide();
//                 $(".main-login").show();
//             }
//             else {
//                 console.log("No Bruh");
//             }
//         }
//     });
// });

$(".studentTable").click(function (e) {
    e.preventDefault();
    $(".studentTable-content").removeClass("d-none");
    $(".staffTable-content").addClass("d-none");
    $(".sBtn").addClass("bg-light");
    $(".fBtn").removeClass("bg-light");
});

$(".staffTable").click(function (e) {
    e.preventDefault();
    $(".studentTable-content").addClass("d-none");
    $(".staffTable-content").removeClass("d-none");
    $(".sBtn").removeClass("bg-light");
    $(".fBtn").addClass("bg-light");
});

$(".cancelLogout").click(function (e) {
    e.preventDefault();
    $("#staffLogoutEntryKey").val('');
    $("#logoutEntryKey").val('');
});

// $("#StudFacLoginBtn").on("click", function() {
//     if ($('#studentLogin-content').is(':visible')) {
//         $('#fac_auth').addClass('d-none');
//     }
// });

$('.libraryLogout').on('hidden.bs.modal', function(){
    $('#pwd-logout').val('');
});

$('#loginModal,#logoutModal').on('hidden.bs.modal', function () {
    // Clear the form fields when the modal is closed
    $('#studentLoginForm')[0].reset();
    $('#studentName').val('');
    $('#studentListContainer').hide();
    $('#EntryExitKey').hide();
    $('#logoutEntryKey').val('');

    $("#pass_to_logout_fac").val('');
    $("#staffLoginForm")[0].reset();
    $(".staffListContainer").addClass("d-none");
    $(".staffEntryExitKey").addClass("d-none");
    $('.facAuth').addClass("d-none");
});

function autoLogout(){
    const now = new Date();
    const hour = now.getHours();
    const minute = now.getMinutes();

    if(hour >= 19){
        if(minute >= 0||(hour>19)){
            let studentTable = $('#studentTable').DataTable();
            let staffTable = $('#staffTable').DataTable();
            $.ajax({
                url : './php/auto_logout_students.php',
                method : 'POST',
                dataType : 'json',
                success: function(response){
                    if(response.success){
                        studentTable.clear().draw();
                    } else {
                        console.error(`Error logging out students`);
                    }
                },
                error: function () {
                    console.error(`Error processing logout for student`);
                }
            });
            
            $.ajax({
                url : './php/auto_logout_staffs.php',
                method : 'POST',
                dataType : 'json',
                success: function(response){
                    if(response.success){
                        staffTable.clear().draw();
                    } else {
                        console.error(`Error logging out staffs`);
                    }
                },
                error: function () {
                    console.error(`Error processing logout for staff`);
                }
            });
        }
    }
}

setInterval(autoLogout,10000);