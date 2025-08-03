<?php
session_start();
require 'db.php'; // Your DB connection

// For debugging, enable errors:
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Login check
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        $nid = $_POST['nid'] ?? '';
        $dob = $_POST['dob'] ?? '';

        if (empty($nid) || empty($dob)) {
            echo json_encode(['status' => 'error', 'message' => 'NID and DOB are required.']);
            exit;
        }

        $stmt = $conn->prepare("SELECT full_name_en, father_name, mother_name, dob FROM nid_applications WHERE form_no = ? AND dob = ?");
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
            exit;
        }
        $stmt->bind_param("ss", $nid, $dob);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $_SESSION['correction_nid'] = $nid;
            echo json_encode(['status' => 'success', 'data' => $row]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'NID and DOB do not match our records.']);
        }
        $stmt->close();
        exit;
    }

    // Submit correction
    if (isset($_POST['action']) && $_POST['action'] === 'submit_correction') {
        if (!isset($_SESSION['correction_nid'])) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized submission. Please login first.']);
            exit;
        }

        $nid = $_SESSION['correction_nid'];
        $correctionType = $_POST['correctionType'] ?? '';
        $correctedValue = $_POST['correctedValue'] ?? '';
        $reason = $_POST['reason'] ?? '';

        if (empty($correctionType) || empty($correctedValue) || empty($reason)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO nid_corrections (nid_number, correction_type, corrected_value, reason) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
            exit;
        }
        $stmt->bind_param("ssss", $nid, $correctionType, $correctedValue, $reason);

        if ($stmt->execute()) {
            unset($_SESSION['correction_nid']);
            echo json_encode(['status' => 'success', 'message' => 'Correction submitted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'DB error: ' . $stmt->error]);
        }
        $stmt->close();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>NID Correction Application</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 10px; }
    label, input, select, textarea, button { display: block; width: 100%; margin-top: 10px; }
    button { background: #007bff; color: white; padding: 10px; border: none; cursor: pointer; }
    button:hover { background: #0056b3; }
    #correctionPage { display: none; }
    .message { margin-top: 10px; }
    .error { color: red; }
    .success { color: green; }
  </style>
</head>
<body>

<div id="loginPage">
  <h2>NID Correction Login</h2>
  <form id="loginForm">
    <label for="nid">NID Number:</label>
    <input type="text" id="nid" name="nid" placeholder="Enter NID Number" required />

    <label for="dob">Date of Birth:</label>
    <input type="date" id="dob" name="dob" required />

    <button type="submit">Proceed</button>
  </form>
  <p id="loginMessage" class="message"></p>
</div>

<div id="correctionPage">
  <h2>NID Correction Application</h2>
  <form id="correctionForm">
    <label>NID Number:</label>
    <input type="text" id="correctionNID" readonly />

    <label>Full Name:</label>
    <input type="text" id="fullName" readonly />

    <label>Father's Name:</label>
    <input type="text" id="fatherName" readonly />

    <label>Mother's Name:</label>
    <input type="text" id="motherName" readonly />

    <label>Date of Birth:</label>
    <input type="date" id="dobCorrection" readonly />

    <label for="correctionType">Correction Type:</label>
    <select id="correctionType" name="correctionType" required>
      <option value="">Select an option</option>
      <option value="full_name_en">Name</option>
      <option value="dob">Date of Birth</option>
      <option value="present_address">Address</option>
      <option value="father_name">Father's Name</option>
      <option value="mother_name">Mother's Name</option>
    </select>

    <label for="correctedValue">Corrected Value:</label>
    <textarea id="correctedValue" name="correctedValue" rows="3" required></textarea>

    <label for="reason">Reason for Correction:</label>
    <textarea id="reason" name="reason" rows="3" required></textarea>

    <button type="submit">Submit Correction</button>
  </form>
  <p id="correctionMessage" class="message"></p>
</div>

<script>
const loginForm = document.getElementById('loginForm');
const loginMessage = document.getElementById('loginMessage');
const loginPage = document.getElementById('loginPage');
const correctionPage = document.getElementById('correctionPage');

const correctionForm = document.getElementById('correctionForm');
const correctionMessage = document.getElementById('correctionMessage');

loginForm.addEventListener('submit', e => {
  e.preventDefault();
  loginMessage.textContent = '';
  loginMessage.className = 'message';

  const nid = document.getElementById('nid').value.trim();
  const dob = document.getElementById('dob').value;

  fetch('nid_correction.php', {  // <-- changed here
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=login&nid=${encodeURIComponent(nid)}&dob=${encodeURIComponent(dob)}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      loginPage.style.display = 'none';
      correctionPage.style.display = 'block';

      document.getElementById('correctionNID').value = nid;
      document.getElementById('fullName').value = data.data.full_name_en;
      document.getElementById('fatherName').value = data.data.father_name;
      document.getElementById('motherName').value = data.data.mother_name;
      document.getElementById('dobCorrection').value = data.data.dob;
    } else {
      loginMessage.textContent = data.message;
      loginMessage.className = 'message error';
    }
  })
  .catch(() => {
    loginMessage.textContent = 'Server error. Please try again later.';
    loginMessage.className = 'message error';
  });
});

correctionForm.addEventListener('submit', e => {
  e.preventDefault();
  correctionMessage.textContent = '';
  correctionMessage.className = 'message';

  const correctionType = document.getElementById('correctionType').value;
  const correctedValue = document.getElementById('correctedValue').value.trim();
  const reason = document.getElementById('reason').value.trim();

  if (!correctionType || !correctedValue || !reason) {
    correctionMessage.textContent = 'Please fill all required fields.';
    correctionMessage.className = 'message error';
    return;
  }

  fetch('nid_correction.php', {  // <-- changed here
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=submit_correction&correctionType=${encodeURIComponent(correctionType)}&correctedValue=${encodeURIComponent(correctedValue)}&reason=${encodeURIComponent(reason)}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      correctionMessage.textContent = data.message;
      correctionMessage.className = 'message success';
      correctionForm.reset();
      setTimeout(() => {
        correctionPage.style.display = 'none';
        loginPage.style.display = 'block';
        loginMessage.textContent = '';
      }, 3000);
    } else {
      correctionMessage.textContent = data.message;
      correctionMessage.className = 'message error';
    }
  })
  .catch(() => {
    correctionMessage.textContent = 'Server error. Please try again later.';
    correctionMessage.className = 'message error';
  });
});
</script>

</body>
</html>
