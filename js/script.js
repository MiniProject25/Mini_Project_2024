$(document).ready(function() {
    $.ajax({
        url: 'fetch_branches.php',
        method: 'GET',
        success: function(response) {
            $('#branch').append(response);
        }
    });
});

$('#section, #year, #branch').on('change', function() {
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
            success: function(response) {
                $('#studentName').html(response);
                $('#studentListContainer').show();
            }
        });
    }else {
        $('#studentListContainer').hide(); // Hide if any field is empty
    }
});
