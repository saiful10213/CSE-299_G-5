<!-- voter-signup.html (connected and updated) -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Voter Sign-Up Portal</title>
  <style>
    /* (same CSS as before, unchanged) */
  </style>
</head>
<body>
  <div class="container">
    <h2>Voter Sign-Up Portal</h2>
    <form id="signupForm">
      <!-- form fields remain the same -->
    </form>
  </div>

  <script>
    let generatedOTP = null;

    async function performOCR(file) {
      const formData = new FormData();
      formData.append("image", file);
      try {
        const response = await fetch("https://api.ocr.space/parse/image", {
          method: "POST",
          headers: {
            apikey: "your_ocr_space_api_key",
          },
          body: formData,
        });
        const result = await response.json();
        return result.ParsedResults?.[0]?.ParsedText || "";
      } catch (error) {
        console.error("OCR error:", error);
        return "";
      }
    }

    function openCamera() {
      const video = document.getElementById("photoVideo");
      const captureBtn = document.querySelector("button[onclick='capturePhoto()']");
      video.style.display = "block";
      captureBtn.style.display = "inline-block";

      navigator.mediaDevices
        .getUserMedia({ video: { width: 300, height: 400 } })
        .then((stream) => {
          video.srcObject = stream;
        })
        .catch(() => {
          alert("Camera access denied or not available.");
        });
    }

    function capturePhoto() {
      const video = document.getElementById("photoVideo");
      const canvas = document.getElementById("photoCanvas");
      canvas.width = 300;
      canvas.height = 400;
      const context = canvas.getContext("2d");
      context.drawImage(video, 0, 0, 300, 400);
      canvas.toBlob((blob) => {
        const fileInput = document.getElementById("photoUpload");
        const dataTransfer = new DataTransfer();
        const file = new File([blob], "passport_photo.png", { type: "image/png" });
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
        alert("Photo captured and set as passport photo.");
      }, "image/png");
    }

    document.getElementById("signupForm").addEventListener("submit", async function (e) {
      e.preventDefault();

      const password = document.getElementById("password").value;
      const confirmPassword = document.getElementById("confirmPassword").value;
      const enteredOTP = document.getElementById("otp").value;
      const mobile = document.getElementById("mobile").value;
      const nidFront = document.getElementById("nidFront").files[0];

      if (!nidFront) {
        alert("Please upload NID front side.");
        return;
      }

      const text = await performOCR(nidFront);
      if (!text.toLowerCase().includes("election commission") || !text.toLowerCase().includes("signature")) {
        alert("NID must contain Election Commission logo and signature (OCR failed).\nOCR Result: " + text);
        return;
      }

      if (password !== confirmPassword) {
        document.getElementById("passwordError").textContent = "Passwords do not match.";
        return;
      } else {
        document.getElementById("passwordError").textContent = "";
      }

      if (enteredOTP !== generatedOTP) {
        document.getElementById("otpError").textContent = "Incorrect OTP.";
        return;
      } else {
        document.getElementById("otpError").textContent = "";
      }

      const users = JSON.parse(localStorage.getItem("userDB") || "[]");

      if (users.some(user => user.mobile === mobile)) {
        alert("Mobile number already registered.");
        return;
      }

      const nameMatch = text.match(/Name[:\-\s]*([A-Z ]{3,})/i);
      const name = nameMatch ? nameMatch[1].trim() : "New Voter";
      const voterId = "BD" + Date.now();

      const newUser = { name, voterId, mobile, password };
      users.push(newUser);
      localStorage.setItem("userDB", JSON.stringify(users));

      localStorage.setItem("loggedInUser", JSON.stringify({ name, voterId }));

      alert("✅ Sign-up successful! Redirecting to dashboard...");
      window.location.href = "dashboard.html";
    });

    function sendOTP() {
      generatedOTP = Math.floor(1000 + Math.random() * 9000).toString();
      alert("Your OTP is: " + generatedOTP);
    }

    function verifyOTP() {
      const enteredOTP = document.getElementById("otp").value;
      if (enteredOTP !== generatedOTP) {
        document.getElementById("otpError").textContent = "Incorrect OTP.";
      } else {
        document.getElementById("otpError").textContent = "OTP verified successfully.";
      }
    }
  </script>
</body>
</html>