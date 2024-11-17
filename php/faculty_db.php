<?php
include 'db_connection.php';

$data = array();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$dept = isset($_GET['dept']) ? $_GET['dept'] : '';

// Base SQL query
$sql = "SELECT emp_id, fname, dept FROM faculty WHERE 1=1"; 

$params = [];
$types = '';

// Add conditions and parameters only if filters are provided
if (!empty($search)) {
    $sql .= " AND (emp_id LIKE ? OR fname LIKE ?)";
    $searchParam = '%' . $search . '%';
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'ss';
}

if (!empty($dept)) {
    $sql .= " AND dept = ?";
    $params[] = $dept;
    $types .= 's';
}

if (!empty($section)) {
    $sql .= " AND Section = ?";
    $params[] = $section;
    $types .= 's';
}

$sql .= " ORDER BY fname ASC";

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
