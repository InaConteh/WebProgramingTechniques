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

### Recent Features Added

- **Dynamic Contract Visualization:** Contract details are now dynamically pulled from the database, featuring contract dates, market value, and status.
- **Enhanced Agent Dashboard:** Agents can now manage their own dedicated list of players, update their stats, and monitor contract statuses in real-time.
- **Club Manager Bidding System:** Club managers can now place formal bids on players directly through the platform.
- **Video Highlight Integration:** Support for both YouTube/Vimeo embeds and direct MP4 video uploads for player highlights.
- **Role-Based Access Control:** Strict permissioning for Admin, Agent, Club Manager, and Player roles.

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
- **Role:** `admin`

### 2. Agent (Talent Management)

- **Email:** `agent@agency.com`
- **Password:** `AgentPass123!`
- **Role:** `agent`

### 3. agent(Scouting)

- **Email:** 'sahidconteh@gmail.com'
- **Password:** `password123`
- **Role:** `Agent`

### 4. Club Manager (Scouting)

- **Email:** 'MarkEllie@gmail.com'
- **Password:** `1234`
- **Role:** `manager`

### 5. Player (Individual Access)

- **Email:** _Created upon registration_
- **Role:** `player`

## 📂 Project Structure

```text
/Group-2-Final-Project-WebProgramming-Techiques
│
├── admin_contacts.php     # Admin view for contact messages
├── admin_setup.php        # Script to initialize admin account
├── admin_users.php        # Manage Agents, Managers, and Admins
├── agent.php              # Agent-specific dashboard
├── add_player.php         # Admin/Agent tool to add players
├── edit_player.php        # Admin/Agent tool to modify players
├── manager.php            # Club Manager-specific dashboard
├── players.php            # Public and private player directory
├── contract.php           # Dynamic player contract view
├── place_bid.php          # Bidding logic for Club Managers
├── db_connect.php         # Central database connection
├── header.php             # Global navigation and branding
├── footer.php             # Global site footer
├── index.php              # Landing page with hero section
├── login.php              # Authentication entry
├── register.php           # User signup logic
├── logout.php             # Session termination
├── style.css              # Main design stylesheet
├── enhanced-hero.css      # Hero-specific animations
├── main.js                # Frontend interactivity
├── schema.sql             # Database structure definition
├── seed_data.php          # Demo data populations
├── images/                # Visual assets (logos, icons)
└── uploads/               # User-uploaded content (player photos/videos)
```

---

**Developed by Group 2**  
_Web Programming Techniques Final Project_
