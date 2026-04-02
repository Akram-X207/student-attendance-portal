<?php
require_once __DIR__ . '/../config/database.php';

class AttendanceModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Mark attendance for a student
     */
    public function markAttendance($student_id, $subject_id, $teacher_id, $date, $time, $status, $remarks = '') {
        $stmt = $this->db->prepare("
            INSERT INTO attendance (student_id, subject_id, teacher_id, date, attendance_time, status, remarks)
            VALUES (:student_id, :subject_id, :teacher_id, :date, :time, :status, :remarks)
            ON DUPLICATE KEY UPDATE 
                status = VALUES(status), 
                remarks = VALUES(remarks),
                teacher_id = VALUES(teacher_id)
        ");
        
        return $stmt->execute([
            ':student_id' => $student_id,
            ':subject_id' => $subject_id,
            ':teacher_id' => $teacher_id,
            ':date'       => $date,
            ':time'       => $time,
            ':status'     => $status,
            ':remarks'    => $remarks
        ]);
    }

    /**
     * Get attendance records for a specific subject on a specific date/time
     */
    public function getAttendanceByDateAndSubject($date, $time, $subject_id) {
        $stmt = $this->db->prepare("
            SELECT a.id, a.status, a.remarks, s.prn, s.name, s.id as student_id
            FROM attendance a
            JOIN students s ON a.student_id = s.id
            WHERE a.date = :date AND a.attendance_time = :time AND a.subject_id = :subject_id
            ORDER BY s.prn ASC
        ");
        $stmt->execute([':date' => $date, ':time' => $time, ':subject_id' => $subject_id]);
        return $stmt->fetchAll();
    }
}
