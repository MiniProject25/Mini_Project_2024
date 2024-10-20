$(document).ready(function () {
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

    $('input[name="removechoice"]').on('change', function() {
        if ($('#remove_set').is(':checked')) {
            $('#regYearField').removeClass('d-none');  
            $('#usnField').addClass('d-none'); 
        } else if($('#remove_one').is(':checked')) {
            $('#usnField').removeClass('d-none');  
            $('#regYearField').addClass('d-none');  
        }
    });
    
});

function toggleFields() {

}

