const form = document.getElementById("voteForm");
const message = document.getElementById("vote-message");

// Load vote state
if (localStorage.getItem("votedParty")) {
  disableVotingForm(localStorage.getItem("votedParty"));
}

// Submit Vote
form.addEventListener("submit", function (e) {
  e.preventDefault();

  const selectedParty = document.querySelector('input[name="party"]:checked');
  if (selectedParty) {
    const partyName = selectedParty.value;
    localStorage.setItem("votedParty", partyName);
    message.textContent = `✅ You have successfully voted for "${partyName}"`;
    message.style.color = "green";
    disableVotingForm(partyName);
    showNotification(`Your vote for "${partyName}" was recorded successfully.`);
  } else {
    message.textContent = "⚠️ Please select a political party before voting.";
    message.style.color = "red";
  }
});

// Disable form if already voted
function disableVotingForm(partyName) {
  document.querySelectorAll('input[name="party"]').forEach(input => input.disabled = true);
  form.classList.add("voted");
  document.getElementById("voteBtn").disabled = true;
  message.textContent = `✅ You already voted for "${partyName}"`;
  message.style.color = "green";
}

// Countdown Timer
const countdownEl = document.getElementById("countdown-timer");
const votingDate = new Date("July 15, 2025 10:00:00").getTime();

function updateCountdown() {
  const now = new Date().getTime();
  const distance = votingDate - now;

  if (distance <= 0) {
    countdownEl.textContent = "✅ Voting is now LIVE!";
    return;
  }

  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  countdownEl.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s left`;
}

setInterval(updateCountdown, 1000);
updateCountdown();

// Notification function
function showNotification(msg) {
  const box = document.getElementById("notification-box");
  box.innerHTML = `<p>${msg}</p>`;
}
