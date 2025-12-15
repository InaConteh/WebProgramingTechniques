# LionSport Agency - Football Management System

Welcome to the **LionSport Agency** project (Group 2 Final Project). This is a comprehensive web-based platform designed to bridge the gap between talented football players and global opportunities.

## 🌟 Project Overview

This system serves as a digital hub for a modern football agency, allowing:

- **Players** to showcase their profiles, stats, and videos.
- **Agents & Managers** to scout talent and manage contracts.
- **Administrators** to oversee the entire platform, manage users, and handle inquiries.

## 🚀 Features

### Public Features

- **Dynamic Hero Section:** Immersive 3D animations, particle effects, and live stat counters.
- **Player Directory:** Browse player profiles with filters for position, country, and status.
- **About Us:** Meet the team and learn about the agency's mission.
- **Contact Form:** Integrated inquiry system connecting directly to the admin panel.

### User Features (Registered)

- **Player Profiles:** Detailed bios, transfer values, position info, and video highlights.
- **Contract Management:** View active contracts, expiry dates, and salary info.
- **Video Gallery:** Upload and embed match highlights.

### Admin Features

- **Dashboard:** Overview of system stats.
- **User Management:** Add/Edit/Delete users (Agents, Players, Managers).
- **Player Management:** Full CRUD operations for player records.
- **Contact Inquiries:** View and manage messages from the contact page.
- **Contract Oversight:** Manage negotiation status and terms.

## 🛠️ Installation & Setup

### Prerequisites

- **XAMPP** (or any PHP/MySQL environment)
- **Web Browser** (Chrome/Edge/Firefox)

### Step-by-Step Guide

1.  **Clone/Download** the repository to your server directory (e.g., `htdocs`).

    ```bash
    git clone https://github.com/InaConteh/Group-2-Final-Project-WebProgramming-Techiques.git
    ```

2.  **Database Setup:**

    - Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
    - Create a new database named `football_agency_db`.
    - Import the `schema.sql` file provided in the project folder.
    - (Optional) Run `seed_data.php` to populate with initial test data.

3.  **Configuration:**

    - Open `db_connect.php` and check your database credentials:
      ```php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "football_agency_db";
      ```

4.  **Run the Project:**
    - Start Apache and MySQL in XAMPP.
    - Visit: `http://localhost/Group-2-Final-Project-WebProgramming-Techiques/`

## 🔐 User Roles & Credentials

The system supports multiple user roles with distinct permissions. Use these default accounts for testing:

### 1. Super Admin (Full Access)

- **Email:** `admin@agency.com`
- **Password:** `AdminSecret123!`
- **Capabilities:** Manage all users, delete records, view all contracts, manage contact submissions.

### 2. Agent (Talent Management)

- **Email:** `agent@agency.com`
- **Password:** `AgentPass123!`
- **Capabilities:** View multiple players, propose contracts, update player status.

### 3. Club Manager (Scouting)

- **Email:** `manager@club.com`
- **Password:** `ManagerPass123!`
- **Capabilities:** Browse listings, place bids, view limited contract info.

### 4. Player (Individual Access)

- **Email:** _Created upon registration_
- **Capabilities:** Edit own profile, view personal contract status.

## 📝 Usage Guide

### How to Register

1.  Click **"Login"** in the navigation bar.
2.  Select **"Register here"**.
3.  Fill in your details (Name, Email, Password).
4.  Default role is "User/Player" until promoted by an Admin.

### How to Add a Player (Admin)

1.  Log in as **Admin**.
2.  Navigate to **Players** page.
3.  Click **"Add New Player"**.
4.  Fill in bio, stats, market value, and upload a photo.

### How to Manage Contacts

1.  Log in as **Admin**.
2.  Go to the **Contact** page (Admin view active).
3.  You will see a table of all messages sent via the public contact form.
4.  You can mark them as read or delete them.

## 📂 Project Structure

- `index.php` - Homepage with dynamic stats.
- `players.php` - Player directory and search.
- `contract.php` - Contract details and negotiations.
- `admin_contacts.php` - Admin panel for inquiries.
- `db_connect.php` - Database connection settings.
- `enhanced-hero.css` - Special styles for the animated hero section.
- `main.js` - Frontend logic for animations and interactions.

---

**Developed by Group 2**  
_Web Programming Techniques Final Project_
