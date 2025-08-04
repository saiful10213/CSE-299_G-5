<?php
session_start();
require 'db.php'; // your DB connection here
require('fpdf.php');

$error = '';
$loginError = '';
$resetError = '';
$resetSuccess = '';

// Logout handler
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: nid_portal.php');
    exit;
}

// Password Reset handler
if (isset($_POST['reset_password'])) {
    $mobile = trim($_POST['reset_mobile']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $resetError = "Passwords do not match.";
    } else {
        // Check if mobile exists
        $stmt = $conn->prepare("SELECT id FROM nid_applications WHERE mobile = ?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt_update = $conn->prepare("UPDATE nid_applications SET password_hash = ? WHERE id = ?");
            $stmt_update->bind_param("si", $hashed, $user['id']);
            if ($stmt_update->execute()) {
                $resetSuccess = "Password has been reset successfully. Please log in.";
            } else {
                $resetError = "Error updating password.";
            }
            $stmt_update->close();
        } else {
            $resetError = "Mobile number not found.";
        }
        $stmt->close();
    }
}

// If user clicked download NID PDF
if (isset($_GET['download']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT full_name_en, father_name, mother_name, dob, gender, blood_group, marital_status, nationality, present_address, permanent_address, mobile, form_no FROM nid_applications WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$user) {
        die("User data not found.");
    }

    // Generate PDF with FPDF
    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,'National ID Card',0,1,'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial','',12);
    foreach ($user as $key => $value) {
        $label = ucwords(str_replace('_', ' ', $key));
        $pdf->Cell(50,10,"$label:",0,0);
        $pdf->Cell(0,10,$value,0,1);
    }

    $pdf->Output('D', 'NID_'.$user['form_no'].'.pdf'); // force download
    exit;
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $mobile = trim($_POST['mobile']);
    $password = $_POST['password'];

    // Now search only by mobile
    $stmt = $conn->prepare("SELECT id, password_hash FROM nid_applications WHERE mobile = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password_hash'])) {
            // Success: set session
            $_SESSION['user_id'] = $user['id'];

            $stmt2 = $conn->prepare("SELECT form_no FROM nid_applications WHERE id = ?");
            $stmt2->bind_param("i", $user['id']);
            $stmt2->execute();
            $res2 = $stmt2->get_result()->fetch_assoc();
            $_SESSION['form_no'] = $res2['form_no'] ?? '';
            $stmt2->close();
        } else {
            $loginError = "Invalid password.";
        }
    } else {
        $loginError = "Mobile number not found.";
    }
    $stmt->close();
}

$loggedIn = isset($_SESSION['user_id']);

// If logged in, get user info
if ($loggedIn) {
    $stmt = $conn->prepare("SELECT full_name_en, father_name, dob, form_no FROM nid_applications WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $userInfo = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>NID Card Download Portal</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #eaf0f6;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 50px;
  }
  .container {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    max-width: 400px;
    width: 100%;
    margin-bottom: 20px;
  }
  h1, h2 {
    color: #007bff;
    text-align: center;
  }
  input, button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
  }
  button {
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
  }
  button:hover {
    background-color: #0056b3;
  }
  .message {
    color: red;
    text-align: center;
  }
  .success {
    color: green;
    text-align: center;
  }
  .welcome {
    text-align: center;
    margin-bottom: 20px;
  }
  a.logout {
    display: block;
    text-align: center;
    margin-top: 10px;
    color: #007bff;
    text-decoration: underline;
    cursor: pointer;
  }
  .link-button {
    background: none;
    border: none;
    color: #007bff;
    text-decoration: underline;
    cursor: pointer;
    padding: 0;
    margin: 10px 0;
    font-size: 14px;
  }
</style>
<script>
function showResetForm() {
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('resetForm').style.display = 'block';
}

function showLoginForm() {
    document.getElementById('resetForm').style.display = 'none';
    document.getElementById('loginForm').style.display = 'block';
}
</script>
</head>
<body>

<div class="container">

<?php if (!$loggedIn): ?>

  <h1>NID Card Download Portal</h1>

  <form method="POST" id="loginForm" style="display:block;">
    <input type="text" name="mobile" placeholder="Mobile Number" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit" name="login">Login</button>
  </form>

  <button class="link-button" onclick="showResetForm()">Forgot Password?</button>

  <?php if ($loginError): ?>
    <p class="message"><?=htmlspecialchars($loginError)?></p>
  <?php endif; ?>

  <form method="POST" id="resetForm" style="display:none;">
    <input type="text" name="reset_mobile" placeholder="Enter your Mobile Number" required />
    <input type="password" name="new_password" placeholder="New Password" required />
    <input type="password" name="confirm_password" placeholder="Confirm New Password" required />
    <button type="submit" name="reset_password">Reset Password</button>
    <button type="button" onclick="showLoginForm()">Back to Login</button>
  </form>

  <?php if ($resetError): ?>
    <p class="message"><?=htmlspecialchars($resetError)?></p>
  <?php endif; ?>
  <?php if ($resetSuccess): ?>
    <p class="success"><?=htmlspecialchars($resetSuccess)?></p>
  <?php endif; ?>

<?php else: ?>

  <div class="welcome">
    <h2>Welcome, <?=htmlspecialchars($userInfo['full_name_en'])?></h2>
    <p>Form Number: <?=htmlspecialchars($userInfo['form_no'])?></p>
    <p>Date of Birth: <?=htmlspecialchars($userInfo['dob'])?></p>
    <a href="?download=1" class="button">Download Your NID Card (PDF)</a>
    <a href="?logout=1" class="logout">Logout</a>
  </div>

<?php endif; ?>

</div>

</body>
</html>
