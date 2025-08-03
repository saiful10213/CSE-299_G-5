<?php
require 'db.php';

$submitMessage = "";
$errors = [];

// Function to auto-generate a unique form_no
function generateFormNo($conn) {
    $datePrefix = date("Ymd");
    $random = rand(1000, 9999);
    $form_no = "NID" . $datePrefix . $random;

    // Ensure uniqueness in DB
    $check = $conn->prepare("SELECT id FROM nid_applications WHERE form_no = ?");
    $check->bind_param("s", $form_no);
    $check->execute();
    $check->store_result();
    
    if ($check->num_rows > 0) {
        return generateFormNo($conn); // regenerate if exists
    }
    return $form_no;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $form_no = generateFormNo($conn);
    $full_name_en = $conn->real_escape_string(trim($_POST['full_name_en']));
    $father_name = $conn->real_escape_string(trim($_POST['father_name']));
    $mother_name = $conn->real_escape_string(trim($_POST['mother_name']));
    $dob = $conn->real_escape_string($_POST['dob']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $marital_status = $conn->real_escape_string($_POST['marital_status']);
    $nationality = $conn->real_escape_string(trim($_POST['nationality']));
    $present_address = $conn->real_escape_string(trim($_POST['present_address']));
    $permanent_address = $conn->real_escape_string(trim($_POST['permanent_address']));
    $mobile = $conn->real_escape_string(trim($_POST['mobile']));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($password) || $password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
    }

    $photo_path = "";
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['photo']['name']);
        $targetFilePath = $uploadDir . time() . '_' . $fileName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
            $photo_path = $targetFilePath;
        } else {
            $errors[] = "Failed to upload photo.";
        }
    } else {
        $errors[] = "Photo is required.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO nid_applications 
            (form_no, full_name_en, father_name, mother_name, dob, gender, blood_group, marital_status, nationality, present_address, permanent_address, mobile, password_hash, photo_path)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        if ($stmt) {
            $stmt->bind_param(
                "ssssssssssssss",
                $form_no, $full_name_en, $father_name, $mother_name, $dob, $gender,
                $blood_group, $marital_status, $nationality,
                $present_address, $permanent_address, $mobile, $password_hash, $photo_path
            );

            if ($stmt->execute()) {
                $submitMessage = "✅ Application submitted successfully. Your Form No: <strong>$form_no</strong>";
            } else {
                $errors[] = "❌ Database error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $errors[] = "❌ Prepare failed: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>NID Application Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f4f4f4;
      padding: 20px;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    form {
      max-width: 700px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 5px;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input, select, textarea {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border-radius: 4px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      background: #004080;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .success {
      color: green;
      text-align: center;
      font-weight: bold;
    }
    .error {
      color: red;
      text-align: center;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <h1>NID Application Form</h1>

  <?php
  if (!empty($submitMessage)) {
      echo '<p class="success">' . $submitMessage . '</p>';
  }
  if (!empty($errors)) {
      foreach ($errors as $err) {
          echo '<p class="error">' . htmlspecialchars($err) . '</p>';
      }
  }
  ?>

  <form method="POST" action="" enctype="multipart/form-data">
    <label>Full Name (English):</label>
    <input type="text" name="full_name_en" required />

    <label>Father's Name:</label>
    <input type="text" name="father_name" required />

    <label>Mother's Name:</label>
    <input type="text" name="mother_name" required />

    <label>Date of Birth:</label>
    <input type="date" name="dob" required />

    <label>Gender:</label>
    <select name="gender" required>
      <option value="">Select Gender</option>
      <option>Male</option>
      <option>Female</option>
      <option>Other</option>
    </select>

    <label>Blood Group:</label>
    <select name="blood_group">
      <option value="">Select Blood Group</option>
      <option>A+</option>
      <option>A-</option>
      <option>B+</option>
      <option>B-</option>
      <option>O+</option>
      <option>O-</option>
      <option>AB+</option>
      <option>AB-</option>
    </select>

    <label>Marital Status:</label>
    <select name="marital_status">
      <option value="">Select Status</option>
      <option>Single</option>
      <option>Married</option>
      <option>Divorced</option>
      <option>Widowed</option>
    </select>

    <label>Nationality:</label>
    <input type="text" name="nationality" value="Bangladeshi" required />

    <label>Present Address:</label>
    <textarea name="present_address" rows="2" required></textarea>

    <label>Permanent Address:</label>
    <textarea name="permanent_address" rows="2" required></textarea>

    <label>Mobile Number:</label>
    <input type="text" name="mobile" required />

    <label>Password:</label>
    <input type="password" name="password" required />

    <label>Confirm Password:</label>
    <input type="password" name="confirm_password" required />

    <label>Upload Photo:</label>
    <input type="file" name="photo" accept="image/*" required />

    <button type="submit">Submit Application</button>
  </form>
</body>
</html>
