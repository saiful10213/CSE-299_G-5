const pages = document.querySelectorAll(".page");
let user = {};

// Generate random code and OTP each time the page loads
const verificationCode = generateRandomCode(6);
const otpCode = generateOTP();

document.getElementById("verificationDisplay").textContent = verificationCode;
document.getElementById("otpDisplay").textContent = otpCode;

function generateRandomCode(length) {
  const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  return Array.from({ length }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
}

function generateOTP() {
  return String(Math.floor(100000 + Math.random() * 900000));
}

function showPage(n) {
  pages.forEach(p => p.classList.remove("active"));
  document.getElementById("page" + n).classList.add("active");
}

function goToPage2() {
  const name = document.getElementById("name").value.trim();
  const dob = document.getElementById("dob").value;
  const inputCode = document.getElementById("verificationInput").value.trim().toUpperCase();

  if (inputCode !== verificationCode) {
    alert("Incorrect verification code.");
    return false;
  }

  user.name = name;
  user.dob = dob;

  showPage(2);
  return false;
}

function goToPage3() {
  const contact = document.getElementById("contact").value.trim();
  if (!contact) {
    alert("Please enter a valid contact.");
    return false;
  }
  user.contact = contact;
  showPage(3);
  return false;
}

function goToPage4() {
  const username = document.getElementById("username").value.trim();
  const pass = document.getElementById("password").value;
  const retype = document.getElementById("retypePassword").value;

  if (pass !== retype) {
    alert("Passwords do not match.");
    return false;
  }

  user.username = username;
  user.password = pass;

  showPage(4);
  return false;
}

function goToPage5() {
  const otpInput = document.getElementById("otpInput").value.trim();
  if (otpInput !== otpCode) {
    alert("Incorrect OTP.");
    return false;
  }

  showPage(5);
  return false;
}

function goToPage6() {
  const uname = document.getElementById("confirmUsername").value.trim();
  const pass = document.getElementById("confirmPassword").value;
  const retype = document.getElementById("confirmRetype").value;

  if (uname !== user.username || pass !== user.password || pass !== retype) {
    alert("Username or password mismatch.");
    return false;
  }

  document.getElementById("finalName").textContent = user.name;
  document.getElementById("finalDob").textContent = user.dob;

  showPage(6);
  return false;
}

function restart() {
  location.reload();
}
