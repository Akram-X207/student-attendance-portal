<div align="center">
  <h1>🎓 Student Attendance Portal</h1>
  <p>A highly scalable, secure, and fully responsive MVC web application for institutional attendance tracking.</p>

  [![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
  [![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
  [![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
  [![License](https://img.shields.io/badge/License-MIT-success?style=for-the-badge)](LICENSE)

  ### 🌐 [View Live Demo](https://student-attendance-portal.great-site.net)
</div>

---

## 📑 Table of Contents
- [Overview](#-overview)
- [Key Features](#-key-features)
- [Architecture & Tech Stack](#-architecture--tech-stack)
- [Getting Started (Local Development)](#-getting-started-local-development)
- [Production Deployment](#-production-deployment)
- [Environment Configuration](#-environment-configuration)
- [Security Implementations](#-security-implementations)

---

## 🎯 Overview

The **Student Attendance Portal** is a role-based attendance management system designed to eliminate conventional paper-based tracking. Built entirely from scratch using a custom MVC PHP architecture, it enforces strict data normalization and offers an intuitive, touch-friendly UI for Admins, Faculty, and Students.

### 🔑 Demo Credentials
Access the [Live Demo](https://student-attendance-portal.great-site.net) using these seeded credentials:
- **Admin**: `admin@attendance.local` | `password123`
- **Teacher**: `john@college.edu` | `password123`
- **Student**: PRN `CS2022001` | *OTP via Email/Demo SMS*

---

## ✨ Key Features

### 🛡️ Secure Role-Based Access (RBAC)
- **Super Admins**: Full institutional oversight. Manage students, faculty, subjects, and course enrollments.
- **Faculty/Teachers**: Dedicated dashboards to log session attendance, manage multiple daily sessions (12-hour formatting), and generate deep analytical reports.
- **Students**: Self-service portal via 3-step OTP Wizard. Real-time access to personal attendance metrics, shortfalls, and historic records.

### 📱 Enterprise UI/UX
- **Responsive by Design**: 100% Mobile, Tablet, and Desktop compatible using Bootstrap 5.
- **Multi-Step OTP Login**: Students access the portal securely via Email OTP (PHPMailer) or a fallback on-screen Demo SMS module.
- **Smart Forms**: Auto-reloading asynchronous states to minimize faculty data entry time when switching dates or subjects.

---

## 🏗 Architecture & Tech Stack

The application does not rely on heavy third-party PHP frameworks like Laravel, ensuring maximum raw performance and deep customizability. 

* **Backend**: PHP 8.x (Custom MVC Router & Controllers)
* **Database**: MySQL 8+ (Normalized schema with strict foreign key constraints)
* **Query Builder**: Raw PDO with strict prepared statement enforcements
* **Frontend**: HTML5, Vanilla JavaScript, CSS3 variables, Bootstrap 5
* **Mail Delivery**: PHPMailer via Composer SMTP integration

---

## 💻 Getting Started (Local Development)

### Prerequisites
* PHP >= 8.0
* MySQL >= 8.0 (XAMPP/MAMP recommended)
* Composer (optional, for package management updates)

### Installation
1. **Clone the repository**
   ```bash
   git clone https://github.com/Akram-X207/student-attendance-portal.git
   cd student-attendance-portal
   ```
2. **Database Setup**
   - Create a database named `attendance_portal`.
   - Import the schema: `database/schema.sql`
   - Import the demo seed data: `database/seed.sql`

3. **Environment Setup**
   - Copy `app/config/constants.example.php` to `app/config/constants.php`.
   - The application features an **Auto-Detecting Configuration** block. Your local `localhost` settings are already pre-configured to hit XAMPP defaults seamlessly.

4. **Serve**
   Place the project directory in your `htdocs` or serve via PHP CLI:
   ```bash
   php -S localhost:8000 -t public
   ```

---

## 🚀 Production Deployment

This project is built to be deployed on any standard LAMP stack or shared hosting environment (cPanel, InfinityFree, Hostinger) with zero advanced server configurations.

1. **Database Migration**
   - Execute `schema.sql` and `seed.sql` inside your production phpMyAdmin. *(Note: Remove the `CREATE DATABASE` command from line 6 if your host restricts database creation via SQL).*
   
2. **Packaging**
   - To avoid FTP timeout errors on shared hosts, package your production files natively. Zip only the following: `app/`, `database/`, `public/`, `vendor/`, and `.htaccess`.
   
3. **Configuration Injection**
   - Modify your live server configuration block inside `app/config/constants.php` and ensure your `APP_URL` utilizes `https://` to prevent browser tracking blocks.

---

## 🔒 Security Implementations

* **SQL Injection Prevention**: 100% coverage using PDO Prepared Statements. No raw variables are ever concatenated into SQL strings.
* **Password Hashing**: `PASSWORD_BCRYPT` utilized for faculty and admin hashing.
* **Session Hijacking Defenses**: Built-in cookie pathing, `HttpOnly` flags, and `session_regenerate_id()` triggers upon state changes.
* **Route Protection**: The custom router blocks directory traversal (`../`) and enforces role-checks instantly at the Controller constructor level.
* **Environment Obfuscation**: Root directory `.htaccess` strictly funnels traffic to the `public/` directory, keeping `app/config` isolated from the web tree.

---

<div align="center">
  <p>Released under the <a href="LICENSE">MIT License</a>.</p>
</div>
