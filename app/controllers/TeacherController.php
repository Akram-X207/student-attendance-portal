<?php
require_once __DIR__ . '/../models/StudentModel.php';
require_once __DIR__ . '/../models/AttendanceModel.php';
require_once __DIR__ . '/../config/session.php';

class TeacherController {
    
    /**
     * Display teacher dashboard with assigned subjects
     */
    public function dashboard() {
        check_role(ROLE_TEACHER);
        $teacher_id = $_SESSION['user_id'];
        
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT s.* 
            FROM subjects s
            JOIN teacher_subjects ts ON s.id = ts.subject_id
            WHERE ts.teacher_id = :teacher_id
        ");
        $stmt->execute([':teacher_id' => $teacher_id]);
        $subjects = $stmt->fetchAll();

        // New Stats for Teacher Dashboard
        $stats = [
            'total_subjects' => count($subjects),
            'total_students' => 0,
            'last_session' => null,
            'at_risk' => []
        ];

        if ($stats['total_subjects'] > 0) {
            // Count total students enrolled (unique across all my subjects)
            $subjIds = array_column($subjects, 'id');
            $idsPlaceholders = implode(',', array_fill(0, count($subjIds), '?'));
            
            $stmt_count = $db->prepare("SELECT COUNT(DISTINCT student_id) FROM student_subjects WHERE subject_id IN ($idsPlaceholders)");
            $stmt_count->execute($subjIds);
            $stats['total_students'] = $stmt_count->fetchColumn();

            // Get last session
            $stmt_last = $db->prepare("
                SELECT a.date, a.attendance_time, s.name as sub_name 
                FROM attendance a 
                JOIN subjects s ON a.subject_id = s.id 
                WHERE a.teacher_id = ? 
                ORDER BY a.date DESC, a.attendance_time DESC LIMIT 1
            ");
            $stmt_last->execute([$teacher_id]);
            $stats['last_session'] = $stmt_last->fetch();

            $stats['last_session'] = $stmt_last->fetch();
        }
        
        require_once __DIR__ . '/../views/teacher/dashboard.php';
    }

    /**
     * Form to mark attendance for a subject
     */
    public function markAttendance() {
        check_role(ROLE_TEACHER);
        $teacher_id = $_SESSION['user_id'];
        $subject_id = filter_input(INPUT_GET, 'subject_id', FILTER_VALIDATE_INT);
        $date = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_STRING) ?? date('Y-m-d');
        $time = filter_input(INPUT_GET, 'time', FILTER_SANITIZE_STRING) ?? date('H:i');

        if (!$subject_id) {
            header("Location: " . APP_URL . "/teacher");
            exit;
        }

        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM subjects WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $subject_id]);
        $subject = $stmt->fetch();

        // Security check: teacher must be assigned to this subject
        $stmt_check = $db->prepare("SELECT id FROM teacher_subjects WHERE teacher_id = :tid AND subject_id = :sid");
        $stmt_check->execute([':tid' => $teacher_id, ':sid' => $subject_id]);
        if (!$stmt_check->fetch()) {
            $_SESSION['error'] = "Access denied for this subject.";
            header("Location: " . APP_URL . "/teacher");
            exit;
        }

        $studentModel = new StudentModel();
        $students = $studentModel->getBySubject($subject_id);

        $attendanceModel = new AttendanceModel();
        $existingRecords = $attendanceModel->getAttendanceByDateAndSubject($date, $time, $subject_id);
        $attendanceMap = [];
        foreach ($existingRecords as $rec) {
            $attendanceMap[$rec['student_id']] = [
                'status' => $rec['status'],
                'remarks' => $rec['remarks']
            ];
        }

        require_once __DIR__ . '/../views/teacher/mark_attendance.php';
    }

    /**
     * View detailed attendance report for a subject
     */
    public function viewReport() {
        check_role(ROLE_TEACHER);
        $subject_id = filter_input(INPUT_GET, 'subject_id', FILTER_VALIDATE_INT);
        if (!$subject_id) { header("Location: " . APP_URL . "/teacher"); exit; }

        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM subjects WHERE id = ?");
        $stmt->execute([$subject_id]);
        $subject = $stmt->fetch();

        // Get student list + their stats for this subject
        $stmt = $db->prepare("
            SELECT s.prn, s.name, 
                   COUNT(a.id) as total_sessions,
                   SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) as attended
            FROM students s
            JOIN student_subjects ss ON s.id = ss.student_id
            LEFT JOIN attendance a ON (s.id = a.student_id AND a.subject_id = ?)
            WHERE ss.subject_id = ?
            GROUP BY s.id
            ORDER BY s.prn ASC
        ");
        $stmt->execute([$subject_id, $subject_id]);
        $records = $stmt->fetchAll();

        require_once __DIR__ . '/../views/teacher/view_report.php';
    }

    /**
     * Export attendance as CSV
     */
    public function exportCsv() {
        check_role(ROLE_TEACHER);
        $subject_id = filter_input(INPUT_GET, 'subject_id', FILTER_VALIDATE_INT);
        if (!$subject_id) die("Invalid Subject");

        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT s.prn, s.name, a.date, a.attendance_time, a.status, a.remarks 
            FROM attendance a
            JOIN students s ON a.student_id = s.id
            WHERE a.subject_id = :sid AND a.status IN ('present', 'absent')
            ORDER BY a.date DESC, a.attendance_time DESC, s.prn ASC
        ");
        $stmt->execute([':sid' => $subject_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $filename = "attendance_subject_" . $subject_id . "_" . date('Y-m-d') . ".csv";

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['PRN', 'Student Name', 'Date', 'Time', 'Status', 'Remarks']);

        foreach ($rows as $row) {
            $row['attendance_time'] = date('h:i A', strtotime($row['attendance_time']));
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }
}
