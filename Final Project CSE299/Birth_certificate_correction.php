<?php
session_start();
include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$loginError = "";
$userData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
  $mobile = $_POST['mobile'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM birth_applications WHERE mobile = ?");
  $stmt->bind_param("s", $mobile);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['user'] = $row;
      $userData = $row;
    } else {
      $loginError = "Invalid password!";
    }
  } else {
    $loginError = "Mobile number not found!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Birth Certificate Correction</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #e0f7fa, #fff);
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding-top: 60px;
    }

    .card {
      background-color: #ffffff;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      padding: 30px;
      width: 100%;
      max-width: 500px;
      animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      text-align: center;
      color: #00796b;
      margin-bottom: 25px;
    }

    label {
      font-weight: 600;
      display: block;
      margin-top: 15px;
    }

    input[type="text"], input[type="password"], input[type="date"] {
      width: 100%;
      padding: 10px 12px;
      margin-top: 5px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    input:focus {
      border-color: #00796b;
    }

    button {
      background-color: #00796b;
      color: white;
      border: none;
      padding: 12px;
      margin-top: 25px;
      border-radius: 8px;
      width: 100%;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #004d40;
    }

    .message { margin-top: 15px; text-align: center; font-weight: 600; }
    .error { color: red; }
    .success { color: green; }
  </style>
</head>
<body>

<div class="card">
<?php if (!isset($_SESSION['user'])): ?>
  <h2>Login to Correct Certificate</h2>
  <form method="POST">
    <label>Mobile Number:</label>
    <input type="text" name="mobile" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button type="submit" name="login">Login</button>
    <p class="message error"><?php echo $loginError; ?></p>
  </form>
<?php else: ?>
  <h2>Correction Form</h2>
  <form method="POST" action="submit_correction.php">
    <label>Certificate Form No:</label>
    <input type="text" name="form_no" value="<?php echo $userData['form_no']; ?>" readonly>

    <label>Name of Child:</label>
    <input type="text" name="childName" value="<?php echo $userData['childName'] ?? ''; ?>" required>

    <label>Father's Name:</label>
    <input type="text" name="fatherName" value="<?php echo $userData['fatherName'] ?? ''; ?>" required>

    <label>Mother's Name:</label>
    <input type="text" name="motherName" value="<?php echo $userData['motherName'] ?? ''; ?>" required>

    <label>Birth Date:</label>
    <input type="date" name="birthDate" value="<?php echo $userData['birthDate'] ?? ''; ?>" required>

    <label>House No:</label>
    <input type="text" name="houseNo" value="<?php echo $userData['houseNo'] ?? ''; ?>">

    <label>Road No:</label>
    <input type="text" name="roadNo" value="<?php echo $userData['roadNo'] ?? ''; ?>">

    <label>Road Name:</label>
    <input type="text" name="roadName" value="<?php echo $userData['roadName'] ?? ''; ?>">

    <label>Village Name:</label>
    <input type="text" name="village" value="<?php echo $userData['village'] ?? ''; ?>" required>

    <label>Word No:</label>
    <input type="text" name="wordNo" value="<?php echo $userData['wordNo'] ?? ''; ?>">

    <label>Union Name:</label>
    <input type="text" name="union" value="<?php echo $userData['union'] ?? ''; ?>" required>

    <label>Thana:</label>
    <input type="text" name="thana" value="<?php echo $userData['thana'] ?? ''; ?>" required>

    <label>Post Office:</label>
    <input type="text" name="postOffice" value="<?php echo $userData['postOffice'] ?? ''; ?>" required>

    <label>District:</label>
    <input type="text" name="district" value="<?php echo $userData['district'] ?? ''; ?>" required>

    <label>Division:</label>
    <input type="text" name="division" value="<?php echo $userData['division'] ?? ''; ?>" required>

    <label>Nationality:</label>
    <input type="text" name="nationality" value="<?php echo $userData['nationality'] ?? ''; ?>" required>

    <label>Issue Date:</label>
    <input type="date" name="issueDate" value="<?php echo $userData['issueDate'] ?? ''; ?>" required>

    <label>Issued By:</label>
    <input type="text" name="issuedBy" value="<?php echo $userData['issuedBy'] ?? ''; ?>" required>

    <label>Chairman's Signature:</label>
    <input type="text" name="chairmanSignature" value="<?php echo $userData['chairmanSignature'] ?? ''; ?>" required>

    <label>Parent's Signature:</label>
    <input type="text" name="parentSignature" value="<?php echo $userData['parentSignature'] ?? ''; ?>" required>

    <button type="submit">Submit Correction</button>
  </form>
<?php endif; ?>
</div>

</body>
</html>
