<?php
require_once __DIR__ . '/../models/AttendanceModel.php';
require_once __DIR__ . '/../config/session.php';

class AttendanceController {

    // Simple JSON API endpoint to mark attendance (used via fetch/AJAX)
    public function apiMark() {
        // Only teachers can mark attendance via this API
        check_role(ROLE_TEACHER);

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(["status" => "error", "message" => "Method Not Allowed"]);
            exit;
        }

        // Get POST body (assuming JSON payload for modern fetch API usage)
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);

        if (!isset($input['date']) || !isset($input['time']) || !isset($input['subject_id']) || !isset($input['records'])) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Missing required fields"]);
            exit;
        }

        $date = filter_var($input['date'], FILTER_SANITIZE_STRING);
        $time = filter_var($input['time'], FILTER_SANITIZE_STRING);
        $subject_id = filter_var($input['subject_id'], FILTER_VALIDATE_INT);
        $records = $input['records']; // Array of { student_id, status, remarks }
        $teacher_id = $_SESSION['user_id'];

        // Basic validation
        if (!$subject_id || empty($records) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid date/time format"]);
            exit;
        }

        $attendanceModel = new AttendanceModel();
        $successCount = 0;

        foreach ($records as $record) {
            $student_id = filter_var($record['student_id'], FILTER_VALIDATE_INT);
            $status = in_array($record['status'], ['present', 'absent', 'late', 'excused']) ? $record['status'] : 'absent';
            $remarks = filter_var($record['remarks'] ?? '', FILTER_SANITIZE_STRING);

            if ($student_id) {
                // Using ON DUPLICATE KEY UPDATE in the model handles updates automatically
                if ($attendanceModel->markAttendance($student_id, $subject_id, $teacher_id, $date, $time, $status, $remarks)) {
                    $successCount++;
                }
            }
        }

        echo json_encode([
            "status" => "success",
            "message" => "Successfully saved $successCount records for " . date('j M Y, h:i A', strtotime($date . ' ' . $time)),
            "updated_count" => $successCount
        ]);
        exit;
    }
}
