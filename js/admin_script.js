$(document).ready(function () {
  // rendering default graph
  libUsagePerHour();
  libVisitCount();
  avgVisitDuration();

  // resetting statistic
  $("#reset_stat_form").on("click", function () {
    $("#statsInfo").find('input[type="date"]').val("");
    $("#statsInfo").find("select").prop("selectedIndex", 0);
    libUsagePerHour();
    libVisitCount();
    avgVisitDuration();
  });

  // promotion of students
  $("#promote1st").on("click", function () {
    $.ajax({
      url: "php/promotion/promote1stYear.php",
      type: "GET",
      dataType: "json",

      success: function (response) {
        alert(response.message);
      },
      error: function (response) {
        alert(response.message);
      },
    });
  });
  $("#promote2nd").on("click", function () {
    $.ajax({
      url: "php/promotion/promote2ndYear.php",
      type: "GET",
      dataType: "json",

      success: function (response) {
        alert(response.message);
      },
      error: function (response) {
        alert(response.message);
      },
    });
  });
  $("#promote3rd").on("click", function () {
    $.ajax({
      url: "php/promotion/promote3rdYear.php",
      type: "GET",
      dataType: "json",

      success: function (response) {
        alert(response.message);
      },
      error: function (response) {
        alert(response.message);
      },
    });
  });

  // editing student details
  $("#continueEditBtn").on("click", function () {
    // handleContinue();
    $("#editModal").modal("hide");
    const option = $('input[name="choice"]:checked').val();
    if (option == "updateStudent") {
      $("#updateModal").modal("show");
    } else if (option == "editStudent") {
      $("#editOneModal").modal("show");
    }
  });

  // editing student information
  let usnInput; // stores the usn of the student whose details are being edited.
  $("#processUSN").on("click", function (e) {
    e.preventDefault();
    if (!$(".edit_usn").val()) {
      alert("Please enter USN before proceeding");
      return;
    }

    usnInput = $(".edit_usn").val();

    $.ajax({
      url: "php/checkUSN.php",
      method: "POST",
      dataType: "json",
      data: { usn: usnInput },
      success: function (response) {
        if (response.success) {
          // Fetch and populate existing student details
          $.ajax({
            url: "php/getStudentDetails.php",
            method: "POST",
            dataType: "json",
            data: { usn: usnInput },
            success: function (dataResponse) {
              if (dataResponse.success) {
                // Populate form fields with existing student details
                $("#name_edit").val(dataResponse.data.sname);
                $("#branch_edit").val(dataResponse.data.branch);
                $("#regyear_edit").val(dataResponse.data.regyear);
                $("#section_edit").val(dataResponse.data.section);
                $("#cyear_edit").val(dataResponse.data.cyear);

                // Show the form fields and footer
                $(".editUsnField").addClass("d-none");
                $(".modal-footer").removeClass("d-none");
                $(".edit-one-modal").removeClass("d-none");
              } else {
                alert(
                  "Error fetching student details: " + dataResponse.message
                );
              }
            },
            error: function () {
              alert("An error occurred while fetching student details.");
            },
          });
        } else {
          alert("The USN does not exist in the database.");
        }
      },
      error: function () {
        alert("An error occurred while checking the USN.");
      },
    });
  });

  // processing edited information
  $("#submit_edit_btn").on("click", function () {
    let usn = usnInput;
    let sname = $("#name_edit").val();
    let branch = $("#branch_edit").val();
    let section = $("#section_edit").val();
    let regyear = $("#regyear_edit").val();
    let cyear = $("#cyear_edit").val();

    $.ajax({
      url: "php/EditOne.php",
      method: "POST",
      data: {
        usn: usn,
        name: sname,
        branch: branch,
        section: section,
        regyear: regyear,
        cyear: cyear,
      },
    });
  });

  // fetching branches from the DB
  $.ajax({
    url: "./php/fetch_branches.php",
    method: "GET",
    success: function (response) {
      $("#branch").append(response);
      $("#branch_edit").append(response);
      $("#branch_add").append(response);
      $("#branch_stat").append(response);
      $("#branch_removal").append(response);
      $("#history_branch").append(response);
    },
  });

  // radio selection when removing students
  $('input[name="removechoice"]').on("change", function () {
    if ($("#remove_one").is(":checked")) {
      $("#usnField").removeClass("d-none");
    } else if ($("#remove_4th").is(":checked")) {
      $("#usnField").addClass("d-none");
    }
  });

  // radio selection when adding / removing branch
  $('input[name="branch_choice"]').on("change", function () {
    if ($("#add_branch").is(":checked")) {
      $(".enter-branch-field").removeClass("d-none");
      $(".select-branch-to-delete").addClass("d-none");
    } else if ($("#remove_branch").is(":checked")) {
      $(".select-branch-to-delete").removeClass("d-none");
      $(".enter-branch-field").addClass("d-none");
    }
  });

  // Closing the branch add/remove modal
  $("#closeBranchBtn").on("click", function () {
    $("#addRemBranchForm")[0].reset();
    $(".select-branch-to-delete").addClass("d-none");
    $(".enter-branch-field").addClass("d-none");
  });

  $(".stats").click(function (e) {
    e.preventDefault();
    $("#db-content").addClass("d-none");
    $("#statistics-content").removeClass("d-none");
    $("#history-content").addClass("d-none");
  });

    $('.db').click(function (e) {
        e.preventDefault();
        $('#statistics-content').addClass('d-none');
        $('#db-content').removeClass('d-none');
        $('#history-content').addClass('d-none');
    });

    $('.stud_stat').click(function (e) {
        e.preventDefault();
        $('#statistics-content').addClass('d-none');
        $('#db-content').removeClass('d-none');
        $('#history-content').addClass('d-none');
    });

  $(".history").click(function (e) {
    e.preventDefault();
    $("#statistics-content").addClass("d-none");
    $("#db-content").addClass("d-none");
    $("#history-content").removeClass("d-none");
  });

  // ******************************** //
  // ******* STATISTIC ******* //
  // ******************************** //

  // Fetch Graphs (statistics)
  $(".statInfo").on("input change", 'input[type="date"], select', function () {
    libUsagePerHour();
    libVisitCount();
    avgVisitDuration();
  });

  // fetch library usage per hour
  function libUsagePerHour() {
    let dateFrom = $("#from_date").val();
    let dateTo = $("#to_date").val();
    let branch = $("#branch_stat").val();
    let cyear = $("#Cyear_edit").val();

    $.ajax({
      url: "php/Stats/libUsagePerHour.php",
      type: "POST",
      data: {
        date_from: dateFrom,
        date_to: dateTo,
        branch: branch,
        cyear: cyear,
      },
      dataType: "json",
      success: function (response) {
        let categories = [];
        let data = [];

        response.forEach(function (item) {
          categories.push(item.hour + ":00");
          data.push(parseInt(item.student_count));
        });

        // Render the Highcharts graph
        Highcharts.chart("lib-usage-per-hour", {
          chart: { type: "column" },
          title: { text: "Library Access Per Hour" },
          xAxis: { categories: categories, title: { text: "Time (Hour)" } },
          yAxis: { min: 0, title: { text: "Number of Students" } },
          series: [{ name: "Students", data: data }],
          plotOptions: {
            column: {
              dataLabels: {
                enabled: true,
                format: "{y}",
              },
            },
          },
        });
      },
    });
  }

  // total library visits BY date
  function libVisitCount() {
    let dateFrom = $("#from_date").val();
    let dateTo = $("#to_date").val();
    let branch = $("#branch_stat").val();
    let cyear = $("#Cyear_edit").val();

    $.ajax({
      url: "php/Stats/libVisitCount.php",
      type: "POST",
      data: {
        date_from: dateFrom,
        date_to: dateTo,
        branch: branch,
        cyear: cyear,
      },
      dataType: "json",
      success: function (data) {
        Highcharts.chart("lib-visit-count", {
          chart: { type: "column" },
          title: { text: "Total Library Visits by Date" },
          xAxis: { type: "datetime", title: { text: "Date" } },
          yAxis: { min: 0, title: { text: "Visits" }, allowDecimals: false },
          series: [
            {
              name: "Visits",
              data: data.map((item) => [
                new Date(item.Date).getTime(),
                item.visit_count,
              ]),
            },
          ],
          plotOptions: {
            column: {
              dataLabels: {
                enabled: true,
                format: "{y}",
              },
            },
          },
        });
      },
    });
  }

  // average visit duration
  function avgVisitDuration() {
    let dateFrom = $("#from_date").val();
    let dateTo = $("#to_date").val();
    let branch = $("#branch_stat").val();
    let cyear = $("#Cyear_edit").val();

    $.ajax({
      url: "php/Stats/avg_visit_duration.php",
      type: "POST",
      data: {
        date_from: dateFrom,
        date_to: dateTo,
        branch: branch,
        cyear: cyear,
      },
      dataType: "json",
      success: function (data) {
        Highcharts.chart("avg-visit-duration", {
          chart: { type: "column" },
          title: { text: "Average Visit Duration" },
          xAxis: { type: "datetime", title: { text: "Date" } },
          yAxis: { title: { text: "Average Duration (Minutes)" } },
          series: [
            {
              name: "Avg Duration",
              data: data.map((item) => [
                new Date(item.Date).getTime(),
                parseFloat(item.avg_duration),
              ]),
            },
          ],
          plotOptions: {
            column: {
              dataLabels: {
                enabled: true,
                format: "{y}",
              },
            },
          },
        });
      },
    });
  }

  // ******************************** //
  // ******* END OF STATISTIC ******* //
  // ******************************** //

  // DB Table
  // $('#db-content').removeClass('d-none');
  var table = $("#dbtable").DataTable({
    paging: false, // Disable pagination
    searching: false, // Disable default search box
    ordering: false,
    bLengthChange: false, // Disable length change
    info: false, // Disable info text
    autoWidth: false,
    scrollX: false, // Enable horizontal scroll
    columnDefs: [
      { width: "10%", targets: 0 }, // USN
      { width: "30%", targets: 1 }, // Student Name
      { width: "40%", targets: 2 }, // Branch
      { width: "7.5%", targets: 3 }, // Year of Registration
      { width: "2.5%", targets: 4 }, // Section
      { width: "10%", targets: 5 }, // Year of Study
    ],
  });
  // table.columns.adjust().draw();
  // table.draw(); // force redraw

  // Event listener for the reset button
  $("#db_resetbtn").on("click", function (e) {
    e.preventDefault();

    // Reset form fields
    $("#dbForm").find("select").prop("selectedIndex", 0);
    $("#searchInput").val("");

    // Fetch all data without filters
    fetchTableData();
  });

  // Function to handle input changes and fetch filtered data
  function handleInputChange() {
    const searchTerm = $("#searchInput").val().trim();
    const year = $("#Cyear").val();
    const branch = $("#branch").val();
    const section = $("#db_section").val();

    // Fetch data based on filter values
    fetchTableData(searchTerm, year, branch, section);
  }

  // Set up event listeners for filter inputs
  $("#searchInput").on("keyup", handleInputChange);
  $("#Cyear, #branch, #db_section").on("change", handleInputChange);

  // Initial fetch to load all data on page load
  fetchTableData();

  // AJAX function to fetch data and update the DataTable
  function fetchTableData(
    searchTerm = "",
    year = "",
    branch = "",
    section = ""
  ) {
    $.ajax({
      url: "php/db_users.php",
      method: "GET",
      data: {
        search: searchTerm,
        year: year,
        branch: branch,
        section: section,
      },
      dataType: "json",
      success: function (data) {
        table.clear(); // Clear existing table data

        if (data && data.length > 0) {
          data.forEach(function (student) {
            table.row.add([
              student.USN,
              student.Sname,
              student.Branch,
              student.RegYear,
              student.Section,
              student.Cyear,
            ]);
          });
        } else {
          table.row.add(["", "No results found", "", "", "", ""]);
        }

        table.draw(); // Refresh the table display
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error fetching data: " + textStatus, errorThrown);
      },
    });
  }

  // History Table
  var hTable = $("#historyTable").DataTable({
    paging: false, // Disable pagination
    searching: false, // Disable default search box
    ordering: false,
    bLengthChange: false, // Disable length change
    info: false, // Disable info text
    autoWidth: false,
    scrollX: false, // Enable horizontal scroll if needed
    columnDefs: [
      { width: "10%", targets: 0 }, // USN
      { width: "15%", targets: 1 }, // Student Name
      { width: "30%", targets: 2 }, // Branch
      { width: "5%", targets: 3 }, // Section
      { width: "10%", targets: 4 }, // Year of Study
      { width: "7.5%", targets: 5 }, // Time-in
      { width: "7.5%", targets: 6 }, // Time-out
      { width: "10%", targets: 7 }, // Date
    ],
  });

  // Event listener for the reset button
  $("#history_resetbtn").on("click", function (e) {
    e.preventDefault();

    // Reset form fields
    $("#historyForm").find('input[type="date"]').val("");
    $("#historyForm").find("select").prop("selectedIndex", 0);
    $("#history_searchInput").val("");

    // Fetch all data without filters
    fetchHistoryTable();
  });

  $("#history_refreshbtn").on("click", function (e) {
    e.preventDefault();

    handlehInputChange();
  });

  function handlehInputChange() {
    const hsearchTerm = $("#history_searchInput").val().trim();
    const hyear = $("#history_Cyear").val();
    const hbranch = $("#history_branch").val();
    const hsection = $("#history_section").val();
    const hfromDate = $("#history_fromDate").val();
    const htoDate = $("#history_toDate").val();

    // Call your fetch data function with the current values
    fetchHistoryTable(
      hsearchTerm,
      hyear,
      hbranch,
      hsection,
      hfromDate,
      htoDate
    );
  }

  $("#history_searchInput").on("keyup", handlehInputChange);
  $(
    "#history_section, #history_branch, #history_Cyear, #history_fromDate, #history_toDate"
  ).on("change", handlehInputChange);

  fetchHistoryTable();

  function fetchHistoryTable(
    hsearchTerm = "",
    hyear = "",
    hbranch = "",
    hsection = "",
    hfromDate = "",
    htoDate = ""
  ) {
    $.ajax({
      url: "php/history_table.php",
      method: "GET",
      data: {
        search: hsearchTerm,
        year: hyear,
        branch: hbranch,
        section: hsection,
        fromDate: hfromDate,
        toDate: htoDate,
      },
      dataType: "json",
      success: function (data) {
        hTable.clear();

        if (data && data.length > 0) {
          data.forEach(function (student) {
            hTable.row
              .add([
                student.USN,
                student.Sname,
                student.Branch,
                student.Section,
                student.Cyear,
                student.TimeIn,
                student.TimeOut,
                student.Date, // Keep only the existing 7 items
              ])
              .draw();
          });
        } else {
          hTable.row.add(["", "No results found", "", "", "", "", ""]).draw();
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error fetching data: " + textStatus, errorThrown);
      },
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

$(".closeRemoveModal").on("click", function () {
  $("#regYearField").addClass("d-none");
  $("#usnField").addClass("d-none");
  $("#remove_set, #remove_one").prop("checked", false);
});

$(".closeEditModal").on("click", function () {
  // $('#editRadio').prop('checked', false);
  $("#editStudentForm")[0].reset();
});

$(".closeAddStudentModal").on("click", function () {
  $("#addStudentForm")[0].reset();
});

// Printing Statistics
$("#print_stats").on("click", function () {
  var prtContent = document.getElementById("Overall_stats");
  var WinPrint = window.open(
    "",
    "",
    "left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0"
  );
  WinPrint.document.write(prtContent.innerHTML);
  WinPrint.document.close();
  WinPrint.focus();
  WinPrint.print();
  WinPrint.close();
});

$("#print_history").on("click", function () {
    var prtContent = document.getElementById("hist_table");
    var WinPrint = window.open(
      "",
      "",
      "left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0"
    );
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();
  });
  