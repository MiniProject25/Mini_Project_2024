<?php
include 'php/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST["usn"]) || isset($_POST["regyear"]))) {
    $usn = $_POST["usn"];
    $regyear = $_POST["regyear"];

    if (!empty($usn)) {
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE usn = ?");
        $stmt->bind_param("s", $usn);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $num = $row['count'];

        if ($num == 1) {
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Edit the Student details</title>
            </head>

            <body>
                <form action="php/EditOne.php" method="post">
                    <input type="hidden" name="usn" value="<?php echo htmlspecialchars($usn); ?>">

                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required><br>

                    <label for="branch">Branch:</label>
                    <input type="text" id="branch" name="branch" class="form-control" required><br>

                    <label for="regyear">Registration Year:</label>
                    <input type="text" id="regyear" name="regyear" class="form-control" required><br>

                    <label for="section">Section:</label>
                    <input type="text" id="section" name="section" class="form-control" required><br>

                    <label for="cyear">Current year:</label>
                    <input type="text" id="cyear" name="cyear" class="form-control" required><br>

                    <input type="submit" value="Edit">
                </form>
            </body>

            </html>

            <?php
        } else {
            echo "USN does not exist!!!";
        }
    } else if (!empty($regyear)) {
        $num = 0;
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE regyear = ?");
        $stmt->bind_param("s", $regyear);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $num = $row['count'];

        if ($num == 0) {
            echo "Students with registration year {$regyear} doesnot exist!!!";
        } else {
            ?>
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Edit the Student details</title>
                </head>

                <body>
                    <form action="php/EditSet.php" method="post">
                        <input type="hidden" name="regyear" value="<?php echo htmlspecialchars($regyear); ?>">
                        <label for="cyear">Current year:</label>
                        <input type="text" id="cyear" name="cyear" class="form-control" required><br>

                        <input type="submit" value="Edit">
                    </form>
                </body>

                </html>
            <?php
        }
    } else {
        echo "Please fill the content!!!";
    }
}
?>