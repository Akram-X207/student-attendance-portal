<?php
require_once __DIR__ . '/../config/database.php';

class StudentModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Get all students enrolled in a specific subject
     */
    public function getBySubject($subject_id) {
        $stmt = $this->db->prepare("
            SELECT s.* 
            FROM students s
            JOIN student_subjects ss ON s.id = ss.student_id
            WHERE ss.subject_id = :subject_id AND s.is_active = 1
            ORDER BY s.prn ASC
        ");
        $stmt->execute([':subject_id' => $subject_id]);
        return $stmt->fetchAll();
    }

    /**
     * Get student by PRN
     */
    public function getByPrn($prn) {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE prn = :prn AND is_active = 1 LIMIT 1");
        $stmt->execute([':prn' => strtoupper($prn)]);
        return $stmt->fetch();
    }

    /**
     * Get student stats for dashboard
     */
    public function getStats($student_id) {
        $stmt = $this->db->prepare("
            SELECT 
                sub.name, sub.code,
                COUNT(att.id) as total_sessions,
                SUM(CASE WHEN att.status = 'present' THEN 1 ELSE 0 END) as attended_sessions
            FROM subjects sub
            JOIN student_subjects ss ON sub.id = ss.subject_id
            LEFT JOIN attendance att ON (sub.id = att.subject_id AND att.student_id = :sid1)
            WHERE ss.student_id = :sid2
            GROUP BY sub.id
        ");
        $stmt->execute([':sid1' => $student_id, ':sid2' => $student_id]);
        return $stmt->fetchAll();
    }

    /**
     * Get raw attendance records
     */
    public function getRawAttendance($student_id) {
        $stmt = $this->db->prepare("
            SELECT sub.id as subject_id, sub.name, sub.code, att.date, att.attendance_time, att.status
            FROM attendance att
            JOIN subjects sub ON att.subject_id = sub.id
            WHERE att.student_id = :sid
            ORDER BY att.date DESC, att.attendance_time DESC
        ");
        $stmt->execute([':sid' => $student_id]);
        return $stmt->fetchAll();
    }
    /**
     * Get student by ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Update student details
     */
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE students 
            SET prn = :prn, name = :name, email = :email, phone = :phone,
                faculty = :faculty, program = :program, year = :year, 
                semester = :semester, division = :division
            WHERE id = :id
        ");
        $data[':id'] = $id;
        return $stmt->execute($data);
    }

    /**
     * Delete student
     */
    public function delete($id) {
        // Option 1: Hard delete
        $stmt = $this->db->prepare("DELETE FROM students WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
