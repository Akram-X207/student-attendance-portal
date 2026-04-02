<?php
if (basename($_SERVER['PHP_SELF']) == 'session.php') { die('Direct access not permitted'); }
require_once __DIR__ . '/constants.php';

// Secure session startup
function start_session_securely() {
    if (session_status() === PHP_SESSION_NONE) {
        // Enforce strict session parameters
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_strict_mode', 1);
        // Only valid if using HTTPS
        // ini_set('session.cookie_secure', 1); 
        ini_set('session.cookie_httponly', 1); // Prevent JS access to session cookie
        ini_set('session.gc_maxlifetime', 3600); // 1-hour session lifetime
        ini_set('session.cookie_samesite', 'Lax'); // Protect against CSRF
        
        session_set_cookie_params([
            'lifetime' => 0,          // Until browser closes
            'path' => '/',
            'domain' => '',
            'secure' => false,        // Set true in prod with HTTPS
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        session_start();
        
        // Prevent session fixation by rotating IDs every 30 mins
        if (!isset($_SESSION['last_regeneration'])) {
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        } else {
            $interval = 60 * 30; // 30 minutes
            if (time() - $_SESSION['last_regeneration'] >= $interval) {
                session_regenerate_id(true);
                $_SESSION['last_regeneration'] = time();
            }
        }

        // Idle Timeout Check (e.g., 30 minutes of inactivity)
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
            session_unset();
            session_destroy();
            header("Location: " . APP_URL . "/login?timeout=1");
            exit;
        }
        $_SESSION['last_activity'] = time();
    }
}

// Function to check if user is authenticated
function check_auth() {
    start_session_securely();
    if (!isset($_SESSION['user_id']) || empty($_SESSION['role'])) {
        header("Location: " . APP_URL . "/login");
        exit;
    }
}

// Function to check if user has the correct role
function check_role($allowed_roles) {
    check_auth(); // verify logged in first
    
    $allowed = is_array($allowed_roles) ? $allowed_roles : [$allowed_roles];
    
    if (!in_array($_SESSION['role'], $allowed)) {
        http_response_code(403);
        die("403 Forbidden: You do not have permission to view this page. <a href='".APP_URL."'>Return Home</a>");
    }
}
