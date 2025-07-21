<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Get POST JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No input data received']);
    exit;
}

// Hardcoded valid credentials - replace with DB logic as needed
$validFormNo = "FORM-123456";
$validMobile = "01712345678";
$validPassword = "mypassword";

// Check if all required fields exist
if (isset($data['formNo']) && isset($data['mobile']) && isset($data['password'])) {
    $formNo = $data['formNo'];
    $mobile = $data['mobile'];
    $password = $data['password'];

    if ($formNo === $validFormNo && $mobile === $validMobile && $password === $validPassword) {
        // Provide PDF URL/path for download after successful login
        echo json_encode([
            'success' => true,
            'message' => 'Login successful',
            'pdf_url' => 'birth_certificate.pdf'  // Replace with your actual PDF file path or URL
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit;
?>
