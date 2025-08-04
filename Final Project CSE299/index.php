<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>National Voting Portal</title>
  <link rel="stylesheet" href="style_homepage.css" />
  <style>
    /* Minimal dropdown styling to support your menu */
    .dropdown-menu {
      display: none;
      position: absolute;
      background: white;
      list-style: none;
      padding: 0;
      margin: 0;
      border: 1px solid #ccc;
      z-index: 1000;
    }
    .dropdown-menu.show {
      display: block;
    }
    .dropdown-menu li a {
      display: block;
      padding: 8px 15px;
      color: #333;
      text-decoration: none;
    }
    .dropdown-menu li a:hover {
      background: #007bff;
      color: white;
    }
    nav ul {
      list-style: none;
      padding-left: 0;
      margin: 0;
      display: flex;
      gap: 15px;
    }
    nav li {
      position: relative;
    }
    nav a {
      text-decoration: none;
      color: #333;
      padding: 10px;
      display: block;
    }
    nav a:hover {
      color: #007bff;
    }
    .menu-toggle {
      display: none; /* For mobile menu - you can style as needed */
      cursor: pointer;
      font-size: 24px;
    }
    @media (max-width: 768px) {
      nav ul {
        display: none;
        flex-direction: column;
      }
      nav ul.active {
        display: flex;
      }
      .menu-toggle {
        display: block;
      }
    }
  </style>
</head>
<body>
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
              <li><a href="NID_Card_Correction.php">NID Card Correction</a></li>
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

  <section class="hero">
    <div class="container">
      <h2>Your Voice. Your Vote. Your Future.</h2>
      <p>Register, check your status, and find all election resources here.</p>
      <a href="birth_signup.php" class="btn">Register Now</a>
    </div>
  </section>

  <footer>
    <div class="footer-container container" style="display:flex; flex-wrap:wrap; gap:20px; padding:20px 0;">
      <div class="footer-column" style="flex:1; min-width:200px;">
        <h4>About</h4>
        <p>The National Voting Portal provides secure and accessible services for all citizens to participate in the democratic process through digital means.</p>
      </div>
      <div class="footer-column" style="flex:1; min-width:150px;">
        <h4>Quick Links</h4>
        <ul style="list-style:none; padding-left:0;">
          <li><a href="index.php">Home</a></li>
          <li><a href="Voting.php">Vote Now</a></li>
          <li><a href="NID_Card_Application.php">Apply for NID</a></li>
          <li><a href="Contact-Us.php">Contact Us</a></li>
        </ul>
      </div>
      <div class="footer-column" style="flex:1; min-width:200px;">
        <h4>Contact</h4>
        <p>Email: support@nationalvoting.gov</p>
        <p>Hotline: 1234 (24/7)</p>
        <p>Address: Election Commission, Dhaka, Bangladesh</p>
      </div>
      <div class="footer-column" style="flex:1; min-width:150px;">
        <h4>Follow Us</h4>
        <div class="social-icons" style="display:flex; gap:10px;">
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/24/733/733547.png" alt="Facebook"></a>
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/24/733/733579.png" alt="Twitter"></a>
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/24/733/733558.png" alt="Instagram"></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom" style="text-align:center; padding:10px; background:#f2f2f2;">
      <p>© 2025 National Election Commission. All rights reserved.</p>
    </div>
  </footer>

  <script>
    // Toggle mobile menu
    const toggle = document.getElementById('menu-toggle');
    const navLinks = document.getElementById('nav-links');
    toggle.addEventListener('click', () => {
      navLinks.classList.toggle('active');
    });

    // Toggle Services dropdown on click
    const servicesBtn = document.getElementById('services-btn');
    const dropdownMenu = document.getElementById('dropdown-menu');

    servicesBtn.addEventListener('click', (e) => {
      e.preventDefault(); // Prevent link click
      dropdownMenu.classList.toggle('show');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!servicesBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
        dropdownMenu.classList.remove('show');
      }
    });
  </script>
</body>
</html>
