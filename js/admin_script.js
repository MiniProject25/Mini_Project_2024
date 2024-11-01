$(document).ready(function () {
    // EMPTY GRAPH RENDERING
    Highcharts.chart('statistics-chart', {
        chart: { type: 'line' },
        title: { text: 'Total Library Visits by Date' },
        xAxis: { type: 'datetime', title: { text: 'Date' } },
        yAxis: { title: { text: 'Visits' }, allowDecimals: false }
    });
    Highcharts.chart('lib-usage-per-hour', {
        chart: { type: 'column' },
        title: { text: 'Library Access Per Hour' },
        xAxis: { title: { text: 'Time (Hour)' } },
        yAxis: { min: 0, title: { text: 'Number of Students' } }
    });

    // clearing stat form
    $('#reset_stat_form').on('click', function () {
        $('#statsInfo').find('input[type="date"]').val('');
        $('#statsInfo').find('select').prop('selectedIndex', 0);
        libUsagePerHour();
        libVisitCount();
    });

    // promotion of students
    $('#promote1st').on('click', function () {
        $.ajax({
            url: "php/promotion/promote1stYear.php",
            type: "GET",
            dataType: 'json',

            success: function (response) {
                alert(response.message);
            },
            error: function (response) {
                alert(response.message)
            }
        })
    });
    $('#promote2nd').on('click', function () {
        $.ajax({
            url: "php/promotion/promote2ndYear.php",
            type: "GET",
            dataType: 'json',

            success: function (response) {
                alert(response.message);
            },
            error: function (response) {
                alert(response.message)
            }
        })
    });
    $('#promote3rd').on('click', function () {
        $.ajax({
            url: "php/promotion/promote3rdYear.php",
            type: "GET",
            dataType: 'json',

            success: function (response) {
                alert(response.message);
            },
            error: function (response) {
                alert(response.message)
            }
        })
    });

    // editing student details
    $('#continueEditBtn').on('click', function () {
        // handleContinue();
        $('#editModal').modal('hide');
        const option = $('input[name="choice"]:checked').val();
        if (option == "updateStudent") {
            $('#updateModal').modal('show');
        }
        else if (option == "editStudent") {
            $('#editOneModal').modal('show');
        }
    });

    // editing student information
    let usnInput; // stores the usn of the student whose details are being edited.
    $('#processUSN').on('click', function (e) {
        e.preventDefault();
        if (!$('.edit_usn').val()) {
            alert("Please enter USN before proceeding");
            return;
        }

        usnInput = $('.edit_usn').val();
        console.log(usnInput);

        $.ajax({
            url: 'php/checkUSN.php',
            method: 'POST',
            dataType: 'json',
            data: { usn: usnInput },
            success: function (response) {
                if (response.success) {
                    $('.editUsnField').addClass('d-none');
                    $('.modal-footer').removeClass('d-none');
                    $('.edit-one-modal').removeClass('d-none');
                } else {
                    console.log(response.message);
                    alert("The USN does not exist in the database.");
                }
            },
            error: function () {
                alert("An error occurred while checking the USN.");
            }
        });
    });

    // processing edited information
    $('#submit_edit_btn').on('click', function () {
        let usn = usnInput;
        let sname = $('#name_edit').val();
        let branch = $('#branch_edit').val();
        let section = $('#section_edit').val();
        let regyear = $('#regyear_edit').val();
        let cyear = $('#cyear_edit').val();

        $.ajax({
            url: 'php/EditOne.php',
            method: 'POST',
            data: {
                usn: usn,
                name: sname,
                branch: branch,
                section: section,
                regyear: regyear,
                cyear: cyear
            }
        });
    });

    // fetching branches from the DB
    $.ajax({
        url: './php/fetch_branches.php',
        method: 'GET',
        success: function (response) {
            $('#branch').append(response);
            $('#branch_edit').append(response);
            $('#branch_add').append(response);
            $('#branch_stat').append(response);
            $('#branch_removal').append(response);
        }
    });

    // radio selection when removing students
    $('input[name="removechoice"]').on('change', function () {
        if ($('#remove_one').is(':checked')) {
            $('#usnField').removeClass('d-none');
        } else if ($('#remove_4th').is(':checked')) {
            $('#usnField').addClass('d-none');
        }
    });

    // radio selection when adding / removing branch
    $('input[name="branch_choice"]').on('change', function () {
        if ($('#add_branch').is(':checked')) {
            $('.enter-branch-field').removeClass('d-none');
            $('.select-branch-to-delete').addClass('d-none');
        } else if ($('#remove_branch').is(':checked')) {
            $('.select-branch-to-delete').removeClass('d-none');
            $('.enter-branch-field').addClass('d-none');
        }
    });

    // Closing the branch add/remove modal
    $('#closeBranchBtn').on('click', function(){
        $('#addRemBranchForm')[0].reset();
        $('.select-branch-to-delete').addClass('d-none');
        $('.enter-branch-field').addClass('d-none');
    });

    $('.stats').click(function (e) {
        e.preventDefault();
        $('#db-content').addClass('d-none');
        $('#statistics-content').removeClass('d-none');
    });

    $('.db').click(function (e) {
        e.preventDefault();
        $('#statistics-content').addClass('d-none');
        $('#db-content').removeClass('d-none');
    });

    // Fetch Graphs (statistics)
    $('.statInfo').on('input change', 'input[type="date"], select', function () {
        libUsagePerHour();
        libVisitCount();
    });

    // ******* STATISTIC ******* //
    // fetch library usage per hour
    function libUsagePerHour() {
        let dateFrom = $('#from_date').val();
        let dateTo = $('#to_date').val();
        let branch = $('#branch_stat').val();
        let cyear = $('#Cyear_edit').val();

        $.ajax({
            url: 'php/Stats/libUsagePerHour.php',
            type: 'POST',
            data: { date_from: dateFrom, date_to: dateTo, branch: branch, cyear: cyear },
            dataType: 'json',
            success: function (response) {
                let categories = [];
                let data = [];

                response.forEach(function (item) {
                    categories.push(item.hour + ":00");
                    data.push(parseInt(item.student_count));
                });

                // Render the Highcharts graph
                Highcharts.chart('lib-usage-per-hour', {
                    chart: { type: 'column' },
                    title: { text: 'Library Access Per Hour' },
                    xAxis: { categories: categories, title: { text: 'Time (Hour)' } },
                    yAxis: { min: 0, title: { text: 'Number of Students' } },
                    series: [{ name: 'Students', data: data }],
                    plotOptions: {
                        column: {
                            dataLabels: {
                                enabled: true,
                                format: '{y}'
                            }
                        }
                    }
                });
            }
        });
    }

    // total library visits BY date
    function libVisitCount() {
        let dateFrom = $('#from_date').val();
        let dateTo = $('#to_date').val();
        let branch = $('#branch_stat').val();
        let cyear = $('#Cyear_edit').val();

        $.ajax({
            url: 'php/Stats/libVisitCount.php',
            type: 'POST',
            data: { date_from: dateFrom, date_to: dateTo, branch: branch, cyear: cyear },
            dataType: 'json',
            success: function (data) {
                Highcharts.chart('statistics-chart', {
                    chart: { type: 'column' },
                    title: { text: 'Total Library Visits by Date' },
                    xAxis: { type: 'datetime', title: { text: 'Date' } },
                    yAxis: { min: 0, title: { text: 'Visits' }, allowDecimals: false },
                    series: [{
                        name: 'Visits',
                        data: data.map(item => [new Date(item.Date).getTime(), item.visit_count])
                    }],
                    plotOptions: {
                        column: {
                            dataLabels: {
                                enabled: true,
                                format: '{y}'
                            }
                        }
                    }
                });
            }
        });
    }

    // DB Table
    var table = $('#dbtable').DataTable({
        paging: false,           // Disable pagination
        searching: false,        // Disable default search box
        ordering: false,
        bLengthChange: false,    // Disable length change
        info: false              // Disable info text
    });

    function handleInputChange() {
        const searchTerm = $('#searchInput').val().trim(); // Get the current input value
        const year = $('#Cyear').val(); // Get selected year
        const branch = $('#branch').val(); // Get selected branch
        const section = $('#section').val(); // Get selected section

        fetchTableData(searchTerm, year, branch, section);
    }

    $('#searchInput').on('keyup', handleInputChange);
    $('#Cyear, #branch, #section').on('change', handleInputChange);

    fetchTableData(); 

    function fetchTableData(searchTerm = '', year = '', branch = '', section = '') {
        $.ajax({
            url: 'php/db_users.php',
            method: 'GET',
            data: {
                search: searchTerm,
                year: year,
                branch: branch,
                section: section
            },
            dataType: 'json',
            success: function (data) {
                table.clear();
    
                if (data && data.length > 0) {
                    data.forEach(function (student) {
                        table.row.add([
                            student.USN,
                            student.Sname,
                            student.Branch,
                            student.RegYear,
                            student.Section,
                            student.Cyear
                        ]).draw();
                    });
                } else {
                    table.row.add(['', 'No results found', '', '', '', '']).draw();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error fetching data: ' + textStatus, errorThrown);
            }
        });
    }    
});

function confirmation(event, formSelector, txt) {
    const isConfirmed = confirm("Are you sure you want to " + txt + "?");

    if (isConfirmed) {
        $(formSelector).submit();
    } else {
        event.preventDefault(); // Prevent form submission
    }
}

$('.closeRemoveModal').on('click', function () {
    $('#regYearField').addClass('d-none');
    $('#usnField').addClass('d-none');
    $('#remove_set, #remove_one').prop('checked', false);
});

$('.closeEditModal').on('click', function () {
    // $('#editRadio').prop('checked', false);
    $('#editStudentForm')[0].reset();
});

$('.closeAddStudentModal').on('click', function () {
    $('#addStudentForm')[0].reset();
});