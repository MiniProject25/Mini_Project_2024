$(document).ready(function () {
    // fetching branch from DB for "Inserting a Student"
    $.ajax({
        url: './php/fetch_branches.php',
        method: 'GET',
        success: function(response) {
            $('#branch').append(response);
        }
    });
});

function toggleFields(modal) {
    var selectedValue = document.querySelector('input[name="choice"]:checked').value;

    // Update for the 'edit' modal
    if (modal === "edit") {
        var regYearField = document.getElementById("editRegYearField");
        var usnField = document.getElementById("editUsnField");
    } else {
        // Default for the 'remove' modal
        var regYearField = document.getElementById("regYearField");
        var usnField = document.getElementById("usnField");
    }

    if (selectedValue === "option1") {
        regYearField.style.display = "block";
        usnField.style.display = "none";
    } else if (selectedValue === "option2") {
        usnField.style.display = "block";
        regYearField.style.display = "none";
    }
}
