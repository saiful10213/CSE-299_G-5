<?php
header('Content-Type: application/json');

// Allow CORS for frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD'];
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Helper function to send JSON response
function respond($status, $data) {
    http_response_code($status);
    echo json_encode($data);
    exit();
}

// Handle preflight CORS requests
if ($method === 'OPTIONS') {
    respond(200, ['message' => 'CORS preflight OK']);
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'e_voting_db');
if ($conn->connect_error) {
    respond(500, ['error' => 'Database connection failed']);
}

// Routing
if ($path === 'api/birth/apply' && $method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        respond(400, ['error' => 'Invalid JSON']);
    }

    $stmt = $conn->prepare("INSERT INTO birth_certificate (
        user_id, form_no, child_name, father_name, mother_name,
        dob, village_name, union_name, thana, post_office,
        district, division, nationality, issue_date,
        issued_by, chairman_signature, parent_signature
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("isssssssssssssssss",
        $data['user_id'],
        $data['form_no'],
        $data['child_name'],
        $data['father_name'],
        $data['mother_name'],
        $data['dob'],
        $data['village_name'],
        $data['union_name'],
        $data['thana'],
        $data['post_office'],
        $data['district'],
        $data['division'],
        $data['nationality'],
        $data['issue_date'],
        $data['issued_by'],
        $data['chairman_signature'],
        $data['parent_signature']
    );

    if ($stmt->execute()) {
        respond(201, ['message' => 'Birth certificate application submitted successfully']);
    } else {
        respond(500, ['error' => 'Database insert failed']);
    }
} else {
    respond(404, ['error' => 'Endpoint not found']);
}
?>
