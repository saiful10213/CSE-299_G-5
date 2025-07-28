document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const checkbox = document.getElementById("confirmCheckbox").checked;
  const nid = document.getElementById("nid").value;
  const dob = document.getElementById("dob").value;

  if (!checkbox) {
    document.getElementById("loginMessage").innerText = "You must confirm to proceed.";
    return;
  }

  if (!/^\d{10,17}$/.test(nid)) {
    document.getElementById("loginMessage").innerText = "Enter a valid NID number (10-17 digits).";
    return;
  }

  // Clear messages and show correction form
  document.getElementById("loginMessage").innerText = "";
  document.getElementById("correctionNID").value = nid;
  document.getElementById("loginPage").style.display = "none";
  document.getElementById("correctionPage").style.display = "block";
});

document.getElementById("correctionForm").addEventListener("submit", function (e) {
  e.preventDefault();
  document.getElementById("correctionMessage").style.color = "green";
  document.getElementById("correctionMessage").innerText = "NID Correction application submitted!";
});
