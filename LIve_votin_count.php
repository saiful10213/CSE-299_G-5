<?php
include 'db.php';  // Connect to DB and define $conn

// Fetch vote counts grouped by party name
$sql = "SELECT voted_party, COUNT(*) AS total_votes FROM votes GROUP BY voted_party";
$result = $conn->query($sql);

$votes = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $votes[$row['voted_party']] = (int)$row['total_votes'];
    }
}

// If AJAX request, return votes as JSON
if (isset($_GET['action']) && $_GET['action'] === 'get_votes') {
    header('Content-Type: application/json');
    echo json_encode($votes);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Live Vote Count</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #e0f7fa, #ffffff);
      padding: 40px 20px;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
    }
    .container {
      background: white;
      padding: 30px 40px;
      border-radius: 18px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
      max-width: 800px;
      width: 100%;
    }
    h2 {
      text-align: center;
      color: #00695c;
      margin-bottom: 40px;
      font-size: 32px;
      font-weight: bold;
    }
    .party-row {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      padding: 12px 20px;
      background: #f1f8f9;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .party-name {
      flex: 0 0 180px;
      font-size: 18px;
      font-weight: 600;
      color: #004d40;
    }
    .bar-container {
      flex: 1;
      background: #cfd8dc;
      border-radius: 10px;
      overflow: hidden;
      height: 24px;
      margin: 0 15px;
    }
    .bar-fill {
      height: 100%;
      width: 0;
      background: linear-gradient(to right, #009688, #4db6ac);
      border-radius: 10px 0 0 10px;
      transition: width 0.5s ease;
    }
    .vote-count {
      width: 50px;
      text-align: right;
      font-size: 16px;
      font-weight: bold;
      color: #00796b;
    }
    #noVotesMsg {
      text-align: center;
      margin-top: 30px;
      font-size: 20px;
      color: #888;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Live Voting Results</h2>
    <div id="partyList"></div>
    <div id="noVotesMsg">No votes have been cast yet.</div>
  </div>

  <script>
    // Map between party names and display labels
    const partyNames = {
      "Awami League": "Awami League",
      "BNP": "BNP",
      "Jatiya Party": "Jatiya Party",
      "Workers Party": "Workers Party",
      "Independent": "Independent"
    };

    const partyListDiv = document.getElementById('partyList');
    const noVotesMsg = document.getElementById('noVotesMsg');

    // Build UI rows for parties
    function createPartyRows() {
      partyListDiv.innerHTML = '';
      for (const party in partyNames) {
        const row = document.createElement('div');
        row.className = 'party-row';
        row.dataset.party = party;

        const name = document.createElement('div');
        name.className = 'party-name';
        name.textContent = partyNames[party];

        const barContainer = document.createElement('div');
        barContainer.className = 'bar-container';

        const barFill = document.createElement('div');
        barFill.className = 'bar-fill';
        barContainer.appendChild(barFill);

        const count = document.createElement('div');
        count.className = 'vote-count';
        count.textContent = '0';

        row.appendChild(name);
        row.appendChild(barContainer);
        row.appendChild(count);
        partyListDiv.appendChild(row);
      }
    }

    // Update UI with vote counts
    function updateVotesUI(votes) {
      const totalVotes = Object.values(votes).reduce((sum, val) => sum + val, 0);
      noVotesMsg.style.display = totalVotes > 0 ? 'none' : 'block';

      document.querySelectorAll('.party-row').forEach(row => {
        const party = row.dataset.party;
        const count = votes[party] || 0;
        const percent = totalVotes ? (count / totalVotes) * 100 : 0;

        row.querySelector('.bar-fill').style.width = percent + '%';
        row.querySelector('.vote-count').textContent = count;
      });
    }

    // Fetch votes via AJAX
    async function fetchVotes() {
      try {
        const response = await fetch('?action=get_votes');
        if (response.ok) {
          const voteData = await response.json();
          updateVotesUI(voteData);
        } else {
          console.error('Failed to fetch votes');
        }
      } catch (error) {
        console.error('Error fetching votes:', error);
      }
    }

    // Initial setup
    createPartyRows();
    fetchVotes();
    setInterval(fetchVotes, 2000); // auto refresh every 2s
  </script>
</body>
</html>
