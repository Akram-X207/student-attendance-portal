# 🎓 Student Attendance Portal (SAP)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)
[![Bootstrap](https://img.shields.io/badge/UI-Bootstrap%205-563d7c.svg)](https://getbootstrap.com)
[![Live Demo](https://img.shields.io/badge/Live-Demo-brightgreen.svg)](https://student-attendance-portal.great-site.net)

A modern, high-performance **Attendance Management System** designed for colleges and universities. Built with a custom PHP MVC architecture, it features a sleek responsive UI, dual-mode OTP authentication, and multi-session attendance tracking.

---

## 💎 Project Overview
This portal was developed to bridge the gap between manual attendance entry and digital record-keeping. It provides a seamless experience for administrators, faculty members, and students alike.

### ✨ Key Features:
-   **🔐 Multi-Role Security**: Role-based access for Admin, Teacher, and Student.
-   **📱 OTP Entry (Student)**: Passwordless login via **Real Email OTP** (Gmail SMTP) or **Demo SMS OTP** for testing.
-   **📅 Multi-Session Marking**: Supports multiple daily sessions for the same subject.
-   **📊 Dynamic Reporting**: Real-time attendance percentage and detailed records for students and teachers.
-   **🎯 Admin Control**: Full management of students, faculty assignments, and subjects.
-   **🌈 Premium UI**: Responsive design inspired by Supabase, fully optimized for mobile devices.

---

## 📂 Project Architecture
The project follows a modular **MVC (Model-View-Controller)** pattern for clean separation of concerns, making it highly scalable for future developments.

```text
student-attendance-portal/
├── app/
│   ├── config/        # Environment & Database settings
│   ├── controllers/   # Business logic (Routing handlers)
│   ├── helpers/       # Mailer, Validator, and Session utils
│   ├── models/        # Database queries (PDO-based)
│   └── views/         # UI templates (Admin, Teacher, Student)
├── database/
│   ├── schema.sql     # Final production table structure
│   └── seed.sql       # Realistic university data (Students, Faculty)
├── public/
│   ├── assets/        # CSS, Custom Fonts (Inter), Icons
│   ├── .htaccess      # Frontend controller routing logic
│   └── index.php      # Main application entry point
├── vendor/            # Dependencies (PHPMailer)
└── README.md          # Project Documentation
```

---

## 🗺️ Local Setup Instructions (XAMPP)
Getting the portal up and running locally is simple! Follow these 5 steps:

### 1. 📥 Clone the Project:
Clone this repository to your `C:\xampp\htdocs\` folder:
```bash
cd C:\xampp\htdocs
git clone https://github.com/Akram-X207/student-attendance-portal.git
```

### 2. 🗄️ Database Import:
-   Start **XAMPP MySQL** and open [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
-   Create a new database named **`attendance_portal`**.
-   Import the `database/schema.sql` file first.
-   Import the `database/seed.sql` file second to populate initial data.

### 3. ⚙️ Configuration:
Open `app/config/constants.php` and verify the **Local XAMPP Settings** (Line 15):
```php
define('APP_URL', 'http://localhost/student-attendance-portal/public');
```

### 4. 🚀 Launch:
Open your browser and visit:  
👉 **[http://localhost/student-attendance-portal/public](http://localhost/student-attendance-portal/public)**

---

## 👩‍💻 Usage & Test Credentials
To test the full capability of the system, use these predefined accounts:

| Role | Username / Email | Password |
| :--- | :--- | :--- |
| **Super Admin** | `admin@attendance.local` | `password123` |
| **Professor** | `namdev.faculty@jspmuni` | `password123` |
| **Student (PRN)** | `22358010004` (Shaikh Akram) | *Demo OTP on Screen* |

---

## 🚀 Live Environment
The project is live and fully functional on our demo server:  
🔗 **[https://student-attendance-portal.great-site.net](https://student-attendance-portal.great-site.net)**

---

## 📜 License
Licensed under the **MIT License**.  
Feel free to use and modify the code for your own educational projects! **Credit is appreciated** if you find this project helpful.

Developed with ❤️ by **[Shaikh Akram](https://github.com/Akram-X207)** 🎓🤖
