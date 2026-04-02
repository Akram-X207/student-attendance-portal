<?php
require_once __DIR__ . '/../models/StudentModel.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../helpers/Mailer.php';

class StudentController {
    
    /**
     * Handle PRN submission, OTP channel choice, and OTP verification
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            require_once __DIR__ . '/../views/auth/student_login.php';
            return;
        }

        $prn    = filter_input(INPUT_POST, 'prn',    FILTER_SANITIZE_STRING);
        $otp    = filter_input(INPUT_POST, 'otp',    FILTER_SANITIZE_STRING);
        $method = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING); // 'email' or 'sms'
        $step   = filter_input(INPUT_POST, 'step',   FILTER_SANITIZE_STRING); // 'find' | 'send' | 'verify'

        $studentModel = new StudentModel();
        $student = $studentModel->getByPrn($prn);

        if (!$student) {
            $error = "No student found with PRN <strong>$prn</strong>. Please check and try again.";
            require_once __DIR__ . '/../views/auth/student_login.php';
            return;
        }

        // ── STEP 1: Student entered PRN → show them their masked contact + channel choice ──
        if ($step === 'find') {
            $found_student = $student;
            require_once __DIR__ . '/../views/auth/student_login.php';
            return;
        }

        // ── STEP 2: Student chose a channel → generate & send OTP ──
        if ($step === 'send') {
            $otp_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // Store OTP in DB
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO otp_tokens (student_id, token, expires_at) VALUES (:sid, :token, DATE_ADD(NOW(), INTERVAL " . OTP_EXPIRY_MINUTES . " MINUTE))");
            $stmt->execute([':sid' => $student['id'], ':token' => $otp_code]);

            if ($method === 'email') {
                // REAL email via Gmail SMTP
                $sent = Mailer::sendOtp($student['email'], $student['name'], $otp_code);
                if ($sent) {
                    $success = "OTP sent to your email: <strong>" . self::maskEmail($student['email']) . "</strong>";
                } else {
                    $error = "Failed to send email. Please check mail configuration or try SMS.";
                    $found_student = $student;
                    require_once __DIR__ . '/../views/auth/student_login.php';
                    return;
                }
            } else {
                // SMS — Demo mode (show OTP on screen)
                $_SESSION['demo_otp'] = $otp_code;
                $success = "📱 SMS Demo Mode: Your OTP is <strong>$otp_code</strong> (shown here for demo purposes)";
            }

            $_SESSION['pending_prn']    = $prn;
            $_SESSION['otp_method']     = $method;
            $otp_sent     = true;
            $found_student = $student;
            require_once __DIR__ . '/../views/auth/student_login.php';
            return;
        }

        // ── STEP 3: Verify OTP ──
        if ($step === 'verify') {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT id FROM otp_tokens WHERE student_id = :sid AND token = :token AND used = 0 AND expires_at > NOW() ORDER BY created_at DESC LIMIT 1");
            $stmt->execute([':sid' => $student['id'], ':token' => $otp]);
            $token = $stmt->fetch();

            if ($token) {
                $db->prepare("UPDATE otp_tokens SET used = 1 WHERE id = :id")->execute([':id' => $token['id']]);
                start_session_securely();
                $_SESSION['user_id'] = $student['id'];
                $_SESSION['name']    = $student['name'];
                $_SESSION['role']    = ROLE_STUDENT;
                header("Location: " . APP_URL . "/student");
                exit;
            } else {
                $error = "Invalid or expired OTP. Please try again.";
                $otp_sent      = true;
                $found_student = $student;
                require_once __DIR__ . '/../views/auth/student_login.php';
                return;
            }
        }

        // Default: show login form
        require_once __DIR__ . '/../views/auth/student_login.php';
    }

    /**
     * Student Dashboard
     */
    public function dashboard() {
        check_role(ROLE_STUDENT);
        $student_id = $_SESSION['user_id'];
        
        $studentModel = new StudentModel();
        $student          = $studentModel->getById($student_id);
        $stats            = $studentModel->getStats($student_id);
        $attendanceRecords = $studentModel->getRawAttendance($student_id);
        
        require_once __DIR__ . '/../views/student/dashboard.php';
    }

    // ── Helpers ──────────────────────────────────────────────
    private static function maskEmail(string $email): string {
        [$local, $domain] = explode('@', $email);
        $masked = substr($local, 0, 2) . str_repeat('*', max(2, strlen($local) - 2));
        return $masked . '@' . $domain;
    }
}
