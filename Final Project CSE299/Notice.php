<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Notice - National Voting Portal</title>
  <link rel="stylesheet" href="style-notice.css" />
  <style>
    /* Minimal CSS for dropdown and nav */
    nav ul {
      list-style: none;
      padding-left: 0;
      margin: 0;
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
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
    .dropdown-menu {
      display: none;
      position: absolute;
      background: white;
      list-style: none;
      padding: 0;
      margin: 0;
      border: 1px solid #ccc;
      z-index: 1000;
      min-width: 180px;
    }
    .dropdown-menu.show {
      display: block;
    }
    .dropdown-menu li a {
      padding: 8px 15px;
      color: #333;
    }
    .dropdown-menu li a:hover {
      background: #007bff;
      color: white;
    }
    .menu-toggle {
      display: none;
      cursor: pointer;
      font-size: 24px;
      user-select: none;
    }
    @media (max-width: 768px) {
      nav ul {
        display: none;
        flex-direction: column;
        width: 100%;
        background: #fff;
        position: absolute;
        top: 60px;
        left: 0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
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
              <li><a href="Birth_Certificate_Apply.php.php">Birth Certificate Apply</a></li>
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
  <main class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <h2 style="color:#002855; margin-bottom: 30px; font-weight: 700;">Latest Notices & Announcements</h2>

    <!-- Filter and Search -->
    <div class="filter-bar" style="margin-bottom: 20px;">
      <input type="text" id="search-input" placeholder="Search notices..." aria-label="Search notices" />
      <select id="filter-category" aria-label="Filter notices by category" style="margin-left:10px;">
        <option value="all">All Categories</option>
        <option value="election">Election Updates</option>
        <option value="registration">Registration</option>
        <option value="results">Results</option>
        <option value="general">General</option>
      </select>
    </div>

    <!-- Notices List -->
    <div id="notice-list">
      <!-- Notices will be inserted here by JS -->
    </div>

    <!-- Pagination -->
    <div class="pagination" id="pagination" style="margin-top: 20px;"></div>
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-container" style="display:flex; flex-wrap:wrap; gap:20px; padding:20px 0;">
      <div class="footer-column" style="flex:1; min-width:200px;">
        <h4>About National Voting Portal</h4>
        <p>We provide all official election-related information and services to empower voters nationwide.</p>
      </div>

      <div class="footer-column" style="flex:1; min-width:150px;">
        <h4>Quick Links</h4>
        <ul style="list-style:none; padding-left:0;">
          <li><a href="index.php">Home</a></li>
          <li><a href="Information.php">Information</a></li>
          <li><a href="Voting.php">Voting</a></li>
          <li><a href="Notice.php">Notice</a></li>
          <li><a href="Contact-Us.php">Contact Us</a></li>
        </ul>
      </div>

      <div class="footer-column" style="flex:1; min-width:200px;">
        <h4>Contact Info</h4>
        <p>123 Democracy St.</p>
        <p>Capital City, Country</p>
        <p>Email: support@nationalvoting.gov</p>
        <p>Phone: +123 456 7890</p>
      </div>

      <div class="footer-column" style="flex:1; min-width:150px;">
        <h4>Follow Us</h4>
        <div class="social-icons" style="display:flex; gap:10px;">
          <a href="#" aria-label="Facebook"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook" width="24"/></a>
          <a href="#" aria-label="Twitter"><img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" alt="Twitter" width="24"/></a>
          <a href="#" aria-label="LinkedIn"><img src="https://cdn-icons-png.flaticon.com/512/733/733561.png" alt="LinkedIn" width="24"/></a>
          <a href="#" aria-label="Instagram"><img src="https://cdn-icons-png.flaticon.com/512/733/733558.png" alt="Instagram" width="24"/></a>
        </div>
      </div>
    </div>

    <div class="footer-bottom" style="text-align:center; padding:10px; background:#f2f2f2;">
      © 2025 National Election Commission. All rights reserved.
    </div>
  </footer>

  <!-- JS Scripts -->
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

    // Notice data sample
    const notices = [
      {
        id: 1,
        title: "Election Date Announced",
        category: "election",
        date: "2025-07-15",
        description: "The general election will be held on November 3rd, 2025. Make sure to check your registration status."
      },
      {
        id: 2,
        title: "Voter Registration Deadline Extended",
        category: "registration",
        date: "2025-06-30",
        description: "Due to technical issues, the voter registration deadline has been extended until July 15th, 2025."
      },
      {
        id: 3,
        title: "Preliminary Election Results Released",
        category: "results",
        date: "2025-07-01",
        description: "Preliminary results for the recent local elections are now available on the official portal."
      },
      {
        id: 4,
        title: "Important Security Updates",
        category: "general",
        date: "2025-06-25",
        description: "All users are advised to update their passwords regularly to protect their personal information."
      },
      {
        id: 5,
        title: "Polling Stations Relocated",
        category: "election",
        date: "2025-06-20",
        description: "Several polling stations in Capital City have been relocated due to construction. Check your new voting location online."
      },
      {
        id: 6,
        title: "New ID Verification Process",
        category: "registration",
        date: "2025-06-15",
        description: "To enhance security, a new ID verification process will be implemented starting August 1st, 2025."
      },
      {
        id: 7,
        title: "Contact Center Hours Update",
        category: "general",
        date: "2025-06-10",
        description: "Our contact center will now be open from 8 AM to 8 PM on weekdays to assist voters."
      },
      {
        id: 8,
        title: "Official Voting App Released",
        category: "general",
        date: "2025-06-05",
        description: "Download the official voting app from your app store to get real-time updates and notifications."
      }
    ];

    // Pagination and filtering variables
    const noticesPerPage = 3;
    let currentPage = 1;
    let filteredNotices = [...notices];

    const noticeList = document.getElementById('notice-list');
    const pagination = document.getElementById('pagination');
    const searchInput = document.getElementById('search-input');
    const filterCategory = document.getElementById('filter-category');

    // Render notices on the page
    function renderNotices() {
      noticeList.innerHTML = '';

      const start = (currentPage - 1) * noticesPerPage;
      const end = start + noticesPerPage;
      const paginatedNotices = filteredNotices.slice(start, end);

      if(paginatedNotices.length === 0) {
        noticeList.innerHTML = '<p>No notices found.</p>';
        pagination.innerHTML = '';
        return;
      }

      paginatedNotices.forEach(notice => {
        const noticeCard = document.createElement('div');
        noticeCard.classList.add('notice-card');
        noticeCard.style.border = '1px solid #ccc';
        noticeCard.style.padding = '15px';
        noticeCard.style.marginBottom = '15px';
        noticeCard.style.borderRadius = '5px';
        noticeCard.style.backgroundColor = '#f9f9f9';

        noticeCard.innerHTML = `
          <h3>${notice.title}</h3>
          <p><strong>Date:</strong> ${notice.date}</p>
          <p><strong>Category:</strong> ${capitalize(notice.category)}</p>
          <p>${notice.description}</p>
        `;
        noticeList.appendChild(noticeCard);
      });

      renderPagination();
    }

    // Render pagination buttons
    function renderPagination() {
      pagination.innerHTML = '';
      const pageCount = Math.ceil(filteredNotices.length / noticesPerPage);

      for(let i = 1; i <= pageCount; i++) {
        const btn = document.createElement('button');
        btn.textContent = i;
        btn.style.marginRight = '5px';
        btn.style.padding = '5px 10px';
        btn.style.cursor = 'pointer';
        if(i === currentPage) {
          btn.style.backgroundColor = '#007bff';
          btn.style.color = '#fff';
          btn.style.border = 'none';
          btn.disabled = true;
        } else {
          btn.style.backgroundColor = '#f0f0f0';
          btn.style.border = '1px solid #ccc';
        }
        btn.addEventListener('click', () => {
          currentPage = i;
          renderNotices();
          window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        pagination.appendChild(btn);
      }
    }

    // Search and filter notices
    function filterNotices() {
      const searchText = searchInput.value.toLowerCase();
      const category = filterCategory.value;

      filteredNotices = notices.filter(notice => {
        const matchesSearch = notice.title.toLowerCase().includes(searchText) ||
                              notice.description.toLowerCase().includes(searchText);

        const matchesCategory = category === 'all' ? true : notice.category === category;

        return matchesSearch && matchesCategory;
      });

      currentPage = 1;
      renderNotices();
    }

    // Utility function to capitalize first letter
    function capitalize(text) {
      return text.charAt(0).toUpperCase() + text.slice(1);
    }

    // Event listeners for search and filter
    searchInput.addEventListener('input', filterNotices);
    filterCategory.addEventListener('change', filterNotices);

    // Initial render
    renderNotices();
  </script>
</body>
</html>
