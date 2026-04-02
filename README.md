# 🎓 Student Attendance Portal

A full-stack, fully mobile-responsive web application for managing student attendance across subjects, built with **PHP (MVC)**, **MySQL**, and **Bootstrap 5**. Supports role-based access for **Admins**, **Teachers**, and **Students**.

---

## ✨ Features

### 🔐 Role-Based Access Control
| Role | Capabilities |
|---|---|
| **Admin** | Manage students, teachers, subjects, and enrollments |
| **Teacher** | Mark session attendance, view reports, export CSV |
| **Student** | View personal attendance history with subject filtering |

### 📱 Responsive Design
- 100% Mobile, Tablet, and Desktop compatible.
- Optimized touch-friendly tables and scaling typography.
- Sidebars and navbars seamlessly collapse on smaller screens.

### 📋 Admin Panel
- Add / Edit / Delete students with full profile (PRN, Faculty, Program, Year, Semester, Division)
- Manage teachers and assign them to subjects
- Enroll / de-enroll students from subjects
- View attendance reports per subject

### 🧑‍🏫 Teacher Dashboard
- Summary cards: assigned subjects, enrolled students, last session activity
- Mark attendance with **date** and **12-hour AM/PM time picker**
- Smart form: reloads pre-filled data when switching date/time sessions (supports multiple sessions per day)
- View detailed per-subject attendance report
- Export attendance as **CSV** (includes date & time in 12-hour format)

### 🎓 Student Dashboard
- Profile header: PRN, Name, Semester & Year at a glance
- Overall attendance percentage with visual indicator
- Subject-wise breakdown with session counts
- **Attendance History Table** with subject filter & live Present/Absent counters

---

## 🗂️ Project Structure

```
student-attendance-portal/
├── app/
│   ├── config/
│   │   ├── constants.php          # ← NOT committed (contains credentials)
│   │   ├── constants.example.php  # ← Copy this and rename to constants.php
│   │   ├── database.php           # PDO singleton
│   │   └── session.php            # Secure session handler
│   ├── controllers/
│   │   ├── AdminController.php
│   │   ├── AttendanceController.php  # AJAX API endpoint
│   │   ├── AuthController.php
│   │   ├── StudentController.php
│   │   └── TeacherController.php
│   ├── models/
│   │   ├── AttendanceModel.php
│   │   └── StudentModel.php
│   ├── views/
│   │   ├── admin/
│   │   ├── auth/
│   │   ├── layouts/               # header.php & footer.php
│   │   ├── student/
│   │   └── teacher/
│   └── helpers/
│       └── Validator.php
├── database/
│   ├── schema.sql                 # Full database schema (run this first)
│   ├── seed.sql                   # Optional demo seed data
│   └── migrations/                # Incremental DB changes
├── public/
│   ├── index.php                  # Front controller / router
│   ├── .htaccess                  # URL rewriting rules
│   └── assets/                    # CSS, JS, images
├── .htaccess                      # Root redirect to public/
├── .gitignore
└── README.md
```

---

## 🚀 Easy Installation Guide (For Beginners)

Don't worry if you're not super technical! Just follow these steps:

### Step 1: Install XAMPP
1. Download and install [XAMPP](https://www.apachefriends.org/index.html) for Windows.
2. Open the **XAMPP Control Panel** and start both **Apache** and **MySQL**.

### Step 2: Download the Project
1. Download this project as a ZIP file (click the green "Code" button at the top, then "Download ZIP"), OR use Git:
   ```bash
   git clone https://github.com/Akram-X207/student-attendance-portal.git
   ```
2. Extract or move the `student-attendance-portal` folder into your XAMPP's `htdocs` directory. This is usually located at:
   `C:\xampp\htdocs\student-attendance-portal\`

### Step 3: Setup the Database
1. Open your browser and go to: [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)
2. Click **New** on the left side to create a database. Name it exactly: `attendance_portal`, then click **Create**.
3. Select your new `attendance_portal` database, click the **Import** tab at the top.
4. Click **Choose File** and select the `database/schema.sql` file from the project folder. Click **Import** at the bottom.
5. *(Optional but recommended)* Repeat the import step for the `database/seed.sql` file to load dummy data (students, teachers, etc.) so you can test it right away!

### Step 4: Configure the Project
1. Go into the `app/config/` folder inside the project.
2. Find the file named `constants.example.php`.
3. Copy it and rename the copy to `constants.php`.
4. Open your new `constants.php` file in any text editor (like Notepad).
5. Ensure the database settings match (by default, XAMPP uses `root` for the user and leaves the password blank):
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'attendance_portal');
   ```

### Step 5: You're Done! 🎉
Open your browser and go to:
[http://localhost/student-attendance-portal/public](http://localhost/student-attendance-portal/public)

---

## 🔑 Default Login Credentials

> **Note:** These are demo seed credentials. Change them after first login.

| Role | Username / Email | Password / OTP |
|---|---|---|
| Admin | `admin@attendance.local` | `password123` |
| Teacher | `john@college.edu` | `password123` |
| Student | Use your PRN (`CS2022001`) | OTP sent to email (or Demo SMS mode) |

---

## 🌍 Live Server Deployment Guide (e.g., InfinityFree / cPanel)

The application features an **Auto-Detecting Configuration** system that automatically switches between XAMPP and Live Server databases without requiring code edits!

### 1. Database Setup
1. In your hosting panel, create a new MySQL Database.
2. Open **phpMyAdmin** on your server.
3. Import `database/schema.sql`. (Note: you may need to delete the `CREATE DATABASE` lines at the very top of the `.sql` files if your shared host restricts it).
4. Import `database/seed.sql`.

### 2. File Uploading (The Clean Way)
Many free servers fail when uploading thousands of tiny files. Use the ZIP method:
1. On your computer, highlight exactly these items: `app`, `database`, `public`, `vendor`, and `.htaccess`.
2. Zip them together into `upload.zip`.
3. Open your host's **File Manager** and go inside the `htdocs` (or `public_html`) folder.
4. Delete any default files (like `index2.html`).
5. Upload `upload.zip` and extract/unzip it natively inside the file manager.

### 3. Update the Live Constants
Open `app/config/constants.php` on your live server and update the `else` block to include your live database credentials and live domain URL. Make sure it uses `https://` if you enable a free SSL!

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8 (MVC architecture, no framework) |
| Database | MySQL with PDO prepared statements |
| Frontend | Bootstrap 5, Bootstrap Icons |
| Auth | Session-based RBAC + OTP login for students |
| Server | Apache via XAMPP |

---

## 🔒 Security Practices
- All DB queries use **PDO prepared statements** (SQL injection protection)
- **Role checks** on every controller method
- `constants.php` excluded from version control via `.gitignore`
- Security headers (X-Frame-Options, XSS-Protection, CSP) set in the front controller
- Direct file access blocked via `.htaccess` and PHP guards

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).
