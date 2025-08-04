<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Queries - National Voting Portal</title>
  <link rel="stylesheet" href="style-queries.css" />
  <style>
    /* Minimal style fix for dropdown */
    .dropdown-menu {
      display: none;
      position: absolute;
      background: white;
      list-style: none;
      padding: 10px 0;
      margin: 0;
      box-shadow: 0 2px 5px rgba(0,0,0,0.15);
      border-radius: 4px;
      z-index: 1000;
    }
    .dropdown-menu.show {
      display: block;
    }
    .dropdown:hover .dropdown-menu {
      display: block;
    }
    .nav-links li {
      position: relative;
    }
    /* Mobile menu styles */
    @media (max-width: 768px) {
      .nav-links {
        display: none;
        flex-direction: column;
      }
      .nav-links.active {
        display: flex;
      }
      .dropdown-menu {
        position: static;
        box-shadow: none;
        background: none;
      }
    }
  </style>
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
  <main class="container" style="margin: 50px auto 80px;">
    <h2 style="color:#002855; font-weight:700; margin-bottom: 40px;">Frequently Asked Questions (FAQs)</h2>

    <section class="faq-section">
      <article class="faq-item">
        <h3 class="question">1. Who is eligible to vote in national elections?</h3>
        <p class="answer">Any citizen aged 18 or older with a valid National ID Card (NID) registered with the election commission is eligible to vote.</p>
      </article>

      <article class="faq-item">
        <h3 class="question">2. How do I register to vote?</h3>
        <p class="answer">You must apply for a National ID Card if you do not have one. Registration information is linked to your NID and can be verified on our portal.</p>
      </article>

      <article class="faq-item">
        <h3 class="question">3. How can I check my voter registration status?</h3>
        <p class="answer">Use the "NID Card Status" service on our website or contact your local election office to verify your voter registration details.</p>
      </article>

      <article class="faq-item">
        <h3 class="question">4. What documents do I need to apply for a National ID card?</h3>
        <p class="answer">You need your birth certificate, proof of residence, and recent photographs. Visit the NID Card Apply section for detailed requirements.</p>
      </article>

      <article class="faq-item">
        <h3 class="question">5. Can I vote if I have lost my NID card?</h3>
        <p class="answer">If your NID card is lost, you should apply for a replacement immediately. Voting is only permitted with a valid NID card or an approved provisional document.</p>
      </article>

      <article class="faq-item">
        <h3 class="question">6. What are the voting hours on election day?</h3>
        <p class="answer">Polling stations are open from 8:00 AM to 5:00 PM. Please arrive early to avoid long queues.</p>
      </article>

      <article class="faq-item">
        <h3 class="question">7. How can I find my designated polling station?</h3>
        <p class="answer">Polling station details are available when you check your voter status on the portal or on your voter card issued prior to the election.</p>
      </article>

      <article class="faq-item">
        <h3 class="question">8. Is early or absentee voting available?</h3>
        <p class="answer">Currently, early and absentee voting are available only for certain eligible groups. Check the Information page for the latest updates.</p>
      </article>

      <article class="faq-item">
        <h3 class="question">9. How can I report election-related issues or irregularities?</h3>
        <p class="answer">You can report any concerns through the "Queries" or "Contact Us" pages on this site, or directly contact your local election commission office.</p>
      </article>

      <article class="faq-item">
        <h3 class="question">10. What measures are in place to ensure election security and fairness?</h3>
        <p class="answer">The National Election Commission employs strict protocols, including voter verification, secure ballot handling, and independent observers to maintain transparency and fairness.</p>
      </article>

      <article class="faq-item">
        <h3 class="question">11. Can I update my personal information if it has changed?</h3>
        <p class="answer">Yes, you can apply for correction of your NID card details via the "NID Card Correction" service before the election.</p>
      </article>

      <article class="faq-item">
        <h3 class="question">12. How do I know the results of the election?</h3>
        <p class="answer">Election results are published on the "Voting Count" page of this portal and also announced by the National Election Commission through official channels.</p>
      </article>

      <article class="faq-item">
        <h3 class="question">13. Who can I contact if I have questions not covered here?</h3>
        <p class="answer">Please visit our "Contact Us" page or send your queries through the "Queries" section for personalized assistance.</p>
      </article>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <div class="container footer-container">
      <div class="footer-column">
        <h4>About National Voting Portal</h4>
        <p>We provide all official election-related information and services to empower voters nationwide.</p>
      </div>

      <div class="footer-column">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="Information.php">Information</a></li>
          <li><a href="Voting.php">Voting</a></li>
          <li><a href="Notice.php">Notice</a></li>
          <li><a href="Contact-Us.php">Contact Us</a></li>
        </ul>
      </div>

      <div class="footer-column">
        <h4>Contact Info</h4>
        <p>Email: support@nationalvoting.gov</p>
        <p>Phone: +123 456 7890</p>
        <p>Address: 123 Election St., Capital City</p>
      </div>

      <div class="footer-column social-icons">
        <h4>Follow Us</h4>
        <a href="#" aria-label="Facebook"><img src="icons/facebook.svg" alt="Facebook" /></a>
        <a href="#" aria-label="Twitter"><img src="icons/twitter.svg" alt="Twitter" /></a>
        <a href="#" aria-label="Instagram"><img src="icons/instagram.svg" alt="Instagram" /></a>
      </div>
    </div>
    <div class="footer-bottom">
      © 2025 National Election Commission. All rights reserved.
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
      e.preventDefault();
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
