<?php
// Check if the form is submitted and a choice is made
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['choice'])) {
    // Get the selected option
    $choice = $_POST['choice'];

    // If Option 1 (Remove a set of studenta) is selected
    if ($choice == 'option1') {
        // Display the form to enter the registration year to remove a set of student
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Remove Student</title>
        </head>
        <body>
            <h2>Remove a set of Student</h2>
            <form action="RemoveSet.php" method="post">
                <label for="regyear">Registration Year:</label>
                <input type="text" id="regyear" name="regyear" required><br><br>
                <input type="submit" value="Remove">
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
            <title>Remove Student</title>
        </head>
        <body>
            <h2>Remove a Student</h2>
            <form action="RemoveOne.php" method="post">
                <label for="usn">USN:</label>
                <input type="text" id="usn" name="usn" required><br><br>
                <input type="submit"" value="Remove">
            </form>
        </body>
        </html>
        <?php
    }
}
?>

