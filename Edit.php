<?php
// Check if the form is submitted and a choice is made
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['choice'])) {
    // Get the selected option
    $choice = $_POST['choice'];

    // If Option 1 (Edit a set of student) is selected
    if ($choice == 'option1') {
        // Display the form to enter the registration year to remove a set of student
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Student</title>
        </head>
        <body>
            <h2>Update Year</h2>
            <form action="EditSet.php" method="post">
                <label for="regyear">Registration Year:</label>
                <input type="text" id="regyear" name="regyear" required><br><br>
                <input type="submit" value="Update">
            </form>
        </body>
        </html>
        <?php
    } elseif ($choice == 'option2') {
       // Display the form to enter the USN to remove a student
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Student</title>
        </head>
        <body>
            <h2>Edit a Student</h2>
            <form action="EditOne.php" method="post">
                <label for="usn">USN:</label>
                <input type="text" id="usn" name="usn" required><br><br>
                <input type="submit"" value="Edit">
            </form>
        </body>
        </html>
        <?php
    }
}
?>

