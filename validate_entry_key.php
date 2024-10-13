<?php
include 'db_connection.php';

if (isset($_POST['year'], $_POST['branch'], $_POST['section'], $_POST['EntryKey'])) {
    $year = (int)$_POST['year'];
    $branch = $_POST['branch'];
    $section = $_POST['section'];
    $EntryKey = $_POST['EntryKey'];
    error_log("Branch: $branch, Section: $section, EntryKey: $EntryKey, Year: $year");
    $query = "SELECT * FROM users WHERE Branch = ? AND Section = ? AND EntryKey = ? AND RegYear = ?";
    // Prepare the statement
    $stmt = $conn->prepare($query);

    // Bind the parameters: sss -> strings for Branch, Section, EntryKey; i -> integer for RegYear
    $stmt->bind_param('sssi', $branch, $section, $EntryKey, $year);

    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();

        echo json_encode([
            'success' => true,
            'data' => $student
        ]);
    } else {
        echo json_encode([
            'success' => false
        ]);
    }
}
