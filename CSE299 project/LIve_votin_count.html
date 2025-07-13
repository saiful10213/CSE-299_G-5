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
    const partyNames = {
      "1": "NCP",
      "2": "BNP",
      "3": "JAMAT",
      "4": "National Party"
    };

    const partyListDiv = document.getElementById('partyList');
    const noVotesMsg = document.getElementById('noVotesMsg');

    // Create GUI rows initially
    function createPartyRows() {
      partyListDiv.innerHTML = '';
      for (const id in partyNames) {
        const row = document.createElement('div');
        row.className = 'party-row';
        row.dataset.id = id;

        const name = document.createElement('div');
        name.className = 'party-name';
        name.textContent = partyNames[id];

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

    function updateVotes() {
      const votes = JSON.parse(localStorage.getItem("votes")) || {};
      const total = Object.values(votes).reduce((a, b) => a + b, 0);

      if (total === 0) {
        noVotesMsg.style.display = 'block';
      } else {
        noVotesMsg.style.display = 'none';
      }

      document.querySelectorAll('.party-row').forEach(row => {
        const id = row.dataset.id;
        const count = votes[id] || 0;
        const percent = total ? (count / total) * 100 : 0;

        row.querySelector('.bar-fill').style.width = percent + "%";
        row.querySelector('.vote-count').textContent = count;
      });
    }

    // Setup
    createPartyRows();
    updateVotes();

    // Auto-update every 2 seconds
    setInterval(updateVotes, 2000);
  </script>
</body>
</html>
