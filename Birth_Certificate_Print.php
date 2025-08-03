<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Birth Certificate Login Portal</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
    }
    h1 {
      margin-top: 20px;
      color: #007bff;
    }
    .container {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      margin-bottom: 20px;
    }
    h2 {
      margin-bottom: 20px;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      width: 100%;
      padding: 10px;
      background: #007bff;
      border: none;
      color: white;
      border-radius: 4px;
      cursor: pointer;
    }
    button:hover {
      background: #0056b3;
    }
    #certificate-section {
      display: none;
    }
    .message {
      color: red;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <h1>Birth Certificate Login Portal</h1>

  <div class="container" id="login-section">
    <h2>Login</h2>
    <input type="text" id="login-form-number" placeholder="Form Number" />
    <input type="text" id="login-mobile" placeholder="Mobile Number" />
    <input type="password" id="login-password" placeholder="Password" />
    <button onclick="sendOTP()">Send OTP</button>
    <input type="text" id="otp" placeholder="Enter OTP" style="display:none;" />
    <button id="verifyBtn" onclick="verifyOTP()" style="display:none;">Verify and Login</button>
    <div id="login-message" class="message"></div>
  </div>

  <div class="container" id="certificate-section">
    <h2>Download Birth Certificate</h2>
    <input type="text" id="form-number" placeholder="Form Number" />
    <input type="text" id="cert-mobile" placeholder="Mobile Number" />
    <button onclick="downloadCertificate()">Download Certificate</button>
    <div id="certificate-message" class="message"></div>
  </div>

  <script>
    const registeredMobile = localStorage.getItem("mobile");
    const registeredPassword = localStorage.getItem("password");
    const registeredFormNumber = localStorage.getItem("formNo");
    const registeredPDFDataURL = localStorage.getItem("formPDF");

    let generatedOTP;

    function sendOTP() {
      const formNo = document.getElementById('login-form-number').value;
      const mobile = document.getElementById('login-mobile').value;
      const password = document.getElementById('login-password').value;
      const loginMessage = document.getElementById('login-message');

      if (formNo !== registeredFormNumber || mobile !== registeredMobile || password !== registeredPassword) {
        loginMessage.innerText = "Incorrect credentials. Please try again.";
        return;
      }

      loginMessage.innerText = "";
      generatedOTP = Math.floor(100000 + Math.random() * 900000);
      alert("OTP Sent: " + generatedOTP); // simulate sending OTP
      document.getElementById('otp').style.display = 'block';
      document.getElementById('verifyBtn').style.display = 'block';
    }

    function verifyOTP() {
      const enteredOTP = document.getElementById('otp').value;
      if (enteredOTP == generatedOTP) {
        alert("Login successful!");
        document.getElementById('login-section').style.display = 'none';
        document.getElementById('certificate-section').style.display = 'block';
      } else {
        alert("Incorrect OTP");
      }
    }

    function downloadCertificate() {
      const formNumber = document.getElementById('form-number').value;
      const mobile = document.getElementById('cert-mobile').value;
      const certMessage = document.getElementById('certificate-message');

      if (formNumber !== registeredFormNumber || mobile !== registeredMobile) {
        certMessage.innerText = "Invalid form number or mobile number.";
        return;
      }

      if (!registeredPDFDataURL) {
        certMessage.innerText = "No certificate file found. Please contact support.";
        return;
      }

      certMessage.innerText = "";
      const link = document.createElement('a');
      link.href = registeredPDFDataURL;
      link.download = 'birth_certificate.pdf';
      link.click();
    }
  </script>
</body>
</html>
