<?php
include 'db.php'; // Your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize POST data
    $formNo = $_POST['formNo'] ?? '';
    $childName = $_POST['childName'] ?? '';
    $fatherName = $_POST['fatherName'] ?? '';
    $motherName = $_POST['motherName'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $houseNo = $_POST['houseNo'] ?? '';
    $roadNo = $_POST['roadNo'] ?? '';
    $roadName = $_POST['roadName'] ?? '';
    $village = $_POST['village'] ?? '';
    $wordNo = $_POST['wordNo'] ?? '';
    $union = $_POST['union'] ?? '';
    $thana = $_POST['thana'] ?? '';
    $postOffice = $_POST['postOffice'] ?? '';
    $district = $_POST['district'] ?? '';
    $division = $_POST['division'] ?? '';
    $nationality = $_POST['nationality'] ?? '';
    $issueDate = $_POST['issueDate'] ?? '';
    $issuedBy = $_POST['issuedBy'] ?? '';
    $chairmanSignature = $_POST['chairmanSignature'] ?? '';
    $parentSignature = $_POST['parentSignature'] ?? '';

    // Validate required fields (simple example)
    if (empty($formNo) || empty($childName) || empty($fatherName) || empty($motherName) || empty($dob)) {
        die("Required fields are missing.");
    }

    // Optional: convert date to Y-m-d format if needed
    $dob = date('Y-m-d', strtotime($dob));
    $issueDate = !empty($issueDate) ? date('Y-m-d', strtotime($issueDate)) : null;

    // Prepare and bind to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO birth_certificate
        (form_no, child_name, father_name, mother_name, dob, house_no, road_no, road_name, village, word_no, `union`, thana, post_office, district, division, nationality, issue_date, issued_by, chairman_signature, parent_signature)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssssssssssss",
        $formNo, $childName, $fatherName, $motherName, $dob, $houseNo, $roadNo, $roadName, $village, $wordNo, $union, $thana, $postOffice, $district, $division, $nationality, $issueDate, $issuedBy, $chairmanSignature, $parentSignature);

    if ($stmt->execute()) {
        echo "<p>✅ Application submitted successfully!</p>";
        echo "<p><a href='index.php'>Back to Home</a></p>";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
