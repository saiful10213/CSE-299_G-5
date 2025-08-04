<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Information | National Voting Portal</title>
  <link rel="stylesheet" href="style-information.css" />
</head>
<body>
  <!-- Header -->
  <header>
    <div class="container">
      <div class="logo">
        <h1>National Voting Portal</h1>
      </div>
      <nav>
        <div class="menu-toggle" id="menu-toggle">&#9776;</div>
        <ul class="nav-links" id="nav-links">
          <li><a href="index.php">Home</a></li>
          <li class="dropdown">
            <a href="#" id="services-btn">Services ▾</a>
            <ul class="dropdown-menu" id="dropdown-menu">
              <li><a href="NID_Card_Application.php">NID Card Apply</a></li>
              <li><a href="NID_Card_Download.php">NID Card Print</a></li>
              <li><a href="Services-Card-Correction.php">NID Card Correction</a></li>
              <li><a href="Birth_Certificate_Apply.php">Birth Certificate Apply</a></li>
              <li><a href="Birth_Certificate_Print.php">Birth Certificate Print</a></li>
              <li><a href="Birth_certificate_correction.php">Birth Certificate Correction</a></li>
            </ul>
          </li>
          <li><a href="Information.php">Information</a></li>
          <li><a href="Live_votin_count.php">Voting Count</a></li>
          <li><a href="Notice.php">Notice</a></li>
          <li><a href="Queries.php">Queries</a></li>
          <li><a href="Contact-Us.php">Contact Us</a></li>
          <li><a href="Voting_login.php">Log In</a></li>
          <li><a href="Voting_signup.php">Sign Up</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="info-section container">
    <h2>General Information About Voting</h2>

    <section>
      <h3>What is Electronic Voting?</h3>
      <p>
        Electronic voting (e-voting) is a modern method of casting and counting votes using electronic systems.
        It improves accessibility, security, and transparency while reducing human error. Through our National Voting Portal,
        voters can participate in elections using secure digital platforms from the comfort of their homes or authorized voting centers.
      </p>
    </section>

    <section>
      <h3>Who Can Vote?</h3>
      <ul>
        <li>Must be a citizen of Bangladesh</li>
        <li>Must be at least 18 years of age on the day of the election</li>
        <li>Must have a valid NID (National ID)</li>
        <li>Must be registered on the National Voter List</li>
      </ul>
    </section>

    <section>
      <h3>Voting Schedule & Time</h3>
      <p>
        The next national election will take place on <strong>December 30, 2025</strong>. Voting hours are:
      </p>
      <ul>
        <li><strong>Start Time:</strong> 8:00 AM</li>
        <li><strong>End Time:</strong> 4:00 PM</li>
        <li><strong>Break:</strong> No breaks; continuous polling throughout the day</li>
      </ul>
      <p>Please check your division or district-specific timing via the Notice section before election day.</p>
    </section>

    <section>
      <h3>Participating Political Parties</h3>
      <ul>
        <li>Bangladesh Awami League (AL)</li>
        <li>Bangladesh Nationalist Party (BNP)</li>
        <li>Jatiya Party (JP)</li>
        <li>Workers Party of Bangladesh</li>
        <li>Gono Forum</li>
        <li>Islami Andolan Bangladesh</li>
        <li>Independent Candidates</li>
        <li>Other registered political entities</li>
      </ul>
    </section>

    <section>
      <h3>How to Vote</h3>
      <ol>
        <li>Log in using your NID number and password</li>
        <li>Verify your identity using OTP sent to your registered mobile</li>
        <li>Select your preferred candidate or party</li>
        <li>Review your selection and confirm</li>
        <li>Submit your vote — it is recorded and encrypted</li>
      </ol>
      <p><em>Note: Votes can only be submitted once per voter ID.</em></p>
    </section>

    <section>
      <h3>Your Rights as a Voter</h3>
      <ul>
        <li>The right to vote freely and securely</li>
        <li>The right to accurate information</li>
        <li>The right to file a complaint if you face any issues</li>
        <li>The right to privacy while voting</li>
        <li>The right to accessibility support if required</li>
      </ul>
    </section>

    <section>
      <h3>Security Measures</h3>
      <p>
        The system is secured using multi-factor authentication, end-to-end encryption, and blockchain-based vote recording.
        All servers are monitored in real time, and no voter data is shared with third parties.
        Any attempts of tampering are logged and reported instantly.
      </p>
    </section>

    <section>
      <h3>Help & Support</h3>
      <p>
        If you encounter technical issues or need clarification about any voting procedure, please contact our support team:
      </p>
      <ul>
        <li>Email: support@nationalvoting.gov</li>
        <li>Hotline: 1234 (available 24/7)</li>
        <li>Live Chat: Visit the <a href="Contact-Us.html">Contact Us</a> page</li>
      </ul>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-container container">
      <div class="footer-column">
        <h4>About</h4>
        <p>The National Voting Portal provides secure and accessible services for all citizens to participate in the democratic process through digital means.</p>
      </div>
      <div class="footer-column">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="Voting.html">Vote Now</a></li>
          <li><a href="Services-NID-Card-Apply.html">Apply for NID</a></li>
          <li><a href="Contact-Us.html">Contact Us</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h4>Contact</h4>
        <p>Email: support@nationalvoting.gov</p>
        <p>Hotline: 1234 (24/7)</p>
        <p>Address: Election Commission, Dhaka, Bangladesh</p>
      </div>
      <div class="footer-column">
        <h4>Follow Us</h4>
        <div class="social-icons">
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/24/733/733547.png" alt="Facebook"></a>
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/24/733/733579.png" alt="Twitter"></a>
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/24/733/733558.png" alt="Instagram"></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2025 National Election Commission. All rights reserved.</p>
    </div>
  </footer>

  <!-- JS -->
  <script>
    const toggle = document.getElementById('menu-toggle');
    const navLinks = document.getElementById('nav-links');
    toggle.addEventListener('click', () => {
      navLinks.classList.toggle('active');
    });

    const servicesBtn = document.getElementById('services-btn');
    const dropdownMenu = document.getElementById('dropdown-menu');
    servicesBtn.addEventListener('click', (e) => {
      e.preventDefault();
      dropdownMenu.classList.toggle('show');
    });

    document.addEventListener('click', (e) => {
      if (!servicesBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
        dropdownMenu.classList.remove('show');
      }
    });
  </script>
</body>
</html>
