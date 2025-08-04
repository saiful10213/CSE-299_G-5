<?php
session_start();
include 'db.php'; // Your DB connection here
require('fpdf.php');

$error = '';
$loginError = '';
$resetError = '';
$resetSuccess = '';

// Logout handler
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: birth_cert_portal.php'); // adjust filename accordingly
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
        // Check if mobile exists in birth_applications
        $stmt = $conn->prepare("SELECT id FROM birth_applications WHERE mobile = ?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt_update = $conn->prepare("UPDATE birth_applications SET password = ? WHERE id = ?");
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

// Handle PDF download
if (isset($_GET['download']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Get form_no from birth_applications
    $stmt = $conn->prepare("SELECT form_no FROM birth_applications WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$res) {
        die("User application data not found.");
    }

    $form_no = $res['form_no'];

    // Get birth certificate data by form_no
    $stmt = $conn->prepare("SELECT * FROM birth_certificate WHERE form_no = ?");
    $stmt->bind_param("s", $form_no);
    $stmt->execute();
    $certificateData = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$certificateData) {
        die("Birth certificate data not found.");
    }

    // Generate PDF
    class PDF extends FPDF {
        function Header() {
            $this->SetFont('Arial', 'B', 16);
            $this->Cell(0, 10, 'Birth Certificate', 0, 1, 'C');
            $this->Ln(10);
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    foreach ($certificateData as $key => $value) {
        if (in_array($key, ['id'])) continue; // skip DB internal ID
        $pdf->Cell(60, 10, ucwords(str_replace('_', ' ', $key)) . ':', 0, 0);
        $pdf->Cell(0, 10, $value, 0, 1);
    }

    $fileName = "birth_certificate_" . $form_no . ".pdf";
    $pdf->Output("D", $fileName);
    exit;
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $mobile = trim($_POST['mobile']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM birth_applications WHERE mobile = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];

            // You may also fetch form_no for display
            $_SESSION['form_no'] = $user['form_no'] ?? '';
        } else {
            $loginError = "Invalid password.";
        }
    } else {
        $loginError = "Mobile number not found.";
    }
    $stmt->close();
}

$loggedIn = isset($_SESSION['user_id']);

if ($loggedIn) {
    // Get user info from birth_applications for display
    $stmt = $conn->prepare("SELECT mobile, form_no FROM birth_applications WHERE id = ?");
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
<title>Birth Certificate Download Portal</title>
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

  <h1>Birth Certificate Download Portal</h1>

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
    <h2>Welcome, Mobile: <?=htmlspecialchars($userInfo['mobile'])?></h2>
    <p>Form Number: <?=htmlspecialchars($userInfo['form_no'])?></p>
    <a href="?download=1" class="button">Download Your Birth Certificate (PDF)</a>
    <a href="?logout=1" class="logout">Logout</a>
  </div>

<?php endif; ?>

</div>

</body>
</html>
