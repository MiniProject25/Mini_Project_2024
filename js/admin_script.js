$(document).ready(function () {
    // $('input[name="choice"]').change(function () {
    //     if ($(this).val() === 'setOfStudents') {
    //         $('#editRegYearField').show();
    //         $('#editUsnField').hide();
    //     } else if ($(this).val() === 'editStudent') {
    //         $('#editRegYearField').hide();
    //         $('#editUsnField').show();
    //     }
    // });

    $('#continueEditBtn').on('click', function () {
        // handleContinue();
        $('#editModal').modal('hide');
        const option = $('input[name="choice"]:checked').val();
        if (option == "setOfStudents") {
            $('#editSetModal').modal('show');
        }
        else if (option == "editStudent") {
            $('#editOneModal').modal('show');
        }
    });

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

    $('#submit_edit_btn').on('click', function() {
        let usn = usnInput;
        let sname = $('#name_edit').val();
        let branch = $('#branch_edit').val();
        let section = $('#section_edit').val();
        let regyear = $('#regyear_edit').val();
        let cyear = $('#cyear_edit').val();
    
        console.log("USN:", usn, "Name:", sname, "Branch:", branch, "Section:", section, "RegYear:", regyear, "Cyear:", cyear);
    
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
    

    $.ajax({
        url: './php/fetch_branches.php',
        method: 'GET',
        success: function (response) {
            $('#branch').append(response);
            $('#branch_edit').append(response);
        }
    });
});

// editing student details
function handleContinue() {
    // console.log("Continue button clicked!");
    // $('#editSetModal').modal('show');

    // const option = $('input[name="choice"]:checked').val();

    // if (option == "setOfStudents") {
    //     const regyearInput = $('#edit_regyear').val();

    //     if (!regyearInput) {
    //         alert("Please enter the Registration Year.");
    //         return;
    //     }

    //     $.ajax({
    //         url: 'php/checkRegYear.php',
    //         method: 'POST',
    //         dataType: 'json',
    //         data: { regyear: regyearInput },
    //         success: function (response) {
    //             if (response.success) {
    //                 $('#editModal').modal('hide'); // Close edit modal
    //                 $('#editSetModal').modal('show'); // Show edit set modal
    //             } else {
    //                 alert("Students with the entered Registration Year do not exist in the database.");
    //             }
    //         },
    //         error: function () {
    //             alert("An error occurred while checking the Registration Year.");
    //         }
    //     });

    // } else if (option == "editStudent") {
    //     const usnInput = $('#edit_usn').val();

    //     if (!usnInput) {
    //         alert("Please enter the USN.");
    //         return;
    //     }

    //     $.ajax({
    //         url: 'php/checkUSN.php',
    //         method: 'POST',
    //         data: { usn: usnInput },
    //         success: function (response) {
    //             if (response.success) {
    //                 $('#editModal').modal('hide'); // Close edit modal
    //                 $('#editOneModal').modal('show'); // Show edit one modal
    //             } else {
    //                 alert("The USN does not exist in the database.");
    //             }
    //         },
    //         error: function () {
    //             alert("An error occurred while checking the USN.");
    //         }
    //     });
    // }
}

