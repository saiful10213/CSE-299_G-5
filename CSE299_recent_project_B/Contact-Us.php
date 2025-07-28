<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us | National Voting Portal</title>
  <link rel="stylesheet" href="style-contact-us.css" />
  <link rel="stylesheet" href="style-header_footer.css">
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

  <!-- Contact Form Section -->
  <section class="contact-section">
    <div class="container">
      <h2>Contact Us</h2>
      <p>If you have any questions, suggestions, or issues, feel free to reach out to us using the form below.</p>
      <form id="contact-form">
        <div class="form-group">
          <label for="name">Full Name:</label>
          <input type="text" id="name" name="name" required placeholder="Your name" />
        </div>
        <div class="form-group">
          <label for="email">Email Address:</label>
          <input type="email" id="email" name="email" required placeholder="you@example.com" />
        </div>
        <div class="form-group">
          <label for="subject">Subject:</label>
          <input type="text" id="subject" name="subject" required placeholder="Subject of your message" />
        </div>
        <div class="form-group">
          <label for="message">Your Message:</label>
          <textarea id="message" name="message" rows="5" required placeholder="Type your message here..."></textarea>
        </div>
        <button type="submit" class="btn">Send Message</button>
        <p id="form-status"></p>
      </form>
    </div>
  </section>

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
    // Mobile menu toggle
    const toggle = document.getElementById('menu-toggle');
    const navLinks = document.getElementById('nav-links');
    toggle.addEventListener('click', () => {
      navLinks.classList.toggle('active');
    });

    // Services dropdown toggle
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

    // Contact Form JS (Mock Submission)
    document.getElementById('contact-form').addEventListener('submit', function (e) {
      e.preventDefault();
      const status = document.getElementById('form-status');
      status.textContent = 'Sending...';

      // Simulate async sending
      setTimeout(() => {
        status.textContent = 'Your message has been sent successfully!';
        status.style.color = 'limegreen';
        this.reset();
      }, 1500);
    });
  </script>
</body>
</html>
