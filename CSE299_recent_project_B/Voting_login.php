<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Voter Login</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #e3f2fd;
      margin: 0;
      padding: 40px 10px;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
    }
    .container {
      background: white;
      max-width: 400px;
      width: 100%;
      padding: 30px 30px 40px 30px;
      border-radius: 15px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }
    h2 {
      color: #1976d2;
      text-align: center;
      margin-bottom: 25px;
    }
    label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: #333;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 18px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }
    input:focus {
      border-color: #1976d2;
      outline: none;
    }
    button {
      width: 100%;
      padding: 14px;
      border-radius: 10px;
      border: none;
      background-color: #1976d2;
      color: white;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-bottom: 12px;
    }
    button:hover {
      background-color: #125ca1;
    }
    .error {
      color: red;
      font-size: 0.9em;
      margin-top: -12px;
      margin-bottom: 12px;
    }
    .link {
      text-align: right;
      margin-top: -12px;
      margin-bottom: 15px;
      font-size: 0.9rem;
      cursor: pointer;
      color: #1976d2;
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="container" id="loginContainer">
    <h2>Voter Login</h2>
    <form id="loginForm">
      <label for="loginMobile">Mobile Number</label>
      <input type="text" id="loginMobile" required placeholder="e.g. 017XXXXXXXX" />
      
      <label for="loginPassword">Password</label>
      <input type="password" id="loginPassword" required placeholder="Enter your password" />
      
      <label for="loginOTP">OTP</label>
      <input type="text" id="loginOTP" placeholder="Enter OTP after sending" />
      <button type="button" id="sendOtpBtn">Send OTP</button>
      <div id="otpMessage" style="color:green; margin-bottom:10px;"></div>

      <div class="error" id="loginError"></div>
      <button type="submit">Login</button>
    </form>
    <div class="link" id="forgotPassword">Forgot Password?</div>
  </div>

  <div class="container" id="resetPasswordContainer" style="display:none;">
    <h2>Reset Password</h2>
    <form id="resetPasswordForm">
      <label for="resetMobile">Mobile Number</label>
      <input type="text" id="resetMobile" required placeholder="Registered mobile number" />
      
      <label for="resetOTP">OTP</label>
      <input type="text" id="resetOTP" placeholder="Enter OTP" />
      <button type="button" id="sendResetOtpBtn">Send OTP</button>

      <label for="newPassword">New Password</label>
      <input type="password" id="newPassword" required placeholder="New password" />
      <label for="confirmNewPassword">Confirm New Password</label>
      <input type="password" id="confirmNewPassword" required placeholder="Confirm new password" />
      <div class="error" id="resetError"></div>
      <button type="submit">Reset Password</button>
      <div class="link" id="backToLogin">Back to Login</div>
    </form>
  </div>

<script>
  const users = [
    { mobile: "01712345678", password: "pass1234" },
    { mobile: "01987654321", password: "mypassword" }
  ];

  let generatedLoginOTP = null;
  let generatedResetOTP = null;

  const loginForm = document.getElementById('loginForm');
  const sendOtpBtn = document.getElementById('sendOtpBtn');
  const loginError = document.getElementById('loginError');
  const otpMessage = document.getElementById('otpMessage');

  const resetPasswordContainer = document.getElementById('resetPasswordContainer');
  const resetPasswordForm = document.getElementById('resetPasswordForm');
  const resetError = document.getElementById('resetError');
  const sendResetOtpBtn = document.getElementById('sendResetOtpBtn');
  const loginContainer = document.getElementById('loginContainer');

  sendOtpBtn.addEventListener('click', () => {
    const mobile = document.getElementById('loginMobile').value.trim();
    if (!mobile) {
      loginError.textContent = "Please enter your mobile number.";
      return;
    }
    if (!users.find(u => u.mobile === mobile)) {
      loginError.textContent = "Mobile number not registered.";
      return;
    }
    loginError.textContent = "";
    generatedLoginOTP = (Math.floor(1000 + Math.random() * 9000)).toString();
    otpMessage.textContent = `OTP sent: ${generatedLoginOTP} (simulated)`;
  });

  loginForm.addEventListener('submit', e => {
    e.preventDefault();
    loginError.textContent = "";
    otpMessage.textContent = "";

    const mobile = document.getElementById('loginMobile').value.trim();
    const password = document.getElementById('loginPassword').value;
    const otp = document.getElementById('loginOTP').value.trim();

    const user = users.find(u => u.mobile === mobile);
    if (!user) {
      loginError.textContent = "Mobile number not registered.";
      return;
    }
    if (user.password !== password) {
      loginError.textContent = "Incorrect password.";
      return;
    }
    if (otp !== generatedLoginOTP) {
      loginError.textContent = "Incorrect or missing OTP.";
      return;
    }

    // ✅ Redirect to dashboard
    window.location.href = "dashboard.html";
  });

  document.getElementById('forgotPassword').addEventListener('click', () => {
    loginContainer.style.display = 'none';
    resetPasswordContainer.style.display = 'block';
    resetPasswordForm.reset();
    resetError.textContent = '';
  });

  sendResetOtpBtn.addEventListener('click', () => {
    const mobile = document.getElementById('resetMobile').value.trim();
    if (!mobile) {
      resetError.textContent = "Please enter your mobile number.";
      return;
    }
    if (!users.find(u => u.mobile === mobile)) {
      resetError.textContent = "Mobile number not registered.";
      return;
    }
    resetError.textContent = "";
    generatedResetOTP = (Math.floor(1000 + Math.random() * 9000)).toString();
    alert(`Reset OTP sent: ${generatedResetOTP} (simulated)`);
  });

  resetPasswordForm.addEventListener('submit', e => {
    e.preventDefault();
    resetError.textContent = "";

    const mobile = document.getElementById('resetMobile').value.trim();
    const otp = document.getElementById('resetOTP').value.trim();
    const newPassword = document.getElementById('newPassword').value;
    const confirmNewPassword = document.getElementById('confirmNewPassword').value;

    if (otp !== generatedResetOTP) {
      resetError.textContent = "Incorrect OTP.";
      return;
    }
    if (newPassword !== confirmNewPassword) {
      resetError.textContent = "Passwords do not match.";
      return;
    }

    const user = users.find(u => u.mobile === mobile);
    if (user) {
      user.password = newPassword;
      alert("Password reset successfully. Please login with new password.");
      resetPasswordContainer.style.display = 'none';
      loginContainer.style.display = 'block';
    } else {
      resetError.textContent = "Mobile number not registered.";
    }
  });

  document.getElementById('backToLogin').addEventListener('click', () => {
    resetPasswordContainer.style.display = 'none';
    loginContainer.style.display = 'block';
  });
</script>

</body>
</html>
