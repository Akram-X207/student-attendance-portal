<?php
require_once __DIR__ . '/../models/StudentModel.php';
require_once __DIR__ . '/../config/session.php';

class StudentController {
    
    /**
     * Handle PRN submission and OTP generation
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            require_once __DIR__ . '/../views/auth/student_login.php';
            return;
        }

        $prn = filter_input(INPUT_POST, 'prn', FILTER_SANITIZE_STRING);
        $otp = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_STRING);

        $studentModel = new StudentModel();
        $student = $studentModel->getByPrn($prn);

        if (!$student) {
            $error = "Student with PRN $prn not found.";
            require_once __DIR__ . '/../views/auth/student_login.php';
            return;
        }

        // Logic for OTP
        if (empty($otp)) {
            // STEP 1: Generate OTP
            $otp_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Store in database
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO otp_tokens (student_id, token, expires_at) VALUES (:sid, :token, DATE_ADD(NOW(), INTERVAL 10 MINUTE))");
            $stmt->execute([':sid' => $student['id'], ':token' => $otp_code]);

            // Simulation: In a real system, send email here.
            // For Phase 4 demo, we'll store it in session to "show" on login screen
            $_SESSION['demo_otp'] = $otp_code;
            $_SESSION['pending_prn'] = $prn;
            
            $success = "OTP has been sent to " . $student['email'] . " (Demo OTP: $otp_code)";
            require_once __DIR__ . '/../views/auth/student_login.php';
        } else {
            // STEP 2: Verify OTP
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT id FROM otp_tokens WHERE student_id = :sid AND token = :token AND used = 0 AND expires_at > NOW() ORDER BY created_at DESC LIMIT 1");
            $stmt->execute([':sid' => $student['id'], ':token' => $otp]);
            $token = $stmt->fetch();

            if ($token) {
                // Mark token as used
                $db->prepare("UPDATE otp_tokens SET used = 1 WHERE id = :id")->execute([':id' => $token['id']]);

                // Login
                start_session_securely();
                $_SESSION['user_id'] = $student['id'];
                $_SESSION['name'] = $student['name'];
                $_SESSION['role'] = ROLE_STUDENT;
                
                header("Location: " . APP_URL . "/student");
                exit;
            } else {
                $error = "Invalid or expired OTP.";
                require_once __DIR__ . '/../views/auth/student_login.php';
            }
        }
    }

    /**
     * Student Dashboard - View attendance stats
     */
    public function dashboard() {
        check_role(ROLE_STUDENT);
        $student_id = $_SESSION['user_id'];
        
        $studentModel = new StudentModel();
        $student = $studentModel->getById($student_id);
        $stats = $studentModel->getStats($student_id);
        $attendanceRecords = $studentModel->getRawAttendance($student_id);
        
        require_once __DIR__ . '/../views/student/dashboard.php';
    }
}
