<?php
include 'db_connection.php';

$data = array();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';
$branch = isset($_GET['branch']) ? $_GET['branch'] : '';
$section = isset($_GET['section']) ? $_GET['section'] : '';
$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';
$purpose = isset($_GET['purpose']) ? $_GET['purpose'] : '';

// SQL Query
$sql = "SELECT u.USN, u.Sname, u.Branch, u.Section, u.Cyear, h.purpose, h.TimeIn, h.TimeOut, DATE_FORMAT(h.Date, '%d-%m-%Y') as Date
        FROM users u 
        INNER JOIN history h ON u.USN = h.USN 
        WHERE 1=1";

$params = [];
$types = '';

// Apply filters based on user input
if (!empty($search)) {
    $sql .= " AND (u.USN LIKE ? OR u.Sname LIKE ? OR DATE_FORMAT(h.Date, '%d-%m-%Y') LIKE ?)";
    $searchParam = '%' . $search . '%';
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'sss';
}

if (!empty($year)) {
    $sql .= " AND u.Cyear = ?";
    $params[] = $year;
    $types .= 'i';
}

if (!empty($branch)) {
    $sql .= " AND u.Branch = ?";
    $params[] = $branch;
    $types .= 's';
}

if (!empty($section)) {
    $sql .= " AND u.Section = ?";
    $params[] = $section;
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

if (!empty($purpose)) {
    $sql .= " AND h.purpose = ?";
    $params[] = $purpose;
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
