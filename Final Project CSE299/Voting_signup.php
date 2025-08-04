<?php
session_start();
include 'db.php'; // Your DB connection file

// OTP generation endpoint
if (isset($_POST['action']) && $_POST['action'] === 'send_otp') {
    $_SESSION['generatedOTP'] = rand(1000, 9999);
    echo json_encode(['otp' => $_SESSION['generatedOTP']]);
    exit;
}

// OTP verification endpoint
if (isset($_POST['action']) && $_POST['action'] === 'verify_otp') {
    $enteredOtp = $_POST['otp'] ?? '';
    $valid = isset($_SESSION['generatedOTP']) && $enteredOtp == $_SESSION['generatedOTP'];
    echo json_encode(['valid' => $valid]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $mobile = trim($_POST['mobile'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $enteredOTP = $_POST['otp'] ?? '';

    $errors = [];

    // Check OTP
    if (!isset($_SESSION['generatedOTP']) || $enteredOTP != $_SESSION['generatedOTP']) {
        $errors[] = "Incorrect OTP.";
    }

    // Password confirmation check
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // Upload folder inside your project directory
    $uploadDir = __DIR__ . '/upload/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // NID Front file upload
    if (!isset($_FILES['nidFront']) || $_FILES['nidFront']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "NID Front Side file is required.";
    } else {
        $nidFrontName = uniqid() . "_" . basename($_FILES['nidFront']['name']);
        $nidFrontPath = $uploadDir . $nidFrontName;
        if (!move_uploaded_file($_FILES['nidFront']['tmp_name'], $nidFrontPath)) {
            $errors[] = "Failed to upload NID Front Side.";
        }
    }

    // NID Back file upload
    if (!isset($_FILES['nidBack']) || $_FILES['nidBack']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "NID Back Side file is required.";
    } else {
        $nidBackName = uniqid() . "_" . basename($_FILES['nidBack']['name']);
        $nidBackPath = $uploadDir . $nidBackName;
        if (!move_uploaded_file($_FILES['nidBack']['tmp_name'], $nidBackPath)) {
            $errors[] = "Failed to upload NID Back Side.";
        }
    }

    // Passport photo file upload
    if (!isset($_FILES['photoUpload']) || $_FILES['photoUpload']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Passport photo is required.";
    } else {
        $photoName = uniqid() . "_" . basename($_FILES['photoUpload']['name']);
        $photoPath = $uploadDir . $photoName;
        if (!move_uploaded_file($_FILES['photoUpload']['tmp_name'], $photoPath)) {
            $errors[] = "Failed to upload passport photo.";
        }
    }

    // Check if mobile number already registered
    $stmt = $conn->prepare("SELECT COUNT(*) FROM voters WHERE mobile = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $stmt->bind_result($mobileCount);
    $stmt->fetch();
    $stmt->close();

    if ($mobileCount > 0) {
        $errors[] = "Mobile number already registered.";
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO voters (mobile, password, nid_front, nid_back, passport_photo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $mobile, $hashedPassword, $nidFrontName, $nidBackName, $photoName);

        if ($stmt->execute()) {
            unset($_SESSION['generatedOTP']); // clear OTP after successful registration
            echo "<script>alert('Sign-up successful! Please log in.'); window.location.href='Voting_login.php';</script>";
            exit;
        } else {
            $errors[] = "Database error: Could not save data.";
        }
        $stmt->close();
    }

    if (!empty($errors)) {
        $errorMsg = implode("\\n", $errors);
        echo "<script>alert('Error:\\n$errorMsg');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Voter Sign-Up Portal</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #e3f2fd;
      padding: 40px 10px;
    }
    .container {
      background: #fff;
      max-width: 700px;
      margin: auto;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    h2 {
      text-align: center;
      color: #1976d2;
      margin-bottom: 30px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    label {
      font-weight: 600;
      display: block;
      margin-bottom: 8px;
      color: #333;
    }
    input[type="file"],
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 14px;
      border-radius: 10px;
      border: 1px solid #ccc;
      font-size: 1rem;
      background: #f9f9f9;
      transition: border-color 0.3s ease;
    }
    input:focus {
      border-color: #1976d2;
      outline: none;
    }
    button {
      width: 100%;
      padding: 14px;
      margin-top: 10px;
      border-radius: 10px;
      border: none;
      background-color: #1976d2;
      color: white;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background-color: #125ca1;
    }
    .button-group {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-top: 5px;
    }
    .error {
      color: red;
      font-size: 0.9em;
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Voter Sign-Up Portal</h2>
    <form method="POST" enctype="multipart/form-data" id="signupForm">
      <div class="form-group">
        <label>Upload NID Front Side (with EC logo & signature)</label>
        <input type="file" name="nidFront" accept="image/*" required />
      </div>
      <div class="form-group">
        <label>Upload NID Back Side</label>
        <input type="file" name="nidBack" accept="image/*" required />
      </div>
      <div class="form-group">
        <label>Upload Passport Size Photo</label>
        <input type="file" name="photoUpload" accept="image/*" required />
      </div>
      <div class="form-group">
        <label>Mobile Number</label>
        <input type="text" name="mobile" required />
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required />
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirmPassword" required />
      </div>
      <div class="form-group">
        <label>Enter OTP</label>
        <input type="text" name="otp" required />
        <div class="button-group">
          <button type="button" id="sendOTPBtn">Send OTP</button>
          <button type="button" id="verifyOTPBtn">Verify OTP</button>
        </div>
        <div id="otpStatus" class="error"></div>
      </div>
      <button type="submit" name="submit">Sign Up</button>
    </form>
  </div>

  <script>
    const sendOTPBtn = document.getElementById('sendOTPBtn');
    const verifyOTPBtn = document.getElementById('verifyOTPBtn');
    const otpStatus = document.getElementById('otpStatus');

    sendOTPBtn.addEventListener('click', () => {
      fetch('', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=send_otp'
      })
      .then(res => res.json())
      .then(data => {
        alert('Your OTP is: ' + data.otp);
        otpStatus.textContent = '';
      })
      .catch(() => {
        otpStatus.textContent = 'Failed to send OTP.';
      });
    });

    verifyOTPBtn.addEventListener('click', () => {
      const enteredOTP = document.querySelector('input[name="otp"]').value;
      fetch('', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=verify_otp&otp=' + encodeURIComponent(enteredOTP)
      })
      .then(res => res.json())
      .then(data => {
        if (data.valid) {
          otpStatus.style.color = 'green';
          otpStatus.textContent = 'OTP verified successfully.';
        } else {
          otpStatus.style.color = 'red';
          otpStatus.textContent = 'Incorrect OTP.';
        }
      })
      .catch(() => {
        otpStatus.style.color = 'red';
        otpStatus.textContent = 'OTP verification failed.';
      });
    });
  </script>
</body>
</html>
