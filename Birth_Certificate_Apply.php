<?php include 'db.php'; ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$showForm = false;
$formNo = '';
$successMessage = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mobile'])) {
  // Get form values
  $mobile = $_POST['mobile'] ?? '';
  $password = $_POST['password'] ?? '';
  $confirmPassword = $_POST['confirmPassword'] ?? '';
  $otp = $_POST['otp'] ?? '';
  $sessionOTP = $_POST['sessionOTP'] ?? '';

  if ($password !== $confirmPassword) {
    $error = "Passwords do not match.";
  } elseif ($otp !== $sessionOTP) {
    $error = "Incorrect OTP.";
  } else {
    // OTP and password OK
    $formNo = "FORM-" . rand(100000, 999999);

    // ✅ Optional: Hash password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // ✅ Insert into database
    $stmt = $conn->prepare("INSERT INTO birth_applications (mobile, password, otp, form_no) VALUES (?, ?, ?, ?)");
    if ($stmt) {
      $stmt->bind_param("ssss", $mobile, $hashedPassword, $otp, $formNo);
      if ($stmt->execute()) {
        $showForm = true; // Show next form
      } else {
        $error = "Database error: " . $stmt->error;
      }
      $stmt->close();
    } else {
      $error = "Statement preparation failed: " . $conn->error;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Birth Certificate Sign-Up</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 30px;
      min-height: 100vh;
    }
    .signup-container, .form-container {
      background: white;
      padding: 25px;
      border-radius: 10px;
      width: 350px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
      text-align: center;
    }
    label {
      display: block;
      margin-top: 12px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="password"],
    input[type="date"] {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      box-sizing: border-box;
    }
    button {
      margin-top: 15px;
      width: 100%;
      padding: 10px;
      background-color: #28a745;
      border: none;
      color: white;
      cursor: pointer;
    }
    button:hover {
      background-color: #218838;
    }
    #message, #formMessage {
      margin-top: 10px;
      text-align: center;
      color: red;
    }
  </style>
</head>

<body>

<?php if (!$showForm): ?>
  <!-- Sign-Up Page -->
  <div class="signup-container" id="signupPage">
    <h2>Apply for Birth Certificate</h2>
    <form id="signupForm" method="POST">
      <label>
        <input type="checkbox" id="applyCheckbox" required />
        I am applying for a Birth Certificate
      </label>

      <label for="mobile">Mobile Number:</label>
      <input type="text" id="mobile" name="mobile" placeholder="Enter valid 11-digit mobile" required />

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required />

      <label for="confirmPassword">Confirm Password:</label>
      <input type="password" id="confirmPassword" name="confirmPassword" required />

      <button type="button" onclick="sendOTP()">Send OTP</button>

      <div id="otpSection" style="display: none">
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" required />
        <input type="hidden" id="sessionOTP" name="sessionOTP" />
      </div>

      <button type="submit">Sign Up</button>
    </form>
    <p id="message"><?php echo isset($error) ? $error : ''; ?></p>
  </div>
<?php else: ?>
  <!-- Application Page -->
  <div class="form-container" id="applicationPage">
    <h2>Birth Certificate Application Form</h2>
    <form id="applicationForm" method="POST" action="submit_birth_certificate.php">
      <label>Certificate Form No:</label>
      <input type="text" id="formNo" name="formNo" value="<?php echo $formNo; ?>" readonly />

      <label>Name of Child:</label>
      <input type="text" name="childName" required />

      <label>Father's Name:</label>
      <input type="text" name="fatherName" required />

      <label>Mother's Name:</label>
      <input type="text" name="motherName" required />

      <label>Birth Date:</label>
      <input type="date" name="birthDate" required />

      <label>House No:</label>
      <input type="text" name="houseNo" />

      <label>Road No:</label>
      <input type="text" name="roadNo" />

      <label>Road Name:</label>
      <input type="text" name="roadName" />

      <label>Village Name:</label>
      <input type="text" name="village" required />

      <label>Word No:</label>
      <input type="text" name="wordNo" />

      <label>Union Name:</label>
      <input type="text" name="union" required />

      <label>Thana:</label>
      <input type="text" name="thana" required />

      <label>Post Office:</label>
      <input type="text" name="postOffice" required />

      <label>District:</label>
      <input type="text" name="district" required />

      <label>Division:</label>
      <input type="text" name="division" required />

      <label>Nationality:</label>
      <input type="text" name="nationality" required />

      <label>Issue Date:</label>
      <input type="date" name="issueDate" required />

      <label>Issued By:</label>
      <input type="text" name="issuedBy" required />

      <label>Chairman's Signature:</label>
      <input type="text" name="chairmanSignature" required />

      <label>Parent's Signature:</label>
      <input type="text" name="parentSignature" required />

      <button type="submit">Submit Application</button>
    </form>
  </div>
<?php endif; ?>

<script>
  let generatedOTP = "";

  function sendOTP() {
    const mobile = document.getElementById("mobile").value;
    if (!/^\d{11}$/.test(mobile)) {
      document.getElementById("message").innerText = "Enter a valid 11-digit mobile number.";
      return;
    }
    generatedOTP = Math.floor(100000 + Math.random() * 900000).toString();
    alert("OTP sent: " + generatedOTP);
    document.getElementById("otpSection").style.display = "block";
    document.getElementById("sessionOTP").value = generatedOTP;
    document.getElementById("message").innerText = "";
  }
</script>
</body>
</html>
