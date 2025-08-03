<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $formNo = $_POST['formNo'] ?? '';
  $childName = $_POST['childName'] ?? '';
  $fatherName = $_POST['fatherName'] ?? '';
  $motherName = $_POST['motherName'] ?? '';
  $birthDate = $_POST['birthDate'] ?? '';
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

  $stmt = $conn->prepare("INSERT INTO birth_certificate_forms (
    form_no, child_name, father_name, mother_name, birth_date,
    house_no, road_no, road_name, village, word_no,
    union_name, thana, post_office, district, division,
    nationality, issue_date, issued_by, chairman_signature, parent_signature
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

  if ($stmt) {
    $stmt->bind_param(
      "ssssssssssssssssssss",
      $formNo, $childName, $fatherName, $motherName, $birthDate,
      $houseNo, $roadNo, $roadName, $village, $wordNo,
      $union, $thana, $postOffice, $district, $division,
      $nationality, $issueDate, $issuedBy, $chairmanSignature, $parentSignature
    );

    if ($stmt->execute()) {
      echo "<script>alert('Birth Certificate Application Submitted Successfully!'); window.location.href='index.php';</script>";
    } else {
      echo "Error submitting form: " . $stmt->error;
    }

    $stmt->close();
  } else {
    echo "Database error: " . $conn->error;
  }
}
?>
