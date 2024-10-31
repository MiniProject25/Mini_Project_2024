<?php
include 'db_connection.php';

$data = array();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';
$branch = isset($_GET['branch']) ? $_GET['branch'] : '';
$section = isset($_GET['section']) ? $_GET['section'] : '';

// Base SQL query
$sql = "SELECT USN, Sname, Branch, RegYear, Section, Cyear FROM users WHERE 1=1"; 

$params = [];
$types = '';

// Add conditions and parameters only if filters are provided
if (!empty($search)) {
    $sql .= " AND (USN LIKE ? OR Sname LIKE ?)";
    $searchParam = '%' . $search . '%';
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'ss';
}

if (!empty($year)) {
    $sql .= " AND Cyear = ?";
    $params[] = $year;
    $types .= 'i';
}

if (!empty($branch)) {
    $sql .= " AND Branch = ?";
    $params[] = $branch;
    $types .= 's';
}

if (!empty($section)) {
    $sql .= " AND Section = ?";
    $params[] = $section;
    $types .= 's';
}

// Prepare statement and bind parameters only if there are conditions to bind
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    echo json_encode(['success' => false, 'message' => 'Database query failed: ' . $conn->error]);
    exit();
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>
