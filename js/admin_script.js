$(document).ready(function () {

    $.ajax({
        url: './php/fetch_branches.php',
        method: 'GET',
        success: function (response) {
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

// Reset radio buttons and hide fields when the modal is closed
$('#removeStudentModal').on('hidden.bs.modal', function () {
    resetFields('remove');
});

$('#editModal').on('hidden.bs.modal', function () {
    resetFields('edit');
});

// Reset function to uncheck all radio buttons and hide extra fields
function resetFields(formType) {
    if (formType === 'edit') {
        document.getElementById('editRegYearField').style.display = 'none';
        document.getElementById('editUsnField').style.display = 'none';
    } else {
        document.getElementById('regYearField').style.display = 'none';
        document.getElementById('usnField').style.display = 'none';
    }

    // Uncheck radio buttons
    var radioButtons = document.querySelectorAll('input[name="choice"]');
    radioButtons.forEach(function (radio) {
        radio.checked = false;
    });
}


// function handleContinue() {
//     console.log("Continue button clicked!");
//     const option1 = document.querySelector('input[name="choice"][value="option1"]');
//     const option2 = document.querySelector('input[name="choice"][value="option2"]');

//     if (option1.checked) {
//         const regyearInput = document.querySelector('input[name="regyear"]').value;

//         if (!regyearInput) {
//             alert("Please enter the Registration Year.");
//             return;
//         }

//         $.ajax({
//             url: 'php/checkRegYear.php',
//             method: 'POST',
//             data: { regyear: regyearInput },
//             success: function(response) {
//                 if (response.exists) {
//                     $('#editModal').modal('hide'); // Close edit modal
//                     $('#editSetModal').modal('show'); // Show edit set modal
//                 } else {
//                     alert("The Registration Year does not exist in the database.");
//                 }
//             },
//             error: function() {
//                 alert("An error occurred while checking the Registration Year.");
//             }
//         });

//     } else if (option2.checked) {
//         const usnInput = document.querySelector('input[name="usn"]').value;

//         if (!usnInput) {
//             alert("Please enter the USN.");
//             return;
//         }

//         $.ajax({
//             url: 'php/checkUSN.php',
//             method: 'POST',
//             data: { usn: usnInput },
//             success: function(response) {
//                 if (response.exists) {
//                     $('#editModal').modal('hide'); // Close edit modal
//                     $('#editOneModal').modal('show'); // Show edit one modal
//                 } else {
//                     alert("The USN does not exist in the database.");
//                 }
//             },
//             error: function() {
//                 alert("An error occurred while checking the USN.");
//             }
//         });
//     }
// }

