<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../config/constants.php';

class Mailer {

    /**
     * Send OTP to a student's email address via Gmail SMTP
     */
    public static function sendOtp(string $toEmail, string $toName, string $otp): bool {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = MAIL_FROM_ADDRESS;
            $mail->Password   = MAIL_APP_PASSWORD;   // Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom(MAIL_FROM_ADDRESS, APP_NAME);
            $mail->addAddress($toEmail, $toName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for ' . APP_NAME;
            $mail->Body    = self::buildEmailBody($toName, $otp);
            $mail->AltBody = "Hello $toName,\n\nYour OTP is: $otp\n\nIt expires in " . OTP_EXPIRY_MINUTES . " minutes.\n\nDo not share this OTP with anyone.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('Mailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }

    private static function buildEmailBody(string $name, string $otp): string {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 480px; margin: auto; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;'>
            <div style='background: #1a56db; padding: 24px; text-align: center;'>
                <h2 style='color: white; margin: 0;'>🎓 Student Attendance Portal</h2>
            </div>
            <div style='padding: 32px;'>
                <p style='color: #374151; font-size: 16px;'>Hello, <strong>" . htmlspecialchars($name) . "</strong></p>
                <p style='color: #6b7280;'>Use the OTP below to log in. It is valid for <strong>" . OTP_EXPIRY_MINUTES . " minutes</strong>.</p>
                <div style='background: #f3f4f6; border-radius: 8px; padding: 24px; text-align: center; margin: 24px 0;'>
                    <span style='font-size: 40px; font-weight: bold; letter-spacing: 12px; color: #1a56db;'>$otp</span>
                </div>
                <p style='color: #ef4444; font-size: 13px;'>⚠️ Do not share this OTP with anyone. Our team will never ask for your OTP.</p>
            </div>
            <div style='background: #f9fafb; padding: 16px; text-align: center; color: #9ca3af; font-size: 12px;'>
                &copy; " . date('Y') . " " . APP_NAME . " &mdash; This is an automated email.
            </div>
        </div>";
    }
}
