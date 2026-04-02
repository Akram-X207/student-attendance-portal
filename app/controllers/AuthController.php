<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../config/session.php';

class AuthController {
    
    // Process Admin/Teacher Login
    public function login() {
        // Start session if not started
        start_session_securely();
        
        // If already logged in, redirect based on role
        if (isset($_SESSION['user_id'])) {
            $this->redirectBasedOnRole($_SESSION['role']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Email and Password are required.";
                header("Location: " . APP_URL . "/login");
                exit;
            }

            $userModel = new UserModel();
            $user = $userModel->authenticate($email, $password);

            if ($user) {
                // Prevent session fixation
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['last_regeneration'] = time();

                $this->redirectBasedOnRole($user['role']);
            } else {
                $_SESSION['error'] = "Invalid email or password.";
                header("Location: " . APP_URL . "/login");
                exit;
            }
        } else {
            // GET request is handled by index.php now
            header("Location: " . APP_URL . "/login");
            exit;
        }
    }

    // Process Logout
    public function logout() {
        start_session_securely();
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        header("Location: " . APP_URL);
        exit;
    }

    private function redirectBasedOnRole($role) {
        if ($role === ROLE_ADMIN) {
            header("Location: " . APP_URL . "/admin");
        } else if ($role === ROLE_TEACHER) {
            header("Location: " . APP_URL . "/teacher");
        } else if ($role === ROLE_STUDENT) {
            header("Location: " . APP_URL . "/student");
        } else {
            header("Location: " . APP_URL);
        }
        exit;
    }
}
