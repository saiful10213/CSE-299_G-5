<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Birth Certificate Correction</title>
  <style>
    * {
      box-sizing: border-box;
    }

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
      transition: all 0.3s ease-in-out;
      animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
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

    input[type="text"],
    input[type="password"],
    input[type="date"] {
      width: 100%;
      padding: 10px 12px;
      margin-top: 5px;
      border-radius: 8px;
      border: 1px solid #ccc;
      outline: none;
      transition: border-color 0.3s;
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
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #004d40;
    }

    .hidden {
      display: none;
    }

    .message {
      margin-top: 15px;
      text-align: center;
      font-weight: 600;
    }

    .error {
      color: red;
    }

    .success {
      color: green;
    }

  </style>
</head>
<body>

  <!-- Login Page -->
  <div class="card" id="loginPage">
    <h2>Login to Correct Certificate</h2>
    <form id="loginForm">
      <label>Mobile Number:</label>
      <input type="text" id="loginMobile" placeholder="e.g. 01712345678" required>

      <label>Password:</label>
      <input type="password" id="loginPassword" required>

      <button type="submit">Login</button>
    </form>
    <p class="message error" id="loginMessage"></p>
  </div>

  <!-- Correction Page -->
  <div class="card hidden" id="correctionPage">
    <h2>Correction Form</h2>
    <form id="correctionForm">
      <label>Certificate Form No:</label>
      <input type="text" id="formNo" readonly />

      <label>Name of Child:</label>
      <input type="text" id="childName" required />

      <label>Father's Name:</label>
      <input type="text" id="fatherName" required />

      <label>Mother's Name:</label>
      <input type="text" id="motherName" required />

      <label>Birth Date:</label>
      <input type="date" id="birthDate" required />

      <label>House No:</label>
      <input type="text" id="houseNo" />

      <label>Road No:</label>
      <input type="text" id="roadNo" />

      <label>Road Name:</label>
      <input type="text" id="roadName" />

      <label>Village Name:</label>
      <input type="text" id="village" required />

      <label>Word No:</label>
      <input type="text" id="wordNo" />

      <label>Union Name:</label>
      <input type="text" id="union" required />

      <label>Thana:</label>
      <input type="text" id="thana" required />

      <label>Post Office:</label>
      <input type="text" id="postOffice" required />

      <label>District:</label>
      <input type="text" id="district" required />

      <label>Division:</label>
      <input type="text" id="division" required />

      <label>Nationality:</label>
      <input type="text" id="nationality" required />

      <label>Issue Date:</label>
      <input type="date" id="issueDate" required />

      <label>Issued By:</label>
      <input type="text" id="issuedBy" required />

      <label>Chairman's Signature:</label>
      <input type="text" id="chairmanSignature" required />

      <label>Parent's Signature:</label>
      <input type="text" id="parentSignature" required />

      <button type="submit">Submit Correction</button>
    </form>
    <p class="message success" id="correctionMessage"></p>
  </div>

  <script>
    // Simulated credentials from sign-up
    const savedMobile = "01712345678";
    const savedPassword = "mypassword";

    // Simulated data from previous application
    const formData = {
      formNo: "FORM-654321",
      childName: "Adiyan Al Mujaheedy",
      fatherName: "Abdullah Al Masud",
      motherName: "Fatema Khatun",
      birthDate: "2013-05-22",
      houseNo: "12",
      roadNo: "5",
      roadName: "Lakeview",
      village: "Green Village",
      wordNo: "3",
      union: "Khilkhet Union",
      thana: "Khilkhet",
      postOffice: "Dhaka Cantonment",
      district: "Dhaka",
      division: "Dhaka",
      nationality: "Bangladeshi",
      issueDate: "2023-01-01",
      issuedBy: "Ward Chairman",
      chairmanSignature: "Md. Selim",
      parentSignature: "Abdullah Al Masud"
    };

    const loginForm = document.getElementById("loginForm");
    const correctionForm = document.getElementById("correctionForm");
    const loginPage = document.getElementById("loginPage");
    const correctionPage = document.getElementById("correctionPage");

    loginForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const mobile = document.getElementById("loginMobile").value.trim();
      const password = document.getElementById("loginPassword").value.trim();

      if (mobile === savedMobile && password === savedPassword) {
        loginPage.classList.add("hidden");
        correctionPage.classList.remove("hidden");

        // Fill correction form
        for (const key in formData) {
          const field = document.getElementById(key);
          if (field) field.value = formData[key];
        }

        document.getElementById("loginMessage").innerText = "";
      } else {
        document.getElementById("loginMessage").innerText = "Invalid mobile number or password!";
      }
    });

    correctionForm.addEventListener("submit", function (e) {
      e.preventDefault();
      document.getElementById("correctionMessage").innerText = "Correction submitted successfully!";
    });
  </script>

</body>
</html>
