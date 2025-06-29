<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    .link {
      text-align: center;
      margin-top: 10px;
    }
    .link a {
      color: #007bff;
      cursor: pointer;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <h1>NID Card Download Portal</h1>

  <div class="container" id="login-section">
    <h2>Login</h2>
    <input type="text" id="formNo" placeholder="Form Number" required />
    <input type="text" id="mobile" placeholder="Mobile Number" required />
    <input type="password" id="password" placeholder="Password" required />
    <button onclick="sendOtp()">Send OTP</button>
    <input type="text" id="otp" placeholder="Enter OTP" style="display:none" />
    <button onclick="verifyLogin()" id="verifyBtn" style="display:none">Verify and Login</button>
    <div id="loginMessage" class="message"></div>
    <div class="link"><a onclick="showForgotSection()">Forgot Password?</a></div>
  </div>

  <div class="container" id="forgot-section" style="display:none">
    <h2>Reset Password</h2>
    <input type="text" id="forgotMobile" placeholder="Enter Registered Mobile Number" />
    <input type="password" id="newPassword" placeholder="New Password" />
    <input type="password" id="confirmPassword" placeholder="Confirm Password" />
    <button onclick="resetPassword()">Reset Password</button>
    <div id="resetMessage" class="message"></div>
    <div class="link"><a onclick="backToLogin()">Back to Login</a></div>
  </div>

  <div class="container" id="nid-section" style="display: none">
    <h2>Download Your NID</h2>
    <p>Your NID is ready for download.</p>
    <button onclick="downloadNid()">Download NID (PDF)</button>
    <div id="downloadMessage" class="message"></div>
  </div>

  <script>
    let registeredFormNo = "FORM123456";
    let registeredMobile = "017XXXXXXXX";
    let registeredPassword = "secure123";
    const nidPDF = "sample_nid.pdf"; // Replace with actual PDF link

    let generatedOTP = "";

    function sendOtp() {
      const form = document.getElementById("formNo").value;
      const mobile = document.getElementById("mobile").value;
      const password = document.getElementById("password").value;

      if (form !== registeredFormNo || mobile !== registeredMobile || password !== registeredPassword) {
        document.getElementById("loginMessage").innerText = "Incorrect credentials. Please try again.";
        return;
      }

      generatedOTP = Math.floor(100000 + Math.random() * 900000).toString();
      alert("OTP Sent: " + generatedOTP);
      document.getElementById("otp").style.display = "block";
      document.getElementById("verifyBtn").style.display = "block";
      document.getElementById("loginMessage").innerText = "";
    }

    function verifyLogin() {
      const enteredOTP = document.getElementById("otp").value;
      if (enteredOTP === generatedOTP) {
        document.getElementById("login-section").style.display = "none";
        document.getElementById("nid-section").style.display = "block";
      } else {
        document.getElementById("loginMessage").innerText = "Incorrect OTP.";
      }
    }

    function downloadNid() {
      const link = document.createElement("a");
      link.href = nidPDF;
      link.download = "NID_Card.pdf";
      link.click();
    }

    function showForgotSection() {
      document.getElementById("login-section").style.display = "none";
      document.getElementById("forgot-section").style.display = "block";
    }

    function backToLogin() {
      document.getElementById("forgot-section").style.display = "none";
      document.getElementById("login-section").style.display = "block";
    }

    function resetPassword() {
      const mobile = document.getElementById("forgotMobile").value;
      const newPassword = document.getElementById("newPassword").value;
      const confirmPassword = document.getElementById("confirmPassword").value;
      const resetMessage = document.getElementById("resetMessage");

      if (mobile !== registeredMobile) {
        resetMessage.innerText = "Mobile number does not match.";
        return;
      }

      if (newPassword !== confirmPassword) {
        resetMessage.innerText = "Passwords do not match.";
        return;
      }

      registeredPassword = newPassword;
      resetMessage.style.color = "green";
      resetMessage.innerText = "Password reset successfully. You can now log in.";
    }
  </script>
</body>
</html>