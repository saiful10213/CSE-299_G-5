<?php
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$script_name = $_SERVER['SCRIPT_NAME'];
$base_path = str_replace(basename($script_name), '', $script_name);
$request_uri = '/' . ltrim(str_replace($base_path, '', $uri), '/');

function respond($status, $data) {
    http_response_code($status);
    echo json_encode($data);
    exit();
}

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'e_voting_db';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    respond(500, ['error' => 'Database connection failed']);
}

switch ($request_uri) {
    case '/api/register':
        if ($method !== 'POST') respond(405, ['error' => 'Method not allowed']);
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['mobile']) || !isset($data['password'])) {
            respond(400, ['error' => 'Invalid input']);
        }

        $stmt = $conn->prepare("SELECT id FROM users WHERE mobile = ?");
        $stmt->bind_param("s", $data['mobile']);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            respond(400, ['error' => 'Mobile number already registered']);
        }

        $stmt = $conn->prepare("INSERT INTO users (mobile, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $data['mobile'], $data['password']);
        if ($stmt->execute()) {
            respond(201, ['message' => 'User registered successfully']);
        } else {
            respond(500, ['error' => 'Registration failed']);
        }
        break;

    case '/api/login':
        if ($method !== 'POST') respond(405, ['error' => 'Method not allowed']);
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['mobile']) || !isset($data['password'])) {
            respond(400, ['error' => 'Invalid input']);
        }

        $stmt = $conn->prepare("SELECT id FROM users WHERE mobile = ? AND password = ?");
        $stmt->bind_param("ss", $data['mobile'], $data['password']);
        $stmt->execute();
        $stmt->bind_result($user_id);
        if ($stmt->fetch()) {
            respond(200, ['message' => 'Login successful', 'user_id' => $user_id]);
        } else {
            respond(401, ['error' => 'Invalid credentials']);
        }
        break;

    case '/api/birth/apply':
        if ($method !== 'POST') {
            respond(405, ['error' => 'Method not allowed']);
        }
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
        break;

    default:
        respond(404, ['error' => 'Endpoint not found: ' . $request_uri]);
}
?>
