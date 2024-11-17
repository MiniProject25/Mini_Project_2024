<?php
include 'db_connection.php';

$data = array();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$dept = isset($_GET['dept']) ? $_GET['dept'] : '';
$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';

// SQL Query
$sql = "SELECT f.fname, f.emp_id, f.dept, h.TimeIn, h.TimeOut, DATE_FORMAT(h.Date, '%d-%m-%Y') as Date
        FROM faculty f 
        INNER JOIN faculty_history h ON f.emp_id = h.emp_id
        WHERE 1=1";

$params = [];
$types = '';

// Apply filters based on user input
if (!empty($search)) {
    $sql .= " AND (f.emp_id LIKE ? OR f.fname LIKE ? OR DATE_FORMAT(h.Date, '%d-%m-%Y') LIKE ?)";
    $searchParam = '%' . $search . '%';
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'sss';
}

if (!empty($dept)) {
    $sql .= " AND f.dept = ?";
    $params[] = $dept;
    $types .= 's';
}

if (!empty($fromDate)) {
    $sql .= " AND h.Date >= ?";
    $params[] = $fromDate;
    $types .= 's';
}

if (!empty($toDate)) {
    $sql .= " AND h.Date <= ?";
    $params[] = $toDate;
    $types .= 's';
}

$sql .= " ORDER BY h.Date DESC, h.TimeIn DESC";

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
