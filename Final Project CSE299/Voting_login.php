<?php
session_start();
include 'db.php';

$error = '';
$mobile = $_POST['mobile'] ?? '';

// Login form submission
if (isset($_POST['login'])) {
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM voters WHERE mobile='$mobile' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['voter_id'] = $user['id'];
            $_SESSION['voter_mobile'] = $user['mobile'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Mobile number not registered.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Voter Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #0f172a;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      background: #1e293b;
      padding: 30px;
      border-radius: 10px;
      width: 100%;
      max-width: 400px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      background: #0f172a;
      border: 1px solid #334155;
      border-radius: 5px;
      color: #fff;
    }
    button {
      width: 100%;
      padding: 10px;
      margin-top: 20px;
      background: #3b82f6;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background: #2563eb;
    }
    .error {
      margin-top: 10px;
      color: #f87171;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Voter Login</h2>
    <form method="POST" action="">
      <label>Mobile Number</label>
      <input type="text" name="mobile" required placeholder="e.g. 017XXXXXXXX" value="<?= htmlspecialchars($mobile) ?>" />

      <label>Password</label>
      <input type="password" name="password" required />

      <button type="submit" name="login">Login</button>

      <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>
