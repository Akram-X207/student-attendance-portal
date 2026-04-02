<?php
// Prevent direct access
if (basename($_SERVER['PHP_SELF']) == 'constants.example.php') {
    die('Direct access not permitted');
}

// ============================================================
//  COPY THIS FILE TO constants.php AND FILL IN YOUR VALUES
// ============================================================

// Application settings
define('APP_NAME', 'Student Attendance Portal');

// Set your local URL — typically http://localhost/<folder>/public
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
define('APP_URL', $protocol . $host . '/student-attendance-portal/public');

define('ROOT_DIR', realpath(__DIR__ . '/../../'));

// --------------------------------------------------
// Database Configuration  ← FILL IN YOUR VALUES
// --------------------------------------------------
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_username');
define('DB_PASS', 'your_db_password');
define('DB_NAME', 'attendance_portal');

// Role constants (do not change)
define('ROLE_ADMIN',   'admin');
define('ROLE_TEACHER', 'teacher');
define('ROLE_STUDENT', 'student');

// Authentication settings
define('OTP_EXPIRY_MINUTES', 10);
