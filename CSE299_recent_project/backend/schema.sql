-- Create the database (if not exists)
CREATE DATABASE IF NOT EXISTS evoting CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE evoting;

-- USERS: for login/registration
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  mobile VARCHAR(20) UNIQUE NOT NULL,
  password_hash VARCHAR(128) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- NID applications
CREATE TABLE nid_applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  front_image_url VARCHAR(255),
  back_image_url VARCHAR(255),
  status ENUM('pending','verified','rejected') DEFAULT 'pending',
  applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Birth certificates
CREATE TABLE birth_applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  status ENUM('pending','verified','rejected') DEFAULT 'pending',
  applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Candidates & Votes
CREATE TABLE candidates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  party VARCHAR(100),
  manifesto TEXT
);

CREATE TABLE votes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  candidate_id INT NOT NULL,
  voted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (candidate_id) REFERENCES candidates(id),
  UNIQUE KEY (user_id)
);

-- Notices
CREATE TABLE notices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200),
  body TEXT,
  posted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- FAQs / Queries
CREATE TABLE faqs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  question TEXT,
  answer TEXT,
  posted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contacts
CREATE TABLE contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  message TEXT,
  sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

---------------------------------------------------------------------
CREATE TABLE nid (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nid_number VARCHAR(20) UNIQUE,
    full_name VARCHAR(100),
    father_name VARCHAR(100),
    mother_name VARCHAR(100),
    dob DATE,
    correction_type VARCHAR(100)
);

CREATE TABLE birth_certificate (
    id INT AUTO_INCREMENT PRIMARY KEY,
    form_no VARCHAR(50),
    child_name VARCHAR(100),
    father_name VARCHAR(100),
    mother_name VARCHAR(100),
    dob DATE,
    house_no VARCHAR(20),
    road_no VARCHAR(20),
    road_name VARCHAR(100),
    village_name VARCHAR(100),
    word_no VARCHAR(20),
    union_name VARCHAR(100),
    thana VARCHAR(100),
    post_office VARCHAR(100),
    district VARCHAR(100),
    division VARCHAR(100),
    nationality VARCHAR(50),
    issue_date DATE,
    issued_by VARCHAR(100),
    chairman_signature TEXT,
    parent_signature TEXT
);

CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nid_number VARCHAR(20) UNIQUE,
    party ENUM('Bangladesh Awami League', 'Bangladesh Nationalist Party (BNP)', 'Jatiya Party', 'Workers Party of Bangladesh', 'Independent')
);
