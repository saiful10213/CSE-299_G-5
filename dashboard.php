<?php
session_start();
include 'db.php'; // DB connection

// Check if voter is logged in
if (!isset($_SESSION['voter_id'])) {
  header("Location: login.php");
  exit;
}

$voter_id = $_SESSION['voter_id'];

// Check if already voted
$stmt = $conn->prepare("SELECT * FROM votes WHERE voter_id = ?");
$stmt->bind_param("i", $voter_id);
$stmt->execute();
$vote_result = $stmt->get_result();
$has_voted = $vote_result->num_rows > 0;

// Handle vote submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['party'])) {
  if ($has_voted) {
    $message = "❌ You have already voted!";
  } else {
    $party = $_POST['party'];
    $stmt = $conn->prepare("INSERT INTO votes (voter_id, voted_party) VALUES (?, ?)");
    $stmt->bind_param("is", $voter_id, $party);
    if ($stmt->execute()) {
      $message = "✅ Your vote has been cast successfully.";
      $has_voted = true;
    } else {
      $message = "❌ Error submitting your vote.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Dashboard - E-Voting</title>
  <link rel="stylesheet" href="dashboard.css" />
</head>
<body>
  <header>
    <h1>🗳️ E-Voting Dashboard</h1>
    <p>Welcome to your secure voting area</p>
  </header>

  <main class="container">
    <!-- User Info -->
    <section class="user-info">
      <h2>Your Profile</h2>
      <div class="card">
        <p><strong>Status:</strong> <span class="verified">Active</span></p>
      </div>
    </section>

    <!-- Voting Schedule -->
    <section class="voting-info">
      <h2>🗓️ Voting Schedule</h2>
      <p><strong>Date:</strong> <span id="voting-date">July 15, 2025</span></p>
      <p><strong>Time:</strong> <span id="voting-time">10:00 AM - 4:00 PM</span></p>
    </section>

    <!-- Guidelines -->
    <section class="guidelines">
      <h2>📌 Voting Guidelines</h2>
      <ul>
        <li>One vote per person is allowed.</li>
        <li>Your vote is confidential and secure.</li>
        <li>Once submitted, votes cannot be changed.</li>
      </ul>
    </section>

    <!-- Countdown Timer -->
    <section class="countdown-section">
      <h2>⏳ Voting Countdown</h2>
      <p id="countdown-timer">Calculating...</p>
    </section>

    <!-- Notification Area -->
    <section class="notification-section">
      <h2>🔔 Notifications</h2>
      <div id="notification-box">
        <?php if (isset($message)) echo "<p>$message</p>"; else echo "<p>No new notifications.</p>"; ?>
      </div>
    </section>

    <!-- Voting Form -->
    <section class="vote-section">
      <h2>🗳️ Cast Your Vote</h2>
      <?php if ($has_voted): ?>
        <p class="message">✅ You have already voted. Thank you!</p>
      <?php else: ?>
      <form method="POST">
        <div class="party-grid">
          <label class="party-card">
            <input type="radio" name="party" value="Awami League" required />
            <div class="card-content">
              <img src="https://upload.wikimedia.org/wikipedia/en/f/f9/Flag_of_Awami_League.svg" alt="Awami League Logo" />
              <h3>Awami League</h3>
              <p>বাংলাদেশ আওয়ামী লীগ</p>
            </div>
          </label>
          <label class="party-card">
            <input type="radio" name="party" value="BNP" />
            <div class="card-content">
              <img src="https://upload.wikimedia.org/wikipedia/en/5/58/Flag_of_BNP.svg" alt="BNP Logo" />
              <h3>BNP</h3>
              <p>বাংলাদেশ জাতীয়তাবাদী দল</p>
            </div>
          </label>
          <label class="party-card">
            <input type="radio" name="party" value="Jatiya Party" />
            <div class="card-content">
              <img src="https://upload.wikimedia.org/wikipedia/commons/f/f3/Flag_of_Jatiya_Party.svg" alt="Jatiya Party Logo" />
              <h3>Jatiya Party</h3>
              <p>জাতীয় পার্টি</p>
            </div>
          </label>
          <label class="party-card">
            <input type="radio" name="party" value="Workers Party" />
            <div class="card-content">
              <img src="https://upload.wikimedia.org/wikipedia/commons/4/43/Communist_red_flag.svg" alt="Workers Party Logo" />
              <h3>Workers Party</h3>
              <p>ওয়ার্কার্স পার্টি</p>
            </div>
          </label>
          <label class="party-card">
            <input type="radio" name="party" value="Independent" />
            <div class="card-content">
              <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Independent_candidate_symbol.svg" alt="Independent Logo" />
              <h3>Independent</h3>
              <p>স্বতন্ত্র প্রার্থী</p>
            </div>
          </label>
        </div>
        <button type="submit" id="voteBtn">Submit Vote</button>
      </form>
      <?php endif; ?>
    </section>

    <!-- Support -->
    <section class="support">
      <h2>❓ Need Help?</h2>
      <p>If you're facing any issues, contact our support team:</p>
      <ul>
        <li>Email: support@evoting-bd.gov</li>
        <li>Phone: +880-1234-567890</li>
        <li>Live Chat: Available 10AM–6PM</li>
      </ul>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 E-Voting Bangladesh. All rights reserved.</p>
  </footer>

  <script>
    // Countdown Timer
    const countdownEl = document.getElementById("countdown-timer");
    const targetDate = new Date("July 15, 2025 10:00:00").getTime();

    setInterval(() => {
      const now = new Date().getTime();
      const distance = targetDate - now;

      if (distance <= 0) {
        countdownEl.innerText = "🟢 Voting is open!";
      } else {
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        countdownEl.innerText = `${days}d ${hours}h ${minutes}m ${seconds}s`;
      }
    }, 1000);
  </script>
</body>
</html>
