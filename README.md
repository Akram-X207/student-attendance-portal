# 🎓 Student Attendance Portal

A full-stack web application for managing student attendance across subjects, built with **PHP (MVC)**, **MySQL**, and **Bootstrap 5**. Supports role-based access for **Admins**, **Teachers**, and **Students**.

---

## ✨ Features

### 🔐 Role-Based Access Control
| Role | Capabilities |
|---|---|
| **Admin** | Manage students, teachers, subjects, and enrollments |
| **Teacher** | Mark session attendance (with date & 12-hour time), view reports, export CSV |
| **Student** | View personal attendance history with subject filtering |

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

## 🚀 Local Setup (XAMPP)

### 1. Prerequisites
- [XAMPP](https://www.apachefriends.org/) (PHP 8.0+, MySQL 5.7+)
- Git

### 2. Clone the Repository
```bash
git clone https://github.com/<your-username>/student-attendance-portal.git
cd student-attendance-portal
```

### 3. Place in XAMPP `htdocs`
Copy or clone the project into:
```
C:\xampp\htdocs\student-attendance-portal\
```

### 4. Configure the Database
1. Open **phpMyAdmin** → create a database named `attendance_portal`
2. Import the schema:
   ```
   database/schema.sql
   ```
3. *(Optional)* Import demo seed data:
   ```
   database/seed.sql
   ```

### 5. Set Up Configuration
```bash
cp app/config/constants.example.php app/config/constants.php
```
Then open `app/config/constants.php` and fill in your database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // your MySQL username
define('DB_PASS', '');           // your MySQL password
define('DB_NAME', 'attendance_portal');
```

### 6. Start Apache & MySQL
Launch XAMPP and start both **Apache** and **MySQL**.

### 7. Open in Browser
```
http://localhost/student-attendance-portal/public
```

---

## 🔑 Default Login Credentials

> **Note:** These are demo seed credentials. Change them after first login.

| Role | Username / PRN | Password / OTP |
|---|---|---|
| Admin | `admin@portal.com` | `admin123` |
| Teacher | `teacher@portal.com` | `teacher123` |
| Student | Use your PRN | OTP shown on screen (demo mode) |

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
